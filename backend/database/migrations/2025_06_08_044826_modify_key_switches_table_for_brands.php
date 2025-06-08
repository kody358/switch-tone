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
        Schema::table('key_switches', function (Blueprint $table) {
            // ブランドIDの外部キーを追加
            $table->foreignId('brand_id')->nullable()->after('id')->constrained('brands')->onDelete('cascade')->comment('ブランドID');
            
            // 既存のbrandカラムを一時的に残す（後でデータ移行後に削除）
            
            // インデックスを追加
            $table->index('brand_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('key_switches', function (Blueprint $table) {
            // 外部キー制約とカラムを削除
            $table->dropForeign(['brand_id']);
            $table->dropIndex(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};
