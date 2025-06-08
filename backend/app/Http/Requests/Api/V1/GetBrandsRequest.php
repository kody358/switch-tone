<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GetBrandsRequest extends FormRequest
{
    /**
     * リクエストの認可を決定
     */
    public function authorize(): bool
    {
        return true; // パブリックAPIなので常に許可
    }

    /**
     * バリデーションルール（現時点では特にパラメータはないが、将来的な拡張に備える）
     */
    public function rules(): array
    {
        return [
            'sort' => 'nullable|string|in:name,created_at',
            'order' => 'nullable|string|in:asc,desc',
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'sort.in' => 'ソートフィールドは name, created_at のいずれかを指定してください。',
            'order.in' => 'ソート順序は asc または desc を指定してください。',
        ];
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