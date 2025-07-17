<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 会員登録画面のビューを登録
        Fortify::registerView(fn() => view('auth.register'));

        // 新規ユーザーを作るロジックを指定
        Fortify::createUsersUsing(CreateNewUser::class);

        // ログイン画面のビューを登録
        Fortify::loginView(fn() => view('auth.login'));
    }
}
