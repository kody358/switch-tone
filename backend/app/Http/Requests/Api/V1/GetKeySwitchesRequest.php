<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GetKeySwitchesRequest extends FormRequest
{
    /**
     * リクエストの認可を決定
     */
    public function authorize(): bool
    {
        return true; // パブリックAPIなので常に許可
    }

    /**
     * バリデーションルール
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255',
            'type' => 'nullable|string',
            'brand' => 'nullable|string',
            'price' => 'nullable|string',
            'sort' => 'nullable|string|in:name,price,created_at',
            'order' => 'nullable|string|in:asc,desc',
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'search.max' => '検索キーワードは255文字以内で入力してください。',
            'sort.in' => 'ソートフィールドは name, price, created_at のいずれかを指定してください。',
            'order.in' => 'ソート順序は asc または desc を指定してください。',
        ];
    }

    /**
     * 検索キーワードを取得
     */
    public function getSearch(): ?string
    {
        return $this->input('search');
    }

    /**
     * タイプフィルターを配列で取得
     */
    public function getTypes(): array
    {
        $types = $this->input('type');
        return $types ? (is_array($types) ? $types : explode(',', $types)) : [];
    }

    /**
     * ブランドフィルターを配列で取得
     */
    public function getBrands(): array
    {
        $brands = $this->input('brand');
        return $brands ? (is_array($brands) ? $brands : explode(',', $brands)) : [];
    }

    /**
     * 価格フィルターを配列で取得
     */
    public function getPriceFilters(): array
    {
        $prices = $this->input('price');
        return $prices ? (is_array($prices) ? $prices : explode(',', $prices)) : [];
    }

    /**
     * ソートフィールドを取得
     */
    public function getSortBy(): string
    {
        return $this->input('sort', 'name');
    }

    /**
     * ソート順序を取得
     */
    public function getSortOrder(): string
    {
        return $this->input('order', 'asc');
    }
} 