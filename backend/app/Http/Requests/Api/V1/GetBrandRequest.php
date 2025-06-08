<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GetBrandRequest extends FormRequest
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
            'slugOrId' => 'required|string',
        ];
    }

    /**
     * リクエストデータの準備
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slugOrId' => $this->route('slugOrId'),
        ]);
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'slugOrId.required' => 'ブランドのIDまたはスラッグが必要です。',
        ];
    }

    /**
     * ブランドのスラッグまたはIDを取得
     */
    public function getSlugOrId(): string
    {
        return $this->route('slugOrId');
    }
} 