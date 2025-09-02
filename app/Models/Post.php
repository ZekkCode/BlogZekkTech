<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    // Untuk mendapatkan kategori pertama dalam kasus eager loading
    public function getCategoryAttribute()
    {
        return $this->categories->first();
    }

    /**
     * Get all comments for the post
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get approved parent comments for the post
     */
    public function approvedComments()
    {
        return $this->hasMany(Comment::class)
                    ->where('is_approved', true)
                    ->whereNull('parent_id')
                    ->with(['user', 'replies.user'])
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Get total comments count (including replies)
     */
    public function getCommentsCountAttribute(): int
    {
        return $this->comments()->where('is_approved', true)->count();
    }
}
