<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約を一時的に無効化
        Schema::disableForeignKeyConstraints();

        // 既存レコードをクリア（重複防止用）
        DB::table('category_product')->truncate();

        // 一時的に無効化した外部キー制約を元に戻す
        Schema::enableForeignKeyConstraints();

        // カテゴリーと商品の紐づけ
        DB::table('category_product')->insert([
            // 腕時計：メンズ、アクセサリー
            ['product_id' => 1, 'category_id' => 5],
            ['product_id' => 1, 'category_id' => 12],
            // HDD：家電
            ['product_id' => 2, 'category_id' => 2],
            // 玉ねぎ3束：キッチン
            ['product_id' => 3, 'category_id' => 10],
            // 革靴：ファッション、メンズ
            ['product_id' => 4, 'category_id' => 1],
            ['product_id' => 4, 'category_id' => 5],
            // ノートPC：家電
            ['product_id' => 5, 'category_id' => 2],
            // マイク：家電
            ['product_id' => 6, 'category_id' => 2],
            // ショルダーバッグ：ファッション、レディース
            ['product_id' => 7, 'category_id' => 1],
            ['product_id' => 7, 'category_id' => 4],
            // タンブラー：キッチン
            ['product_id' => 8, 'category_id' => 10],
            // コーヒーミル：キッチン
            ['product_id' => 9, 'category_id' => 10],
            // メイクセット：コスメ
            ['product_id' => 10, 'category_id' => 6],
        ]);
    }
}
