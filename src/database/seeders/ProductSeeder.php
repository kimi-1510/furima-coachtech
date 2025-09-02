<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // ブランドテーブルは不要になったため、ブランド作成処理を削除

        // 商品データ（user_idとbrand_nameを含む）
        $products = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand_name' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status' => '良好',
                'image' => 'product_images/腕時計.jpg',
                'user_id' => 1, // Admin User
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand_name' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/HDD.jpg',
                'user_id' => 2, // Test User 1
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand_name' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status' => 'やや傷や汚れあり',
                'image' => 'product_images/玉ねぎ3束.jpg',
                'user_id' => 3, // Test User 2
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand_name' => null,
                'description' => 'クラシックなデザインの革靴',
                'status' => '状態が悪い',
                'image' => 'product_images/革靴.jpg',
                'user_id' => 4, // Customer User
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_name' => null,
                'description' => '高性能なノートパソコン',
                'status' => '良好',
                'image' => 'product_images/ノートPC.jpg',
                'user_id' => 5, // Seller User
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand_name' => null,
                'description' => '高音質のレコーディング用マイク',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/マイク.jpg',
                'user_id' => 1, // Admin User
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_name' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'status' => 'やや傷や汚れあり',
                'image' => 'product_images/ショルダーバッグ.jpg',
                'user_id' => 2, // Test User 1
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand_name' => null,
                'description' => '使いやすいタンブラー',
                'status' => '状態が悪い',
                'image' => 'product_images/タンブラー.jpg',
                'user_id' => 3, // Test User 2
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_name' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'status' => '良好',
                'image' => 'product_images/コーヒーミル.jpg',
                'user_id' => 4, // Customer User
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_name' => null,
                'description' => '便利なメイクアップセット',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/メイクセット.jpg',
                'user_id' => 5, // Seller User
            ],
        ];

        // 商品を登録
        foreach ($products as $data) {
            Product::create(array_merge($data, [
                'is_sold' => false,
            ]));
        }
    }
}
