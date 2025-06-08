<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KeySwitchResource extends JsonResource
{
    /**
     * キーボードスイッチリソースを配列に変換
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand->name, // フロントエンドの期待形式に合わせる
            'brand_details' => new BrandResource($this->whenLoaded('brand')),
            'type' => $this->type,
            'price' => (float) $this->price, // フロントエンドでは数値として期待
            'imageUrl' => $this->image_url, // フロントエンドのフィールド名に合わせる
            'description' => $this->description,
            'operating_force' => (float) $this->operating_force,
            'bottom_out_force' => (float) $this->bottom_out_force,
            'total_travel' => (float) $this->total_travel,
            'is_active' => $this->is_active,
            'createdAt' => $this->created_at, // フロントエンドのフィールド名に合わせる
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
