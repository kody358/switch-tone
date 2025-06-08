<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class GetKeySwitchRequest extends FormRequest
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
            'id' => 'required|integer|min:1',
        ];
    }

    /**
     * リクエストデータの準備
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'id.required' => 'キーボードスイッチのIDが必要です。',
            'id.integer' => 'キーボードスイッチのIDは整数である必要があります。',
            'id.min' => 'キーボードスイッチのIDは1以上である必要があります。',
        ];
    }

    /**
     * キーボードスイッチのIDを取得
     */
    public function getId(): int
    {
        return (int) $this->route('id');
    }
} 