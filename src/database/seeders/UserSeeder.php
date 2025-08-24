<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 管理者ユーザー
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'post_code' => '100-0001',
            'address' => '東京都千代田区千代田1-1',
            'building' => 'テストビル1F',
            'profile_image' => null,
        ]);

        // テスト用ユーザー1
        User::create([
            'name' => 'Test User 1',
            'email' => 'test1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'post_code' => '100-0002',
            'address' => '東京都千代田区千代田2-2',
            'building' => 'テストビル2F',
            'profile_image' => null,
        ]);

        // テスト用ユーザー2
        User::create([
            'name' => 'Test User 2',
            'email' => 'test2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'post_code' => '100-0003',
            'address' => '東京都千代田区千代田3-3',
            'building' => 'テストビル3F',
            'profile_image' => null,
        ]);

        // 一般ユーザー（購入テスト用）
        User::create([
            'name' => 'Customer User',
            'email' => 'customer@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'post_code' => '100-0004',
            'address' => '東京都千代田区千代田4-4',
            'building' => 'テストビル4F',
            'profile_image' => null,
        ]);

        // 販売者ユーザー（商品管理テスト用）
        User::create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'post_code' => '100-0005',
            'address' => '東京都千代田区千代田5-5',
            'building' => 'テストビル5F',
            'profile_image' => null,
        ]);
    }
}
