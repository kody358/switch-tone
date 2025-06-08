<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'password.required' => 'パスワードは必須です。',
        ];
    }

    /**
     * メールアドレスを取得
     */
    public function getEmail(): string
    {
        return $this->input('email');
    }

    /**
     * パスワードを取得
     */
    public function getPassword(): string
    {
        return $this->input('password');
    }

    /**
     * Remember me フラグを取得
     */
    public function getRemember(): bool
    {
        return $this->boolean('remember', false);
    }
} 