<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 既存のkey_switchesテーブルからユニークなブランド名を取得
        $uniqueBrands = DB::table('key_switches')
            ->select('brand')
            ->whereNotNull('brand')
            ->distinct()
            ->get();

        // brandsテーブルにブランドデータを挿入
        foreach ($uniqueBrands as $brandData) {
            $brandName = $brandData->brand;
            $slug = Str::slug($brandName);
            
            // 既に存在するかチェック
            $existingBrand = DB::table('brands')->where('slug', $slug)->first();
            
            if (!$existingBrand) {
                $brandId = DB::table('brands')->insertGetId([
                    'name' => $brandName,
                    'slug' => $slug,
                    'description' => $this->getBrandDescription($brandName),
                    'country' => $this->getBrandCountry($brandName),
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $brandId = $existingBrand->id;
            }

            // key_switchesテーブルのbrand_idを更新
            DB::table('key_switches')
                ->where('brand', $brandName)
                ->update(['brand_id' => $brandId]);
        }

        // 古いbrandカラムを削除
        Schema::table('key_switches', function (Blueprint $table) {
            $table->dropColumn('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // brandカラムを復元
        Schema::table('key_switches', function (Blueprint $table) {
            $table->string('brand')->nullable()->after('brand_id')->comment('製造メーカー・ブランド');
        });

        // データを復元
        $switches = DB::table('key_switches')
            ->join('brands', 'key_switches.brand_id', '=', 'brands.id')
            ->select('key_switches.id', 'brands.name as brand_name')
            ->get();

        foreach ($switches as $switch) {
            DB::table('key_switches')
                ->where('id', $switch->id)
                ->update(['brand' => $switch->brand_name]);
        }
    }

    /**
     * ブランドの説明を取得
     */
    private function getBrandDescription(string $brandName): ?string
    {
        $descriptions = [
            'HMX' => '高品質なカスタムスイッチで知られるブランド。滑らかな打鍵感と独特のサウンドが特徴。',
            'Gateron' => 'Cherry MX互換スイッチの老舗メーカー。幅広いラインナップを展開。',
            'Cherry' => 'メカニカルキーボードスイッチの元祖。MXシリーズで業界標準を確立。',
            'BSUN' => '革新的なスイッチ設計で注目されているブランド。',
            'KTT' => 'カラフルなスイッチデザインが特徴的なブランド。',
            'Akko' => 'コストパフォーマンスに優れたスイッチを提供。',
            'Keygeek' => 'ユニークなネーミングとサウンドプロファイルが特徴。',
            'Outemu' => 'エンスージアスト向けの高品質スイッチを製造。',
            'Drop' => 'コミュニティ主導で開発されたプレミアムスイッチブランド。',
            'UniKeys' => 'カスタムキーボード専門店のオリジナルスイッチ。',
        ];

        return $descriptions[$brandName] ?? null;
    }

    /**
     * ブランドの国を取得
     */
    private function getBrandCountry(string $brandName): ?string
    {
        $countries = [
            'HMX' => 'China',
            'Gateron' => 'China', 
            'Cherry' => 'Germany',
            'BSUN' => 'China',
            'KTT' => 'China',
            'Akko' => 'China',
            'Keygeek' => 'China',
            'Outemu' => 'China',
            'Drop' => 'USA',
            'UniKeys' => 'International',
        ];

        return $countries[$brandName] ?? null;
    }
};
