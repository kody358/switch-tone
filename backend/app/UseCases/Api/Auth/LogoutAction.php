<?php

namespace App\UseCases\Api\Auth;

use App\Models\User;

class LogoutAction
{
    /**
     * ログアウトを実行
     */
    public function __invoke(User $user): string
    {
        // 現在のユーザーのトークンを削除
        $user->currentAccessToken()->delete();

        return 'ログアウトが完了しました';
    }
} 