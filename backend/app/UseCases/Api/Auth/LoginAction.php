<?php

namespace App\UseCases\Api\Auth;

use App\Models\User;
use App\UseCases\Api\Auth\Models\LoginInput;
use App\UseCases\Api\Auth\Models\LoginOutput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginAction
{
    /**
     * ログインを実行
     */
    public function __invoke(LoginInput $input): LoginOutput
    {
        // ユーザー取得
        $user = User::where('email', $input->email)->first();

        // ユーザー存在チェックとパスワード確認
        if (!$user || !Hash::check($input->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['メールアドレスまたはパスワードが正しくありません。']
            ]);
        }

        // 既存のトークンを削除（オプション）
        $user->tokens()->delete();

        // 新しいAPIトークン生成
        $tokenName = $input->remember ? 'remember-token' : 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return new LoginOutput(
            user: $user,
            token: $token,
            message: 'ログインが完了しました'
        );
    }
} 