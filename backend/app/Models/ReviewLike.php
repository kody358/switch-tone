<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewLike extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'review_id',
        'user_id',
    ];

    /**
     * キャストする属性
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * いいねが属するレビューを取得
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * いいねが属するユーザーを取得
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
