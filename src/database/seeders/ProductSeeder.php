<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // ブランドを作成
        $rolax = Brand::firstOrCreate(['name' => 'Rolax']);
        $nishiba = Brand::firstOrCreate(['name' => '西芝']);
        $starbacks = Brand::firstOrCreate(['name' => 'Starbacks']);

        // 商品データ
        $products = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand_id' => $rolax->id,
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'status' => '良好',
                'image' => 'product_images/腕時計.jpg',
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand_id' => $nishiba->id,
                'description' => '高速で信頼性の高いハードディスク',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/HDD.jpg',
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand_id' => null,
                'description' => '新鮮な玉ねぎ3束のセット',
                'status' => 'やや傷や汚れあり',
                'image' => 'product_images/玉ねぎ3束.jpg',
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand_id' => null,
                'description' => 'クラシックなデザインの革靴',
                'status' => '状態が悪い',
                'image' => 'product_images/革靴.jpg',
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand_id' => null,
                'description' => '高性能なノートパソコン',
                'status' => '良好',
                'image' => 'product_images/ノートPC.jpg',
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand_id' => null,
                'description' => '高音質のレコーディング用マイク',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/マイク.jpg',
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand_id' => null,
                'description' => 'おしゃれなショルダーバッグ',
                'status' => 'やや傷や汚れあり',
                'image' => 'product_images/ショルダーバッグ.jpg',
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand_id' => null,
                'description' => '使いやすいタンブラー',
                'status' => '状態が悪い',
                'image' => 'product_images/タンブラー.jpg',
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand_id' => $starbacks->id,
                'description' => '手動のコーヒーミル',
                'status' => '良好',
                'image' => 'product_images/コーヒーミル.jpg',
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand_id' => null,
                'description' => '便利なメイクアップセット',
                'status' => '目立った傷や汚れなし',
                'image' => 'product_images/メイクセット.jpg',
            ],
        ];

        // 商品を登録（いったんuser_id=1で登録。必要に応じて変更）
        foreach ($products as $data) {
            Product::create(array_merge($data, [
                'user_id' => 1,
                'is_sold' => false,
            ]));
        }
    }
}
