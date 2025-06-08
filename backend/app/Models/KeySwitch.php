<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KeySwitch extends Model
{
    protected $fillable = [
        'brand_id',
        'name',
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
     * キーボードスイッチが属するブランドを取得
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

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
    public function scopeOfBrand($query, int $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    /**
     * ブランドスラッグでフィルタリングするスコープ
     */
    public function scopeOfBrandSlug($query, string $brandSlug)
    {
        return $query->whereHas('brand', function ($query) use ($brandSlug) {
            $query->where('slug', $brandSlug);
        });
    }

    /**
     * 価格範囲でフィルタリングするスコープ
     */
    public function scopeInPriceRange($query, ?float $minPrice = null, ?float $maxPrice = null)
    {
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }
}
