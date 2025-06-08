<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->comment('ブランド名');
            $table->string('slug')->unique()->comment('URLスラッグ');
            $table->string('logo_url')->nullable()->comment('ブランドロゴURL');
            $table->text('description')->nullable()->comment('ブランド説明');
            $table->string('website_url')->nullable()->comment('公式サイトURL');
            $table->string('country')->nullable()->comment('本社所在国');
            $table->boolean('is_active')->default(true)->comment('アクティブ状態');
            $table->timestamps();
            
            // よく使用されるクエリ用のインデックス
            $table->index('is_active');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
