/**
 * Comments System JavaScript
 * Handles all comment interactions including posting, liking, replying, and real-time updates
 */

class CommentsSystem {
    constructor(postId) {
        this.postId = postId;
        this.currentPage = 1;
        this.currentSort = 'newest';
        this.isLoading = false;
        this.isAuthenticated = window.isAuthenticated || false;
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadComments();
        this.setupEditor();
    }

    bindEvents() {
        // Form submission
        const form = document.getElementById('comment-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleSubmit(e));
        }

        // Sort change
        const sortSelect = document.getElementById('comments-sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => this.handleSortChange(e));
        }

        // Editor events
        const editor = document.getElementById('comment-editor');
        if (editor) {
            editor.addEventListener('input', () => this.updateCharacterCount());
            editor.addEventListener('paste', (e) => this.handlePaste(e));
        }

        // Toolbar buttons
        document.querySelectorAll('.toolbar-btn[data-command]').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleToolbarCommand(e));
        });

        // Cancel reply
        const cancelReplyBtn = document.getElementById('cancel-reply');
        if (cancelReplyBtn) {
            cancelReplyBtn.addEventListener('click', () => this.cancelReply());
        }

        // Load more button
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => this.loadMoreComments());
        }

        // Click outside to close menus
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.comment-options')) {
                document.querySelectorAll('.options-menu').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });
    }

    setupEditor() {
        const editor = document.getElementById('comment-editor');
        if (!editor) return;

        // Add keyboard shortcuts
        editor.addEventListener('keydown', (e) => {
            if (e.ctrlKey || e.metaKey) {
                switch (e.key) {
                    case 'b':
                        e.preventDefault();
                        this.execCommand('bold');
                        break;
                    case 'i':
                        e.preventDefault();
                        this.execCommand('italic');
                        break;
                    case 'u':
                        e.preventDefault();
                        this.execCommand('underline');
                        break;
                    case 'Enter':
                        e.preventDefault();
                        document.getElementById('comment-form').dispatchEvent(new Event('submit'));
                        break;
                }
            }
        });

        this.updateCharacterCount();
    }

    async loadComments(reset = true) {
        if (this.isLoading) return;
        
        this.isLoading = true;
        
        if (reset) {
            this.currentPage = 1;
            this.showLoading();
        }

        try {
            const response = await fetch(`/api/comments/post/${this.postId}?sort=${this.currentSort}&page=${this.currentPage}`);
            const data = await response.json();

            if (data.success) {
                if (reset) {
                    this.renderComments(data.data.comments, true);
                } else {
                    this.renderComments(data.data.comments, false);
                }
                
                this.updateCommentsCount(data.data.total_comments);
                this.updateLoadMoreButton(data.data.pagination);
            } else {
                this.showError('Failed to load comments');
            }
        } catch (error) {
            console.error('Error loading comments:', error);
            this.showError('Failed to load comments');
        } finally {
            this.isLoading = false;
            this.hideLoading();
        }
    }

    async loadMoreComments() {
        this.currentPage++;
        await this.loadComments(false);
    }

    renderComments(comments, reset = true) {
        const container = document.getElementById('comments-list');
        if (!container) return;

        if (reset) {
            container.innerHTML = '';
        }

        if (comments.length === 0 && reset) {
            container.innerHTML = `
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.451c-.905-.513-1.808-1.032-2.702-1.555L3 19l1.453-2.392C4.9 15.517 5.4 14.52 5.4 13.5 5.4 9.082 8.582 6 13 6s8 3.082 8 6z"/>
                    </svg>
                    <h4 class="text-lg font-medium mb-2" style="color: var(--text-primary);">No comments yet</h4>
                    <p class="text-sm" style="color: var(--text-secondary);">Be the first to start the conversation!</p>
                </div>
            `;
            return;
        }

        comments.forEach(comment => {
            const commentElement = this.createCommentElement(comment);
            container.appendChild(commentElement);
        });
    }

    createCommentElement(comment) {
        const template = document.getElementById('comment-template');
        const commentElement = template.content.cloneNode(true);
        
        // Set comment data
        const commentDiv = commentElement.querySelector('.comment-item');
        commentDiv.dataset.commentId = comment.id;
        
        // Avatar - Generate letter avatar
        const avatar = commentElement.querySelector('.comment-avatar');
        avatar.textContent = comment.user.name.charAt(0).toUpperCase();
        avatar.title = comment.user.name;
        
        // Generate consistent color based on username
        const colors = [
            'from-orange-400 to-red-500',
            'from-blue-400 to-indigo-500', 
            'from-green-400 to-emerald-500',
            'from-purple-400 to-pink-500',
            'from-yellow-400 to-orange-500',
            'from-cyan-400 to-blue-500'
        ];
        const colorIndex = this.hashCode(comment.user.name) % colors.length;
        avatar.className = `comment-avatar w-12 h-12 rounded-full bg-gradient-to-r ${colors[colorIndex]} flex items-center justify-center text-white font-semibold text-lg shadow-md`;
        
        // Username
        const username = commentElement.querySelector('.comment-username');
        username.textContent = comment.user.name;
        
        // Verified badge
        const verified = commentElement.querySelector('.comment-verified');
        if (comment.user.is_verified) {
            verified.classList.remove('hidden');
        }
        
        // Time
        const time = commentElement.querySelector('.comment-time');
        time.textContent = comment.time_ago;
        time.title = new Date(comment.created_at).toLocaleString();
        
        // Content
        const content = commentElement.querySelector('.comment-content');
        content.innerHTML = this.sanitizeHTML(comment.content);
        
        // Like button
        const likeBtn = commentElement.querySelector('.comment-like-btn');
        const likeCount = commentElement.querySelector('.like-count');
        likeCount.textContent = comment.likes || 0;
        
        if (comment.is_liked_by_user) {
            commentDiv.classList.add('comment-liked');
        }
        
        if (this.isAuthenticated) {
            likeBtn.addEventListener('click', () => this.toggleLike(comment.id, 'like'));
        } else {
            likeBtn.addEventListener('click', () => this.showLoginPrompt());
        }
        
        // Dislike button
        const dislikeBtn = commentElement.querySelector('.comment-dislike-btn');
        const dislikeCount = commentElement.querySelector('.dislike-count');
        dislikeCount.textContent = comment.dislikes || 0;
        
        if (comment.is_disliked_by_user) {
            commentDiv.classList.add('comment-disliked');
        }
        
        if (this.isAuthenticated) {
            dislikeBtn.addEventListener('click', () => this.toggleLike(comment.id, 'dislike'));
        } else {
            dislikeBtn.addEventListener('click', () => this.showLoginPrompt());
        }
        
        // Reply button
        const replyBtn = commentElement.querySelector('.comment-reply-btn');
        if (this.isAuthenticated) {
            replyBtn.addEventListener('click', () => this.startReply(comment.id, comment.user.name));
        } else {
            replyBtn.addEventListener('click', () => this.showLoginPrompt());
        }
        
        // Options menu
        const optionsBtn = commentElement.querySelector('.options-btn');
        const optionsMenu = commentElement.querySelector('.options-menu');
        const deleteBtn = commentElement.querySelector('.delete-comment-btn');
        
        optionsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            // Hide other menus
            document.querySelectorAll('.options-menu').forEach(menu => {
                if (menu !== optionsMenu) menu.classList.add('hidden');
            });
            optionsMenu.classList.toggle('hidden');
        });
        
        // Show delete button only for comment owner or admin
        if (this.isAuthenticated && (comment.user_id === window.currentUserId || window.isAdmin)) {
            deleteBtn.addEventListener('click', () => this.deleteComment(comment.id));
        } else {
            deleteBtn.style.display = 'none';
        }
        
        // Render replies
        if (comment.replies && comment.replies.length > 0) {
            const repliesContainer = commentElement.querySelector('.comment-replies');
            comment.replies.forEach(reply => {
                const replyElement = this.createCommentElement(reply);
                repliesContainer.appendChild(replyElement);
            });
        }
        
        return commentElement;
    }

    async handleSubmit(e) {
        e.preventDefault();
        
        if (!this.isAuthenticated) {
            this.showLoginPrompt();
            return;
        }

        const editor = document.getElementById('comment-editor');
        const content = this.getEditorContent();
        const parentId = document.getElementById('parent-comment-id').value;
        
        if (!content.trim()) {
            this.showError('Please write a comment');
            return;
        }

        if (content.length > 2000) {
            this.showError('Comment is too long (max 2000 characters)');
            return;
        }

        this.setSubmitLoading(true);

        try {
            const formData = new FormData();
            formData.append('content', content);
            if (parentId) {
                formData.append('parent_id', parentId);
            }

            const response = await fetch(`/api/comments/post/${this.postId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showSuccess('Comment posted successfully!');
                this.clearEditor();
                this.cancelReply();
                
                // If it's a reply, find the parent comment and add the reply
                if (parentId) {
                    this.addReplyToComment(parentId, data.data);
                } else {
                    // Reload comments to show the new comment
                    await this.loadComments();
                }
            } else {
                this.showError(data.message || 'Failed to post comment');
            }
        } catch (error) {
            console.error('Error posting comment:', error);
            this.showError('Failed to post comment');
        } finally {
            this.setSubmitLoading(false);
        }
    }

    async toggleLike(commentId, type) {
        if (!this.isAuthenticated) {
            this.showLoginPrompt();
            return;
        }

        try {
            const response = await fetch(`/api/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ type })
            });

            const data = await response.json();

            if (data.success) {
                this.updateCommentLikes(commentId, data.data);
            } else {
                this.showError(data.message || 'Failed to update like');
            }
        } catch (error) {
            console.error('Error toggling like:', error);
            this.showError('Failed to update like');
        }
    }

    async deleteComment(commentId) {
        if (!confirm('Are you sure you want to delete this comment?')) {
            return;
        }

        try {
            const response = await fetch(`/api/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();

            if (data.success) {
                this.removeCommentElement(commentId);
                this.showSuccess('Comment deleted successfully');
            } else {
                this.showError(data.message || 'Failed to delete comment');
            }
        } catch (error) {
            console.error('Error deleting comment:', error);
            this.showError('Failed to delete comment');
        }
    }

    startReply(commentId, username) {
        document.getElementById('parent-comment-id').value = commentId;
        document.getElementById('reply-username').textContent = username;
        document.getElementById('reply-info').classList.remove('hidden');
        document.getElementById('comment-editor').focus();
    }

    cancelReply() {
        document.getElementById('parent-comment-id').value = '';
        document.getElementById('reply-info').classList.add('hidden');
    }

    handleSortChange(e) {
        this.currentSort = e.target.value;
        this.loadComments();
    }

    handleToolbarCommand(e) {
        e.preventDefault();
        const command = e.currentTarget.dataset.command;
        this.execCommand(command);
    }

    execCommand(command) {
        document.execCommand(command);
        this.updateToolbarState();
    }

    updateToolbarState() {
        document.querySelectorAll('.toolbar-btn[data-command]').forEach(btn => {
            const command = btn.dataset.command;
            if (document.queryCommandState(command)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    handlePaste(e) {
        e.preventDefault();
        const text = e.clipboardData.getData('text/plain');
        document.execCommand('insertText', false, text);
        this.updateCharacterCount();
    }

    getEditorContent() {
        const editor = document.getElementById('comment-editor');
        return editor.textContent || editor.innerText || '';
    }

    clearEditor() {
        const editor = document.getElementById('comment-editor');
        editor.innerHTML = '';
        this.updateCharacterCount();
    }

    updateCharacterCount() {
        const content = this.getEditorContent();
        const count = content.length;
        const counter = document.getElementById('character-count');
        
        if (counter) {
            counter.textContent = `${count}/2000`;
            counter.style.color = count > 2000 ? 'var(--red-600)' : 'var(--text-secondary)';
        }
    }

    updateCommentLikes(commentId, data) {
        const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
        if (!commentElement) return;

        const likeBtn = commentElement.querySelector('.comment-like-btn');
        const dislikeBtn = commentElement.querySelector('.comment-dislike-btn');
        const likeCount = commentElement.querySelector('.like-count');
        const dislikeCount = commentElement.querySelector('.dislike-count');
        
        // Add pulse animation to the clicked button
        const clickedBtn = data.user_action === 'like' ? likeBtn : dislikeBtn;
        if (clickedBtn) {
            clickedBtn.style.transform = 'scale(1.2)';
            setTimeout(() => {
                clickedBtn.style.transform = '';
            }, 150);
        }
        
        // Update counts with smooth animation
        this.animateCountChange(likeCount, data.likes_count);
        this.animateCountChange(dislikeCount, data.dislikes_count);

        // Update active states with visual feedback
        commentElement.classList.remove('comment-liked', 'comment-disliked');
        likeBtn.classList.remove('active');
        dislikeBtn.classList.remove('active');
        
        if (data.user_action === 'like') {
            commentElement.classList.add('comment-liked');
            likeBtn.classList.add('active');
            // Add subtle success animation
            this.showFeedbackAnimation(likeBtn, 'success');
        } else if (data.user_action === 'dislike') {
            commentElement.classList.add('comment-disliked');
            dislikeBtn.classList.add('active');
            // Add subtle success animation
            this.showFeedbackAnimation(dislikeBtn, 'success');
        }
    }

    animateCountChange(element, newCount) {
        element.style.transform = 'scale(1.1)';
        element.style.fontWeight = 'bold';
        
        setTimeout(() => {
            element.textContent = newCount;
            element.style.transform = '';
            element.style.fontWeight = '';
        }, 100);
    }

    showFeedbackAnimation(element, type) {
        const originalBg = element.style.backgroundColor;
        const feedbackColor = type === 'success' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)';
        
        element.style.backgroundColor = feedbackColor;
        element.style.transition = 'background-color 0.3s ease';
        
        setTimeout(() => {
            element.style.backgroundColor = originalBg;
        }, 300);
    }

    addReplyToComment(parentId, reply) {
        const parentElement = document.querySelector(`[data-comment-id="${parentId}"]`);
        if (!parentElement) return;

        const repliesContainer = parentElement.querySelector('.comment-replies');
        const replyElement = this.createCommentElement(reply);
        repliesContainer.appendChild(replyElement);
    }

    removeCommentElement(commentId) {
        const commentElement = document.querySelector(`[data-comment-id="${commentId}"]`);
        if (commentElement) {
            commentElement.remove();
        }
    }

    updateCommentsCount(count) {
        const badge = document.getElementById('comments-count');
        if (badge) {
            badge.textContent = count;
        }
    }

    updateLoadMoreButton(pagination) {
        const container = document.getElementById('load-more-container');
        if (!container) return;

        if (pagination.current_page < pagination.last_page) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }

    setSubmitLoading(loading) {
        const submitBtn = document.getElementById('submit-comment');
        const submitText = submitBtn.querySelector('.submit-text');
        const submitLoading = submitBtn.querySelector('.submit-loading');

        if (loading) {
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            submitLoading.classList.remove('hidden');
        } else {
            submitBtn.disabled = false;
            submitText.classList.remove('hidden');
            submitLoading.classList.add('hidden');
        }
    }

    showLoading() {
    
        const loading = document.getElementById('comments-loading');
        if (loading) {
            loading.classList.remove('hidden');
        }
    }

    hideLoading() {
        const loading = document.getElementById('comments-loading');
        if (loading) {
            loading.classList.add('hidden');
        }
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg transition-all duration-300 transform translate-x-full ${
            type === 'error' ? 'bg-red-500 text-white' : 
            type === 'success' ? 'bg-green-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;

        document.body.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);

        // Auto remove
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 5000);
    }

    showLoginPrompt() {
        this.showNotification('Please login to interact with comments', 'info');
    }

    hashCode(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            const char = str.charCodeAt(i);
            hash = ((hash << 5) - hash) + char;
            hash = hash & hash; // Convert to 32-bit integer
        }
        return Math.abs(hash);
    }

    sanitizeHTML(html) {
        const div = document.createElement('div');
        div.textContent = html;
        return div.innerHTML;
    }
}

// Initialize comments system when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    const commentsSection = document.getElementById('comments-section');
    if (commentsSection && window.postId) {
        window.commentsSystem = new CommentsSystem(window.postId);
    }
});

// Export for global access
window.CommentsSystem = CommentsSystem;
