<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // 会員登録画面として使うビューを教える
        Fortify::registerView(fn() => view('auth.register'));

        // 新規ユーザーを作るロジックを教える
        Fortify::createUsersUsing(CreateNewUser::class);
    }
}
