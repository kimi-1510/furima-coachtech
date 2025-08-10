<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;

class CategorySeeder extends Seeder
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
        Category::truncate();

        // 一時的に無効化した外部キー制約を元に戻す
        Schema::enableForeignKeyConstraints();

        // カテゴリー名
        $categories = [
            'ファッション',
            '家電',
            'インテリア',
            'レディース',
            'メンズ',
            'コスメ',
            '本',
            'ゲーム',
            'スポーツ',
            'キッチン',
            'ハンドメイド',
            'アクセサリー',
            'おもちゃ',
            'ベビー・キッズ',
        ];

        // 配列をループして登録
        foreach ($categories as $name) {
            Category::create(['name' => $name,]);
        }
    }
}

