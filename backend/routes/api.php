<?php

use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\KeySwitchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| SwitchTone API routes for frontend integration.
|
*/

// 認証不要のパブリックAPI
Route::prefix('v1')->group(function () {
    
    // ブランド関連のエンドポイント
    Route::get('/brands', [BrandController::class, 'index']);
    Route::get('/brands/{slugOrId}', [BrandController::class, 'show']);
    Route::get('/brands/{slugOrId}/switches', [BrandController::class, 'switches']);
    
    // キーボードスイッチ関連のエンドポイント
    Route::get('/switches', [KeySwitchController::class, 'index']);
    Route::get('/switches/{id}', [KeySwitchController::class, 'show']);
    
});

// 認証が必要なAPI（将来的にレビュー機能などで使用）
Route::middleware('auth:sanctum')->prefix('v1')->group(function () {
    // 認証済みユーザー情報
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // 将来的にここにレビュー投稿などのエンドポイントを追加
}); 