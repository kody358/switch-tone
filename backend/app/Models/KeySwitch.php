<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeySwitch extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'type',
        'price',
        'image_url',
        'description',
        'operating_force',
        'bottom_out_force',
        'total_travel',
        'is_active',
    ];


    protected $casts = [
        'price' => 'decimal:2',
        'operating_force' => 'decimal:2',
        'bottom_out_force' => 'decimal:2',
        'total_travel' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * キーボードスイッチのレビューを取得
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * キーボードスイッチの公開済みレビューを取得
     */
    public function publishedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_published', true);
    }

    /**
     * アクティブなスイッチのみを取得するスコープ
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * タイプでフィルタリングするスコープ
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * ブランドでフィルタリングするスコープ
     */
    public function scopeOfBrand($query, string $brand)
    {
        return $query->where('brand', $brand);
    }
}
