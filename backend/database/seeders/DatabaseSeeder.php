<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // サンプルキーボードスイッチデータを投入
        $this->call([
            SampleKeySwitchSeeder::class,
        ]);

        // テスト用ユーザーを作成
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'review_count' => 0,
        ]);

        // 追加のテストユーザー（オプション）
        // User::factory(10)->create();
    }
}
