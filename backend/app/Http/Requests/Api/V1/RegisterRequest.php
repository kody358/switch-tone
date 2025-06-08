<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    /**
     * バリデーションエラーメッセージ
     */
    public function messages(): array
    {
        return [
            'name.required' => '名前は必須です。',
            'name.max' => '名前は255文字以内で入力してください。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に使用されています。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.confirmed' => 'パスワード確認が一致しません。',
        ];
    }

    /**
     * 名前を取得
     */
    public function getName(): string
    {
        return $this->input('name');
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
     * パスワード確認を取得
     */
    public function getPasswordConfirmation(): string
    {
        return $this->input('password_confirmation', '');
    }
} 