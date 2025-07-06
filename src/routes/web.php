<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

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
