<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get comments for a specific post
     */
    public function index(Request $request, Post $post): JsonResponse
    {
        try {
            $sort = $request->get('sort', 'newest'); // newest, oldest, popular

            $query = $post->comments()
                        ->approved()
                        ->parents()
                        ->with(['user', 'replies.user']); // limit depth to avoid heavy nesting

            // Apply sorting
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('likes', 'desc')
                          ->orderBy('created_at', 'desc');
                    break;
                default: // newest
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            $comments = $query->paginate(10);

            // Add user interaction data if authenticated
            if (Auth::check()) {
                $this->addUserInteractionData($comments->items());
            }

            // Optional: minimal transform to ensure JSON-safe payload
            $serialized = collect($comments->items())->map(function ($c) {
                return [
                    'id' => $c->id,
                    'user_id' => $c->user_id,
                    'content' => $c->content,
                    'created_at' => $c->created_at,
                    'time_ago' => method_exists($c, 'getTimeAgoAttribute') ? $c->time_ago : null,
                    'likes' => $c->likes,
                    'dislikes' => $c->dislikes,
                    'is_liked_by_user' => $c->is_liked_by_user ?? false,
                    'is_disliked_by_user' => $c->is_disliked_by_user ?? false,
                    'user' => $c->relationLoaded('user') && $c->user ? [
                        'id' => $c->user->id,
                        'name' => $c->user->name,
                        'avatar' => $c->user->avatar ?? null,
                    ] : null,
                    'replies' => $c->relationLoaded('replies') ? collect($c->replies)->map(function ($r) {
                        return [
                            'id' => $r->id,
                            'user_id' => $r->user_id,
                            'content' => $r->content,
                            'created_at' => $r->created_at,
                            'time_ago' => method_exists($r, 'getTimeAgoAttribute') ? $r->time_ago : null,
                            'likes' => $r->likes,
                            'dislikes' => $r->dislikes,
                            'is_liked_by_user' => $r->is_liked_by_user ?? false,
                            'is_disliked_by_user' => $r->is_disliked_by_user ?? false,
                            'user' => $r->relationLoaded('user') && $r->user ? [
                                'id' => $r->user->id,
                                'name' => $r->user->name,
                                'avatar' => $r->user->avatar ?? null,
                            ] : null,
                            'replies' => [], // limit nesting to 1 level for stability
                        ];
                    })->all() : [],
                ];
            })->all();

            return response()->json([
                'success' => true,
                'data' => [
                    'comments' => $serialized,
                    'pagination' => [
                        'current_page' => $comments->currentPage(),
                        'last_page' => $comments->lastPage(),
                        'total' => $comments->total(),
                        'per_page' => $comments->perPage(),
                    ],
                    'total_comments' => $post->comments()->where('is_approved', true)->count(),
                ]
            ]);
        } catch (\Throwable $e) {
            Log::error('Comments index failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to load comments',
            ], 500);
        }
    }

    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post): JsonResponse
    {
        // Ensure 'content' is present even if frontend uses alternate field name
        if (!$request->filled('content') && $request->filled('content_text')) {
            $request->merge(['content' => $request->input('content_text')]);
        }

        // Rate limiting: 5 comments per minute
        $key = 'comment:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many comments. Please try again later.'
            ], 429);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:2000|min:3',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Sanitize content (remove potentially harmful HTML)
        $content = strip_tags($request->input('content'), '<p><br><strong><em><u><a>');

        try {
            DB::beginTransaction();

            $comment = Comment::create([
                'user_id' => Auth::id(),
                'post_id' => $post->id,
                'parent_id' => $request->parent_id,
                'content' => $content,
                'is_approved' => true, // Auto-approve for now
            ]);

            // Load relationships
            $comment->load(['user', 'replies.user']);

            // Add user interaction data
            if (Auth::check()) {
                $this->addUserInteractionData([$comment]);
            }

            DB::commit();
            RateLimiter::hit($key, 60); // 1 minute decay

            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully',
                'data' => $comment
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to post comment'
            ], 500);
        }
    }

    /**
     * Like or unlike a comment
     */
    public function toggleLike(Request $request, Comment $comment): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:like,dislike'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid like type'
            ], 422);
        }

        try {
            DB::beginTransaction();

            $userId = Auth::id();
            $type = $request->type;

            // Check if user already has a like/dislike for this comment
            $existingLike = CommentLike::where('user_id', $userId)
                                     ->where('comment_id', $comment->id)
                                     ->first();

            if ($existingLike) {
                if ($existingLike->type === $type) {
                    // Same type - remove the like/dislike
                    $existingLike->delete();
                    $action = 'removed';
                } else {
                    // Different type - update the like/dislike
                    $existingLike->update(['type' => $type]);
                    $action = 'updated';
                }
            } else {
                // No existing like/dislike - create new one
                CommentLike::create([
                    'user_id' => $userId,
                    'comment_id' => $comment->id,
                    'type' => $type
                ]);
                $action = 'created';
            }

            // Update comment counts
            $likesCount = $comment->commentLikes()->where('type', 'like')->count();
            $dislikesCount = $comment->commentLikes()->where('type', 'dislike')->count();

            $comment->update([
                'likes' => $likesCount,
                'dislikes' => $dislikesCount
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ucfirst($type) . ' ' . $action,
                'data' => [
                    'likes_count' => $likesCount,
                    'dislikes_count' => $dislikesCount,
                    'user_action' => $action === 'removed' ? null : $type
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process like'
            ], 500);
        }
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment): JsonResponse
    {
        if ($comment->user_id !== Auth::id() && !Auth::user()->is_admin) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        try {
            // Soft delete by updating content
            $comment->update([
                'content' => '[Comment deleted by user]',
                'is_approved' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete comment'
            ], 500);
        }
    }

    /**
     * Add user interaction data to comments
     */
    private function addUserInteractionData(array $comments): void
    {
        if (empty($comments) || !Auth::check()) {
            return;
        }

        $userId = Auth::id();
        $commentIds = collect($comments)->pluck('id')->toArray();

        // Get user likes/dislikes for these comments
        $userLikes = CommentLike::where('user_id', $userId)
                               ->whereIn('comment_id', $commentIds)
                               ->get()
                               ->keyBy('comment_id');

        // Add interaction data to each comment
    foreach ($comments as $comment) {
            $userLike = $userLikes->get($comment->id);
            $comment->user_like_type = $userLike ? $userLike->type : null;
            $comment->is_liked_by_user = $userLike && $userLike->type === 'like';
            $comment->is_disliked_by_user = $userLike && $userLike->type === 'dislike';

            // Add interaction data to replies recursively
            if ($comment->replies && $comment->replies->count() > 0) {
        // Pass array of models, not array of arrays
        $this->addUserInteractionData($comment->replies->all());
            }
        }
    }
}
