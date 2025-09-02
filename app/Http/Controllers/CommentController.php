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
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get comments for a specific post
     */
    public function index(Request $request, Post $post): JsonResponse
    {
        $sort = $request->get('sort', 'newest'); // newest, oldest, popular

        $query = $post->comments()
                     ->approved()
                     ->parents()
                     ->with(['user', 'replies.user', 'replies.replies.user']);

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

        return response()->json([
            'success' => true,
            'data' => [
                'comments' => $comments->items(),
                'pagination' => [
                    'current_page' => $comments->currentPage(),
                    'last_page' => $comments->lastPage(),
                    'total' => $comments->total(),
                    'per_page' => $comments->perPage(),
                ],
                'total_comments' => $post->comments_count,
            ]
        ]);
    }

    /**
     * Store a new comment
     */
    public function store(Request $request, Post $post): JsonResponse
    {
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
                $this->addUserInteractionData($comment->replies->toArray());
            }
        }
    }
}
