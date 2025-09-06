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
        
        console.log(`Comments system initialized: postId=${postId}, authenticated=${this.isAuthenticated}`);
        
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadComments(); // Load comments regardless of auth status
        
        // Only setup editor if user is authenticated
        if (this.isAuthenticated) {
            this.setupEditor();
        }
    }

    bindEvents() {
        // Sort change - available for all users
        const sortSelect = document.getElementById('comments-sort');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => this.handleSortChange(e));
        }

        // Load more button - available for all users
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => this.loadMoreComments());
        }

        // Events only for authenticated users
        if (this.isAuthenticated) {
            // Form submission
            const form = document.getElementById('comment-form');
            if (form) {
                form.addEventListener('submit', (e) => this.handleSubmit(e));
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
            console.log(`Loading comments for post ${this.postId}`);
            const section = document.getElementById('comments-section');
            const base = section?.dataset?.commentsIndex || `/posts/${this.postId}/comments`;
            const url = `${base}${base.includes('?') ? '&' : '?'}sort=${this.currentSort}&page=${this.currentPage}`;
            const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await response.json().catch(() => ({ success: false }));

            console.log('Comments response:', data);

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
            if (commentElement) container.appendChild(commentElement);
        });
    }

    createCommentElement(comment) {
        const template = document.getElementById('comment-template');
        if (!template || !template.content || !template.content.firstElementChild) {
            console.warn('Comment template missing');
            return null;
        }
        // Clone the actual element instead of working with a fragment to avoid querySelector issues
        const commentDiv = template.content.firstElementChild.cloneNode(true);
        
        // Set comment data
        commentDiv.dataset.commentId = comment.id;
        
        // Avatar - Generate letter avatar (null-safe)
        const avatar = commentDiv.querySelector('.comment-avatar');
        const uname = (comment.user && comment.user.name) ? comment.user.name : 'U';
        if (avatar) {
            avatar.textContent = uname.charAt(0).toUpperCase();
            avatar.title = uname;
        }
        
        // Generate consistent color based on username
    // Keep Blade-provided avatar styles; only set initial if needed
        
        // Username (Blade uses .comment-author)
    const usernameEl = commentDiv.querySelector('.comment-author');
        if (usernameEl) usernameEl.textContent = comment.user?.name || 'User';

        // Verified badge (optional in template)
    const verified = commentDiv.querySelector('.comment-verified');
        if (verified && comment.user && comment.user.is_verified) {
            verified.classList.remove('hidden');
        }

        // Time (Blade uses .comment-date)
    const timeEl = commentDiv.querySelector('.comment-date');
        if (timeEl) {
            const when = (comment.time_ago || '').toString();
            timeEl.textContent = when;
            if (comment.created_at) {
                try { timeEl.title = new Date(comment.created_at).toLocaleString(); } catch (_) {}
            }
        }
        
        // Content
    const content = commentDiv.querySelector('.comment-content');
    if (content) content.innerHTML = this.sanitizeHTML(comment.content || '');
        
        // Like button
    const likeBtn = commentDiv.querySelector('.comment-like-btn');
    const likeCount = commentDiv.querySelector('.like-count');
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
    const dislikeBtn = commentDiv.querySelector('.comment-dislike-btn');
    const dislikeCount = commentDiv.querySelector('.dislike-count');
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
    const replyBtn = commentDiv.querySelector('.comment-reply-btn');
        if (this.isAuthenticated) {
            replyBtn.addEventListener('click', () => this.startReply(comment.id, comment.user.name));
        } else {
            replyBtn.addEventListener('click', () => this.showLoginPrompt());
        }
        
        // Options menu (opsional di template)
    const optionsBtn = commentDiv.querySelector('.options-btn');
    const optionsMenu = commentDiv.querySelector('.options-menu');
    const deleteBtn = commentDiv.querySelector('.delete-comment-btn');

        if (optionsBtn && optionsMenu) {
            optionsBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                // Hide other menus
                document.querySelectorAll('.options-menu').forEach(menu => {
                    if (menu !== optionsMenu) menu.classList.add('hidden');
                });
                optionsMenu.classList.toggle('hidden');
            });
        }

        // Delete button (opsional)
        if (deleteBtn) {
            if (this.isAuthenticated && (comment.user_id === window.currentUserId || window.isAdmin)) {
                deleteBtn.addEventListener('click', () => this.deleteComment(comment.id));
            } else {
                deleteBtn.style.display = 'none';
            }
        }
        
        // Render replies
        if (comment.replies && comment.replies.length > 0) {
            const repliesContainer = commentDiv.querySelector('.comment-replies');
            comment.replies.forEach(reply => {
                const replyElement = this.createCommentElement(reply);
                if (replyElement) repliesContainer.appendChild(replyElement);
            });
        }
        
        return commentDiv;
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

        const section = document.getElementById('comments-section');
        const storeUrl = section?.dataset?.commentsStore || `/posts/${this.postId}/comments`;
        const response = await fetch(storeUrl, {
                method: 'POST',
                body: formData,
                headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
                }
            });

        const data = await response.json().catch(() => ({ success: false }));

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
            const response = await fetch(`/comments/${commentId}/like`, {
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
            const response = await fetch(`/comments/${commentId}`, {
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
        const editor = document.getElementById('comment-editor');
        // Allow default paste for textarea; sanitize only for contenteditable
        if (editor && (editor.tagName === 'TEXTAREA' || editor.nodeName === 'TEXTAREA')) {
            // Let browser handle; optional: strip formatting not needed for textarea
            return;
        }
        e.preventDefault();
        const text = (e.clipboardData && e.clipboardData.getData('text/plain')) || '';
        document.execCommand('insertText', false, text);
        this.updateCharacterCount();
    }

    getEditorContent() {
        const editor = document.getElementById('comment-editor');
        if (!editor) return '';
        if (editor.tagName === 'TEXTAREA' || editor.nodeName === 'TEXTAREA') {
            return editor.value || '';
        }
        // contenteditable div/span
        return editor.textContent || editor.innerText || '';
    }

    clearEditor() {
        const editor = document.getElementById('comment-editor');
        if (!editor) return;
        if (editor.tagName === 'TEXTAREA' || editor.nodeName === 'TEXTAREA') {
            editor.value = '';
        } else {
            editor.innerHTML = '';
        }
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
        if (!submitBtn) return;
        const submitText = submitBtn.querySelector('.submit-text');
        const submitLoading = submitBtn.querySelector('.submit-loading');

        if (loading) {
            submitBtn.disabled = true;
            if (submitText) submitText.classList.add('hidden');
            if (submitLoading) submitLoading.classList.remove('hidden');
        } else {
            submitBtn.disabled = false;
            if (submitText) submitText.classList.remove('hidden');
            if (submitLoading) submitLoading.classList.add('hidden');
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
        // Create login prompt modal
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4 shadow-xl">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Masuk Diperlukan</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Silakan masuk untuk berkomentar, menyukai, atau berinteraksi dengan postingan.</p>
                    <div class="flex space-x-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 font-medium">
                            Batal
                        </button>
                        <button onclick="window.location.href='/admin/login'" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg">
                            Masuk
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Remove modal when clicking outside
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.remove();
            }
        });
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
    if (!commentsSection) return;
    let pid = window.postId;
    if (!pid) {
        // Try dataset postId
        pid = commentsSection.dataset.postId;
        // Try to parse from comments index URL
        if (!pid && commentsSection.dataset.commentsIndex) {
            const m = commentsSection.dataset.commentsIndex.match(/\/posts\/(\d+)\/comments/);
            if (m) pid = m[1];
        }
    }
    if (pid) {
        window.commentsSystem = new CommentsSystem(pid);
    }
});

// Export for global access
window.CommentsSystem = CommentsSystem;
