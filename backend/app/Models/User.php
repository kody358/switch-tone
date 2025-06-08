<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'review_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'review_count' => 'integer',
        ];
    }

    /**
     * ユーザーのレビューを取得
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * ユーザーの公開済みレビューを取得
     */
    public function publishedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_published', true);
    }

    /**
     * ユーザーのレビューいいねを取得
     */
    public function reviewLikes(): HasMany
    {
        return $this->hasMany(ReviewLike::class);
    }
}
