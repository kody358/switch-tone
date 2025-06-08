<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Requests\Api\V1\RegisterRequest;
use App\Http\Resources\UserResource;
use App\UseCases\Api\Auth\LoginAction;
use App\UseCases\Api\Auth\LogoutAction;
use App\UseCases\Api\Auth\RegisterAction;
use App\UseCases\Api\Auth\Models\LoginInput;
use App\UseCases\Api\Auth\Models\RegisterInput;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly RegisterAction $registerAction,
        private readonly LoginAction $loginAction,
        private readonly LogoutAction $logoutAction,
    ) {}

    /**
     * ユーザー登録
     */
    public function register(RegisterRequest $request)
    {
        $input = new RegisterInput(
            name: $request->getName(),
            email: $request->getEmail(),
            password: $request->getPassword(),
            passwordConfirmation: $request->getPasswordConfirmation(),
        );

        $output = ($this->registerAction)($input);

        return responseSuccess([
            'user' => new UserResource($output->user),
            'token' => $output->token,
        ], $output->message);
    }

    /**
     * ログイン
     */
    public function login(LoginRequest $request)
    {
        $input = new LoginInput(
            email: $request->getEmail(),
            password: $request->getPassword(),
            remember: $request->getRemember(),
        );

        $output = ($this->loginAction)($input);

        return responseSuccess([
            'user' => new UserResource($output->user),
            'token' => $output->token,
        ], $output->message);
    }

    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        $message = ($this->logoutAction)($request->user());

        return responseSuccess([], $message);
    }

    /**
     * 認証済みユーザー情報を取得
     */
    public function me(Request $request)
    {
        return responseSuccess(
            new UserResource($request->user()),
            'ユーザー情報を取得しました'
        );
    }
} 