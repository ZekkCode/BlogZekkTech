<!-- Comments Section Component -->
<div id="comments-section" class="w-full mt-12">
    <!-- Comments Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Comments</h3>
            <span id="comments-count"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                {{ $post->comments_count ?? 0 }}
            </span>
        </div>

        <!-- Sort Dropdown -->
        <div class="relative">
            <select id="comments-sort"
                class="appearance-none bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 text-gray-900 dark:text-white">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="popular">Most Popular</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2">
                <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                </svg>
            </div>
        </div>
    </div>

    @auth
        <!-- User Info -->
        <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-400 to-red-500 flex items-center justify-center text-white text-sm font-medium">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        Commenting as: <span class="text-orange-600 dark:text-orange-400">{{ auth()->user()->name }}</span>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Comment Form -->
        <div class="mb-8">
            <form id="comment-form" class="space-y-4">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">
                <input type="hidden" name="parent_id" id="parent-comment-id">

                <!-- Rich Text Editor Container -->
                <div class="border border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden shadow-sm bg-white dark:bg-gray-900">
                    <!-- Simplified Toolbar - Only B, I, U -->
                    <div class="flex items-center gap-1 px-3 py-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-600">
                        <button type="button" class="toolbar-btn" data-command="bold" title="Bold (Ctrl+B)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"/>
                            </svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-command="italic" title="Italic (Ctrl+I)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 4h-9m4 16H5m4-8h4m-2-8l-2 16"/>
                            </svg>
                        </button>
                        <button type="button" class="toolbar-btn" data-command="underline" title="Underline (Ctrl+U)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5M12 3v12a4 4 0 0 0 4-4V3m-8 0v8a4 4 0 0 0 4 4V3"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Editor Area -->
                    <div id="comment-editor" contenteditable="true"
                        class="min-h-[100px] p-4 bg-white dark:bg-gray-900 focus:outline-none text-sm leading-relaxed text-gray-900 dark:text-white"
                        data-placeholder="Write your comment here..."></div>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between">
                    <div id="reply-info" class="hidden text-sm text-gray-500">
                        Replying to <span id="reply-username" class="font-medium"></span>
                        <button type="button" id="cancel-reply"
                            class="ml-2 text-orange-600 hover:text-orange-700">Cancel</button>
                    </div>

                    <div class="flex items-center gap-3 ml-auto">
                        <div id="character-count" class="text-xs text-gray-400">0/2000</div>
                        <button type="submit" id="submit-comment"
                            class="inline-flex items-center px-6 py-2 bg-orange-600 hover:bg-orange-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="submit-text">Post Comment</span>
                            <div class="submit-loading hidden">
                                <svg class="animate-spin h-4 w-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @else
        <!-- Login Prompt -->
        <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('login') }}" class="text-orange-600 hover:text-orange-700 font-medium">Login</a>
                or
                <a href="{{ route('register') }}" class="text-orange-600 hover:text-orange-700 font-medium">register</a>
                to leave a comment.
            </p>
        </div>
    @endauth

    <!-- Comments List -->
    <div id="comments-list" class="space-y-6">
        <!-- Comments will be loaded here via JavaScript -->
        <div id="comments-loading" class="flex items-center justify-center py-8">
            <svg class="animate-spin h-6 w-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Loading comments...</span>
        </div>
    </div>

    <!-- Load More Button -->
    <div id="load-more-container" class="hidden mt-6 text-center">
        <button id="load-more-btn"
            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 text-gray-700 dark:text-gray-300">
            Load More Comments
        </button>
    </div>
</div>

<!-- Comment Template (Hidden) -->
<template id="comment-template">
    <div class="comment-item bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-200">
        <div class="flex items-start gap-4">
            <!-- Avatar -->
            <div class="flex-shrink-0">
                <div class="comment-avatar w-12 h-12 rounded-full bg-gradient-to-r from-orange-400 to-red-500 flex items-center justify-center text-white font-semibold text-lg shadow-md">
                    <!-- Avatar letter will be set by JavaScript -->
                </div>
            </div>

            <!-- Comment Content -->
            <div class="flex-1 min-w-0">
                <!-- User Info & Time -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="comment-username font-semibold text-base text-gray-900 dark:text-white"></span>
                    <span class="comment-verified hidden">
                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <span class="comment-time text-sm font-medium text-gray-500 dark:text-gray-400"></span>
                </div>

                <!-- Comment Text -->
                <div class="comment-content text-base leading-relaxed mb-4 text-gray-900 dark:text-white"></div>

                <!-- Actions -->
                <div class="flex items-center gap-6">
                    <!-- Like Button -->
                    <button class="comment-like-btn flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all duration-200 group text-gray-500 dark:text-gray-400" title="Like this comment">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L9 7v13m-3-4h-2m0-3h2m0-3h2"/>
                        </svg>
                        <span class="like-count text-sm font-medium">0</span>
                    </button>

                    <!-- Dislike Button -->
                    <button class="comment-dislike-btn flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200 group text-gray-500 dark:text-gray-400" title="Dislike this comment">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018c.163 0 .326.02.485.06L17 4m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L15 17V4m-3 4H9m3 0h3m-3 0h3m-3 4h3"/>
                        </svg>
                        <span class="dislike-count text-sm font-medium">0</span>
                    </button>

                    <!-- Reply Button -->
                    <button class="comment-reply-btn px-3 py-1.5 text-sm font-medium text-orange-600 hover:text-orange-700 hover:bg-orange-50 dark:hover:bg-orange-900/20 rounded-lg transition-all duration-200">
                        Reply
                    </button>

                    <!-- Options Menu -->
                    <div class="relative comment-options ml-auto">
                        <button class="options-btn p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors duration-200 text-gray-500 dark:text-gray-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"/>
                            </svg>
                        </button>
                        <div class="options-menu hidden absolute right-0 mt-1 w-36 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-xl z-10">
                            <button class="delete-comment-btn w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors duration-200">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Replies Container -->
                <div class="comment-replies mt-6 ml-2 space-y-4 border-l-2 border-orange-200 dark:border-orange-800 pl-6">
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Clean styling for comments system */
#comment-editor:empty:before {
    content: attr(data-placeholder);
    color: #9ca3af;
    pointer-events: none;
    opacity: 0.7;
}

#comment-editor:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1);
}

.toolbar-btn {
    padding: 8px;
    border: none;
    background: transparent;
    color: #6b7280;
    border-radius: 6px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.toolbar-btn:hover {
    background-color: #f3f4f6;
    color: #374151;
}

.dark .toolbar-btn:hover {
    background-color: #374151;
    color: #f9fafb;
}

.toolbar-btn.active {
    background-color: #ea580c;
    color: white;
}

.comment-item:hover {
    transform: translateY(-2px);
}

.comment-like-btn.active,
.comment-dislike-btn.active {
    color: #ea580c !important;
    background-color: rgba(234, 88, 12, 0.1);
}

.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    color: white;
    font-weight: 500;
    z-index: 1000;
    transform: translateX(100%);
    transition: transform 0.3s ease;
}

.notification.show {
    transform: translateX(0);
}

.notification.success {
    background: linear-gradient(135deg, #10b981, #059669);
}

.notification.error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
}
</style>

<script>
// Initialize comments when page loads
document.addEventListener('DOMContentLoaded', function() {
    if (window.postId) {
        window.commentsSystem = new CommentsSystem(window.postId);
    }
});
</script>
