<!-- Comments Section Component -->
<div id="comments-section" class="w-full mt-12" data-comments-index="{{ route('comments.index', $post, false) }}"
    data-comments-store="{{ route('comments.store', $post, false) }}">
    <!-- Comments Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h3 class="text-xl font-semibold" style="color: var(--text-primary);">Comments</h3>
            <span id="comments-count" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                style="background-color: var(--accent-color); color: white;">
                {{ $post->comments_count ?? 0 }}
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative">
            <select id="comments-sort"
                class="appearance-none rounded-lg px-3 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                style="background-color: var(--bg-secondary); border: 1px solid var(--border-color); color: var(--text-primary);">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="popular">Most Popular</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                <svg class="fill-current h-4 w-4" style="color: var(--text-secondary);"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </div>

    @auth
        <!-- User Info -->
        <div class="mb-4 p-4 rounded-lg border"
            style="background-color: var(--bg-primary); border-color: var(--border-color);">
            <div class="flex items-center gap-3">
                @if(auth()->user()->avatar)
                    <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}"
                        class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-medium"
                        style="background: linear-gradient(135deg, var(--accent-color), #ef4444);">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1">
                    <p class="text-sm font-medium" style="color: var(--text-primary);">
                        Commenting as: <span style="color: var(--accent-color);">{{ auth()->user()->name }}</span>
                    </p>
                    <p class="text-xs" style="color: var(--text-secondary);">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Comment Form -->
        <div class="mb-8">
            <form id="comment-form" class="space-y-4" method="POST" action="{{ route('comments.store', $post) }}">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="parent_id" id="parent-comment-id">
                <input type="hidden" name="content" id="content-hidden" value="">

                <!-- Simple Text Area -->
                <div class="border rounded-lg" style="border-color: var(--border-color);">
                    <textarea id="comment-editor" placeholder="Write your comment here..." name="content_text"
                        class="w-full min-h-[100px] p-4 rounded-lg border-0 resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"
                        style="background-color: var(--bg-secondary); color: var(--text-primary);"
                        oninput="(function(el){var v=el.value||'';var cc=document.getElementById('character-count');if(cc){cc.textContent=v.length+'/2000';cc.style.color=v.length>1900?'#ef4444':'var(--text-secondary)';}var hid=document.getElementById('content-hidden');if(hid){hid.value=v;}})(this)"
                        maxlength="2000"></textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between">
                    <div id="reply-info" class="hidden text-sm" style="color: var(--text-secondary);">
                        Replying to <span id="reply-username" class="font-medium"></span>
                        <button type="button" id="cancel-reply" class="ml-2 hover:underline"
                            style="color: var(--accent-color);">Cancel</button>
                    </div>

                    <div class="flex items-center gap-3 ml-auto">
                        <div id="character-count" class="text-xs" style="color: var(--text-secondary);">0/2000</div>
                        <button type="submit" id="submit-comment"
                            class="btn-primary px-6 py-2 text-sm font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="submit-text">Post Comment</span>
                            <div class="submit-loading hidden">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Posting...
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <!-- Login Required Message -->
        <div class="mb-8 p-6 rounded-lg text-center"
            style="background-color: var(--bg-secondary); border: 1px solid var(--border-color);">
            <div class="mb-4">
                <svg class="mx-auto h-12 w-12" style="color: var(--accent-color);" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);">Join the Discussion!</h3>
            <p class="mb-4" style="color: var(--text-secondary);">
                Login untuk berkomentar dan berinteraksi dengan komunitas ZekkTech.
                Bagikan pendapat, diskusi, dan bertukar ide dengan sesama pembaca.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('user.login') }}" class="btn-primary px-6 py-2 text-sm font-medium">
                    Login untuk Berkomentar
                </a>
                <a href="{{ route('user.register') }}" class="btn-secondary px-6 py-2 text-sm font-medium">
                    Daftar Akun Baru
                </a>
            </div>
        </div>
    @endauth

    <!-- Comments List - Always visible -->
    <div id="comments-list" class="space-y-6">
        <!-- Comments will be loaded here via JavaScript -->
        <div id="comments-loading" class="flex items-center justify-center py-8">
            <svg class="animate-spin h-6 w-6" style="color: var(--accent-color);" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 818-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="ml-2 text-sm" style="color: var(--text-secondary);">Loading comments...</span>
        </div>
    </div>

    <!-- Load More Button -->
    <div id="load-more-container" class="hidden mt-6 text-center">
        <button id="load-more-btn" class="btn-secondary px-4 py-2 text-sm font-medium">
            Load More Comments
        </button>
    </div>
</div>

<!-- Comment Template (Hidden) -->
<template id="comment-template">
    <div class="comment-item rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-200 card">
        <!-- Comment Header -->
        <div class="flex items-start justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="comment-avatar w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium"
                    style="background: linear-gradient(135deg, var(--accent-color), #ef4444);">
                    <!-- Avatar content will be filled by JavaScript -->
                </div>
                <div>
                    <div class="comment-author font-medium text-sm" style="color: var(--text-primary);"></div>
                    <div class="comment-date text-xs" style="color: var(--text-secondary);"></div>
                </div>
            </div>
            <div class="comment-actions flex items-center gap-2">
                <!-- Actions will be filled by JavaScript -->
            </div>
        </div>

        <!-- Comment Content -->
        <div class="comment-content prose prose-sm max-w-none mb-4" style="color: var(--text-primary);">
            <!-- Content will be filled by JavaScript -->
        </div>

        <!-- Comment Footer -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button class="comment-like-btn flex items-center gap-1 text-sm hover:opacity-70 transition-opacity"
                    style="color: var(--text-secondary);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                        </path>
                    </svg>
                    <span class="like-count">0</span>
                </button>
                <button class="comment-dislike-btn flex items-center gap-1 text-sm hover:opacity-70 transition-opacity"
                    style="color: var(--text-secondary);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17">
                        </path>
                    </svg>
                    <span class="dislike-count">0</span>
                </button>
                <button class="comment-reply-btn text-sm hover:opacity-70 transition-opacity"
                    style="color: var(--accent-color);">
                    Reply
                </button>
            </div>
        </div>

        <!-- Replies Container -->
        <div class="comment-replies ml-6 mt-4 space-y-4">
            <!-- Replies will be inserted here -->
        </div>
    </div>
</template>

<style>
    /* Character count styling */
    #character-count {
        font-size: 0.75rem;
    }

    /* Comment styling */
    .comment-item:hover {
        transform: translateY(-1px);
    }

    .comment-like-btn.active,
    .comment-dislike-btn.active {
        color: var(--accent-color);
    }

    /* Notification styling */
    .notification {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1000;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }

    .notification.show {
        transform: translateX(0);
    }

    .notification.success {
        background-color: #10b981;
        color: white;
    }

    .notification.error {
        background-color: #ef4444;
        color: white;
    }
</style>

<script>
    // Set global variables for comments system
    window.postId = {{ $post->id }};
    window.isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    @auth
        window.currentUserId = {{ auth()->id() }};
        window.isAdmin = {{ auth()->user()->is_admin ? 'true' : 'false' }};
    @else
        window.currentUserId = null;
        window.isAdmin = false;
    @endauth

    // Lightweight UI init with safe fallback submission when CommentsSystem isn't present
    (function () {
        function setup() {
            const editor = document.getElementById('comment-editor');
            const counter = document.getElementById('character-count');
            const hiddenContent = document.getElementById('content-hidden');

            // Character counter + sync hidden content
            if (editor && counter) {
                const sync = () => {
                    const val = editor.value || '';
                    counter.textContent = `${val.length}/2000`;
                    counter.style.color = val.length > 1900 ? '#ef4444' : 'var(--text-secondary)';
                    if (hiddenContent) hiddenContent.value = val;
                };
                editor.addEventListener('input', sync);
                sync();
            }

            // Fallback submit via fetch only if CommentsSystem isn't loaded
            const form = document.getElementById('comment-form');
            if (form && typeof window.CommentsSystem === 'undefined') {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const tokenEl = document.querySelector('meta[name="csrf-token"]');
                    const token = tokenEl ? tokenEl.getAttribute('content') : '';
                    const formData = new FormData(form);
                    const content = editor ? (editor.value || '').trim() : '';
                    if (!content) { notify('Please write a comment', 'error'); return; }
                    if (content.length > 2000) { notify('Comment is too long (max 2000 characters)', 'error'); return; }
                    if (hiddenContent) formData.set('content', content); else formData.append('content', content);

                    toggleSubmit(true);
                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' },
                            body: formData
                        });
                        const data = await res.json().catch(() => null);
                        if (res.ok && data && data.success) {
                            if (editor) editor.value = '';
                            if (hiddenContent) hiddenContent.value = '';
                            if (counter) counter.textContent = '0/2000';
                            notify('Comment posted successfully!', 'success');
                            if (window.commentsSystem && typeof window.commentsSystem.loadComments === 'function') {
                                window.commentsSystem.loadComments(true);
                            }
                        } else {
                            notify((data && data.message) || 'Failed to post comment', 'error');
                        }
                    } catch (_) {
                        notify('Failed to post comment', 'error');
                    } finally {
                        toggleSubmit(false);
                    }
                });
            }

            function toggleSubmit(disabled) {
                const btn = document.getElementById('submit-comment');
                if (!btn) return;
                const t = btn.querySelector('.submit-text');
                const l = btn.querySelector('.submit-loading');
                btn.disabled = disabled;
                if (t) t.classList.toggle('hidden', disabled);
                if (l) l.classList.toggle('hidden', !disabled);
            }

            function notify(message, type) {
                const n = document.createElement('div');
                n.className = `notification ${type === 'error' ? 'error' : type === 'success' ? 'success' : 'info'}`;
                n.textContent = message;
                document.body.appendChild(n);
                requestAnimationFrame(() => n.classList.add('show'));
                setTimeout(() => {
                    n.classList.remove('show');
                    setTimeout(() => n.remove(), 300);
                }, 3000);
            }

            // Biarkan CommentsSystem diinisialisasi oleh bundle JS utama (resources/js/comments.js)
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', setup);
        } else {
            setup();
        }
    })();
</script>