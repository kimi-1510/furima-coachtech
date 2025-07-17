<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 登録画面の表示
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// 入力データを受け取ってユーザー登録
Route::post('/register', [RegisteredUserController::class, 'store']);

// プロフィール編集画面の表示
Route::get('/mypage/profile', [ProfileController::class, 'profile'])->middleware('auth')->name('mypage.profile'); // 認証済みユーザーのみアクセス可能

// プロフィール更新処理
Route::put('/mypage/profile', [ProfileController::class, 'update'])->middleware('auth')->name('mypage.profile.update'); // 認証済みユーザーのみアクセス可能遷移遷移

// 商品一覧画面（トップ画面）の表示
Route::get('/', function () {
    return view('index');
});