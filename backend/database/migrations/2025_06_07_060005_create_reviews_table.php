<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('key_switch_id')->constrained('key_switches')->onDelete('cascade')->comment('対象キーボードスイッチID');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('投稿ユーザーID');
            $table->integer('pitch')->comment('音の高低（-100〜100の範囲）');
            $table->integer('depth')->comment('音の厚み（-100〜100の範囲）');
            $table->text('text')->comment('レビュー本文');
            $table->unsignedInteger('likes_count')->default(0)->comment('いいね数');
            $table->boolean('is_published')->default(true)->comment('公開状態');
            $table->timestamps();
            
            // ユニーク制約：1ユーザーあたり1スイッチに1レビューまで
            $table->unique(['key_switch_id', 'user_id']);
            
            // よく使用されるクエリ用のインデックス
            $table->index(['key_switch_id', 'is_published']);
            $table->index(['user_id', 'is_published']);
            $table->index('is_published');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
