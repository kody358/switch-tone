<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo_url',
        'description',
        'website_url',
        'country',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * ブランドのキーボードスイッチを取得
     */
    public function keySwitches(): HasMany
    {
        return $this->hasMany(KeySwitch::class);
    }

    /**
     * ブランドのアクティブなキーボードスイッチを取得
     */
    public function activeKeySwitches(): HasMany
    {
        return $this->hasMany(KeySwitch::class)->where('is_active', true);
    }

    /**
     * アクティブなブランドのみを取得するスコープ
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * 国でフィルタリングするスコープ
     */
    public function scopeFromCountry($query, string $country)
    {
        return $query->where('country', $country);
    }

    /**
     * スラッグで検索するスコープ
     */
    public function scopeBySlug($query, string $slug)
    {
        return $query->where('slug', $slug);
    }

    /**
     * ブランドのキーボードスイッチ数を取得
     */
    public function getSwitchCountAttribute(): int
    {
        return $this->keySwitches()->count();
    }

    /**
     * ブランドのアクティブなキーボードスイッチ数を取得
     */
    public function getActiveSwitchCountAttribute(): int
    {
        return $this->activeKeySwitches()->count();
    }
}
