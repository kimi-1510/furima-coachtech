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

        // 商品とカテゴリーを名前で検索してIDを取得
        $watch = \App\Models\Product::where('name', '腕時計')->first();
        $hdd = \App\Models\Product::where('name', 'HDD')->first();
        $onion = \App\Models\Product::where('name', '玉ねぎ3束')->first();
        $shoes = \App\Models\Product::where('name', '革靴')->first();
        $laptop = \App\Models\Product::where('name', 'ノートPC')->first();
        $microphone = \App\Models\Product::where('name', 'マイク')->first();
        $bag = \App\Models\Product::where('name', 'ショルダーバッグ')->first();
        $tumbler = \App\Models\Product::where('name', 'タンブラー')->first();
        $coffeeMill = \App\Models\Product::where('name', 'コーヒーミル')->first();
        $makeupSet = \App\Models\Product::where('name', 'メイクセット')->first();

        $fashion = \App\Models\Category::where('name', 'ファッション')->first();
        $electronics = \App\Models\Category::where('name', '家電')->first();
        $ladies = \App\Models\Category::where('name', 'レディース')->first();
        $mens = \App\Models\Category::where('name', 'メンズ')->first();
        $cosmetics = \App\Models\Category::where('name', 'コスメ')->first();
        $kitchen = \App\Models\Category::where('name', 'キッチン')->first();
        $accessories = \App\Models\Category::where('name', 'アクセサリー')->first();

        // カテゴリーと商品の紐づけ
        DB::table('category_product')->insert([
            // 腕時計：メンズ、アクセサリー
            ['product_id' => $watch->id, 'category_id' => $mens->id],
            ['product_id' => $watch->id, 'category_id' => $accessories->id],
            // HDD：家電
            ['product_id' => $hdd->id, 'category_id' => $electronics->id],
            // 玉ねぎ3束：キッチン
            ['product_id' => $onion->id, 'category_id' => $kitchen->id],
            // 革靴：ファッション、メンズ
            ['product_id' => $shoes->id, 'category_id' => $fashion->id],
            ['product_id' => $shoes->id, 'category_id' => $mens->id],
            // ノートPC：家電
            ['product_id' => $laptop->id, 'category_id' => $electronics->id],
            // マイク：家電
            ['product_id' => $microphone->id, 'category_id' => $electronics->id],
            // ショルダーバッグ：ファッション、レディース
            ['product_id' => $bag->id, 'category_id' => $fashion->id],
            ['product_id' => $bag->id, 'category_id' => $ladies->id],
            // タンブラー：キッチン
            ['product_id' => $tumbler->id, 'category_id' => $kitchen->id],
            // コーヒーミル：キッチン
            ['product_id' => $coffeeMill->id, 'category_id' => $kitchen->id],
            // メイクセット：コスメ
            ['product_id' => $makeupSet->id, 'category_id' => $cosmetics->id],
        ]);
    }
}
