<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    protected $fillable = [
        'key_switch_id',
        'user_id',
        'pitch',
        'depth',
        'text',
        'likes_count',
        'is_published',
    ];
    
    protected $casts = [
        'pitch' => 'integer',
        'depth' => 'integer',
        'likes_count' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * レビューが属するキーボードスイッチを取得
     */
    public function keySwitch(): BelongsTo
    {
        return $this->belongsTo(KeySwitch::class);
    }

    /**
     * レビューが属するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * レビューのいいねを取得
     */
    public function likes(): HasMany
    {
        return $this->hasMany(ReviewLike::class);
    }

    /**
     * 公開済みレビューのみを取得するスコープ
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * キーボードスイッチでフィルタリングするスコープ
     */
    public function scopeForSwitch($query, int $keySwitchId)
    {
        return $query->where('key_switch_id', $keySwitchId);
    }

    /**
     * ユーザーでフィルタリングするスコープ
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * ユーザーがこのレビューにいいねしているかチェック
     */
    public function isLikedByUser(int $userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
