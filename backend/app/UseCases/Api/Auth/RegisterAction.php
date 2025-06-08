<?php

namespace App\UseCases\Api\Auth;

use App\Models\User;
use App\UseCases\Api\Auth\Models\RegisterInput;
use App\UseCases\Api\Auth\Models\RegisterOutput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterAction
{
    /**
     * ユーザー登録を実行
     */
    public function __invoke(RegisterInput $input): RegisterOutput
    {
        // パスワード確認チェック
        if ($input->password !== $input->passwordConfirmation) {
            throw ValidationException::withMessages([
                'password' => ['パスワード確認が一致しません。']
            ]);
        }

        // メールアドレスの重複チェック
        if (User::where('email', $input->email)->exists()) {
            throw ValidationException::withMessages([
                'email' => ['このメールアドレスは既に使用されています。']
            ]);
        }

        // ユーザー作成
        $user = User::create([
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'email_verified_at' => now(), // 今回は自動で認証済みにする
        ]);

        // API トークン生成
        $token = $user->createToken('api-token')->plainTextToken;

        return new RegisterOutput(
            user: $user,
            token: $token,
            message: 'ユーザー登録が完了しました'
        );
    }
} 