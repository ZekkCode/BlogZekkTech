<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
        'likes',
        'dislikes',
        'is_approved'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that the comment belongs to
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the parent comment
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies for the comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id')
                    ->with(['user', 'replies'])
                    ->orderBy('created_at', 'asc');
    }

    /**
     * Get all comment likes
     */
    public function commentLikes(): HasMany
    {
        return $this->hasMany(CommentLike::class);
    }

    /**
     * Get user's like for this comment
     */
    public function userLike(): HasOne
    {
        return $this->hasOne(CommentLike::class)
                    ->where('user_id', auth()->id());
    }

    /**
     * Check if user has liked this comment
     */
    public function isLikedByUser($userId = null): bool
    {
        $userId = $userId ?: auth()->id();
        
        return $this->commentLikes()
                    ->where('user_id', $userId)
                    ->where('type', 'like')
                    ->exists();
    }

    /**
     * Check if user has disliked this comment
     */
    public function isDislikedByUser($userId = null): bool
    {
        $userId = $userId ?: auth()->id();
        
        return $this->commentLikes()
                    ->where('user_id', $userId)
                    ->where('type', 'dislike')
                    ->exists();
    }

    /**
     * Scope to get only approved comments
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get only parent comments (not replies)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get formatted time ago
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get total likes count
     */
    public function getLikesCountAttribute(): int
    {
        return $this->commentLikes()->where('type', 'like')->count();
    }

    /**
     * Get total dislikes count
     */
    public function getDislikesCountAttribute(): int
    {
        return $this->commentLikes()->where('type', 'dislike')->count();
    }

    /**
     * Get replies count
     */
    public function getRepliesCountAttribute(): int
    {
        return $this->replies()->count();
    }
}
