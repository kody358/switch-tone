<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('review_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('review_id')->constrained('reviews')->onDelete('cascade')->comment('対象レビューID');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->comment('いいねしたユーザーID');
            $table->timestamp('created_at')->nullable()->comment('いいね日時');
            
            // ユニーク制約：1ユーザーあたり1レビューに1いいねまで
            $table->unique(['review_id', 'user_id']);
            
            // よく使用されるクエリ用のインデックス
            $table->index('review_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('review_likes');
    }
};
