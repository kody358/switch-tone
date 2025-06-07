<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('key_switches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('スイッチ名');
            $table->string('brand')->comment('製造メーカー・ブランド');
            $table->string('type', 50)->comment('スイッチタイプ（Linear, Tactile, Clicky）');
            $table->decimal('price', 8, 2)->nullable()->comment('価格');
            $table->string('image_url', 500)->nullable()->comment('商品画像URL');
            $table->text('description')->nullable()->comment('商品説明');
            $table->decimal('operating_force', 5, 2)->nullable()->comment('作動荷重（グラム）');
            $table->decimal('bottom_out_force', 5, 2)->nullable()->comment('底打荷重（グラム）');
            $table->decimal('total_travel', 4, 2)->nullable()->comment('総移動距離（ミリメートル）');
            $table->boolean('is_active')->default(true)->comment('アクティブ状態');
            $table->timestamps();
            
            // よく使用されるクエリ用のインデックス
            $table->index(['brand', 'type']);
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('key_switches');
    }
};
