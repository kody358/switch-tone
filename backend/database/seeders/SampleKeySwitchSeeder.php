<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\KeySwitch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SampleKeySwitchSeeder extends Seeder
{
    public function run(): void
    {
        // 既存データをクリア
        KeySwitch::truncate();
        Brand::truncate();

        // ブランドデータを作成
        $brands = $this->createBrands();

        // キーボードスイッチデータ
        $switches = [
            // HMX ブランド（人気No.1）
            [
                'name' => 'HMX Sillycon V2',
                'brand_name' => 'HMX',
                'type' => 'Linear',
                'price' => 850.00,
                'operating_force' => 45.00,
                'bottom_out_force' => 58.00,
                'total_travel' => 3.80,
                'description' => '滑らかな打鍵感で人気のリニアスイッチ。Thockyなサウンドプロファイル。',
                'is_active' => true,
            ],
            [
                'name' => 'HMX Cheese',
                'brand_name' => 'HMX',
                'type' => 'Linear',
                'price' => 720.00,
                'operating_force' => 42.00,
                'bottom_out_force' => 50.00,
                'total_travel' => 3.60,
                'description' => 'クリーミーで滑らかな打鍵感。軽めの荷重設定。',
                'is_active' => true,
            ],
            [
                'name' => 'HMX Cloud',
                'brand_name' => 'HMX',
                'type' => 'Linear',
                'price' => 680.00,
                'operating_force' => 50.00,
                'bottom_out_force' => 63.50,
                'total_travel' => 3.80,
                'description' => 'ふわりとした雲のような打鍵感。バランスの良い荷重。',
                'is_active' => true,
            ],

            // Gateron ブランド（定番）
            [
                'name' => 'Gateron Oil King',
                'brand_name' => 'Gateron',
                'type' => 'Linear',
                'price' => 950.00,
                'operating_force' => 55.00,
                'bottom_out_force' => 65.00,
                'total_travel' => 4.00,
                'description' => 'ファクトリールブされた高級リニアスイッチ。深いThockyサウンド。',
                'is_active' => true,
            ],
            [
                'name' => 'Gateron Yellow Pro',
                'brand_name' => 'Gateron',
                'type' => 'Linear',
                'price' => 420.00,
                'operating_force' => 50.00,
                'bottom_out_force' => 60.00,
                'total_travel' => 4.00,
                'description' => 'コストパフォーマンスに優れたリニアスイッチの定番。',
                'is_active' => true,
            ],

            // Cherry ブランド（老舗）
            [
                'name' => 'Cherry MX Red',
                'brand_name' => 'Cherry',
                'type' => 'Linear',
                'price' => 600.00,
                'operating_force' => 45.00,
                'bottom_out_force' => 58.00,
                'total_travel' => 4.00,
                'description' => 'メカニカルキーボードの代名詞。信頼性の高いリニアスイッチ。',
                'is_active' => true,
            ],
            [
                'name' => 'Cherry MX Blue',
                'brand_name' => 'Cherry',
                'type' => 'Tactile',
                'price' => 600.00,
                'operating_force' => 50.00,
                'bottom_out_force' => 60.00,
                'total_travel' => 4.00,
                'description' => 'カチカチとした打鍵音が特徴的なタクタイルスイッチ。',
                'is_active' => true,
            ],

            // BSUN ブランド
            [
                'name' => 'BSUN Ragdoll',
                'brand_name' => 'BSUN',
                'type' => 'Linear',
                'price' => 780.00,
                'operating_force' => 52.00,
                'bottom_out_force' => 63.00,
                'total_travel' => 3.70,
                'description' => 'ユニークなネーミングのリニアスイッチ。Clackyなサウンド。',
                'is_active' => true,
            ],

            // KTT ブランド
            [
                'name' => 'KTT Strawberry',
                'brand_name' => 'KTT',
                'type' => 'Linear',
                'price' => 650.00,
                'operating_force' => 43.00,
                'bottom_out_force' => 62.00,
                'total_travel' => 4.00,
                'description' => '甘いストロベリーカラーのリニアスイッチ。軽快な打鍵感。',
                'is_active' => true,
            ],

            // Akko ブランド
            [
                'name' => 'Akko Jelly Black',
                'brand_name' => 'Akko',
                'type' => 'Linear',
                'price' => 480.00,
                'operating_force' => 50.00,
                'bottom_out_force' => 60.00,
                'total_travel' => 3.30,
                'description' => 'コストパフォーマンスに優れたリニアスイッチ。',
                'is_active' => true,
            ],

            // Keygeek ブランド
            [
                'name' => 'Keygeek Briny',
                'brand_name' => 'Keygeek',
                'type' => 'Linear',
                'price' => 720.00,
                'operating_force' => 48.00,
                'bottom_out_force' => 58.00,
                'total_travel' => 3.80,
                'description' => '海の波をイメージしたリニアスイッチ。Deep サウンドプロファイル。',
                'is_active' => true,
            ],

            // タクタイルスイッチのサンプル
            [
                'name' => 'Outemu U4T',
                'brand_name' => 'Outemu',
                'type' => 'Tactile',
                'price' => 550.00,
                'operating_force' => 62.00,
                'bottom_out_force' => 68.00,
                'total_travel' => 3.50,
                'description' => '明確なタクタイルバンプが特徴。Thockyサウンド。',
                'is_active' => true,
            ],

            // サイレントスイッチのサンプル
            [
                'name' => 'Gateron Silent Red',
                'brand_name' => 'Gateron',
                'type' => 'Linear',
                'price' => 580.00,
                'operating_force' => 45.00,
                'bottom_out_force' => 58.00,
                'total_travel' => 4.00,
                'description' => '静音リング付きのサイレントリニアスイッチ。オフィス環境に最適。',
                'is_active' => true,
            ],

            // プレミアムスイッチ
            [
                'name' => 'Holy Panda',
                'brand_name' => 'Drop',
                'type' => 'Tactile',
                'price' => 1200.00,
                'operating_force' => 67.00,
                'bottom_out_force' => 78.00,
                'total_travel' => 4.00,
                'description' => 'エンスージアスト向けプレミアムタクタイルスイッチ。カスタム界の聖杯。',
                'is_active' => true,
            ],

            // 一部在庫切れサンプル
            [
                'name' => 'Limited Edition Special',
                'brand_name' => 'UniKeys',
                'type' => 'Linear',
                'price' => 1500.00,
                'operating_force' => 55.00,
                'bottom_out_force' => 65.00,
                'total_travel' => 3.80,
                'description' => '限定版スペシャルエディション（現在在庫切れ）',
                'is_active' => false,
            ],
        ];

        // キーボードスイッチを作成
        foreach ($switches as $switchData) {
            $brandName = $switchData['brand_name'];
            unset($switchData['brand_name']);
            
            // ブランドIDを取得
            $brand = $brands[$brandName];
            $switchData['brand_id'] = $brand->id;
            
            KeySwitch::create($switchData);
        }
    }

    /**
     * ブランドデータを作成
     */
    private function createBrands(): array
    {
        $brandData = [
            'HMX' => [
                'name' => 'HMX',
                'slug' => 'hmx',
                'description' => '高品質なカスタムスイッチで知られるブランド。滑らかな打鍵感と独特のサウンドが特徴。',
                'country' => 'China',
                'website_url' => null,
                'is_active' => true,
            ],
            'Gateron' => [
                'name' => 'Gateron',
                'slug' => 'gateron',
                'description' => 'Cherry MX互換スイッチの老舗メーカー。幅広いラインナップを展開。',
                'country' => 'China',
                'website_url' => 'https://www.gateron.com',
                'is_active' => true,
            ],
            'Cherry' => [
                'name' => 'Cherry',
                'slug' => 'cherry',
                'description' => 'メカニカルキーボードスイッチの元祖。MXシリーズで業界標準を確立。',
                'country' => 'Germany',
                'website_url' => 'https://www.cherry.de',
                'is_active' => true,
            ],
            'BSUN' => [
                'name' => 'BSUN',
                'slug' => 'bsun',
                'description' => '革新的なスイッチ設計で注目されているブランド。',
                'country' => 'China',
                'website_url' => null,
                'is_active' => true,
            ],
            'KTT' => [
                'name' => 'KTT',
                'slug' => 'ktt',
                'description' => 'カラフルなスイッチデザインが特徴的なブランド。',
                'country' => 'China',
                'website_url' => null,
                'is_active' => true,
            ],
            'Akko' => [
                'name' => 'Akko',
                'slug' => 'akko',
                'description' => 'コストパフォーマンスに優れたスイッチを提供。',
                'country' => 'China',
                'website_url' => 'https://en.akkogear.com',
                'is_active' => true,
            ],
            'Keygeek' => [
                'name' => 'Keygeek',
                'slug' => 'keygeek',
                'description' => 'ユニークなネーミングとサウンドプロファイルが特徴。',
                'country' => 'China',
                'website_url' => null,
                'is_active' => true,
            ],
            'Outemu' => [
                'name' => 'Outemu',
                'slug' => 'outemu',
                'description' => 'エンスージアスト向けの高品質スイッチを製造。',
                'country' => 'China',
                'website_url' => null,
                'is_active' => true,
            ],
            'Drop' => [
                'name' => 'Drop',
                'slug' => 'drop',
                'description' => 'コミュニティ主導で開発されたプレミアムスイッチブランド。',
                'country' => 'USA',
                'website_url' => 'https://drop.com',
                'is_active' => true,
            ],
            'UniKeys' => [
                'name' => 'UniKeys',
                'slug' => 'unikeys',
                'description' => 'カスタムキーボード専門店のオリジナルスイッチ。',
                'country' => 'International',
                'website_url' => 'https://unikeyboards.com',
                'is_active' => true,
            ],
        ];

        $brands = [];
        foreach ($brandData as $key => $data) {
            $brands[$key] = Brand::create($data);
        }

        return $brands;
    }
}
