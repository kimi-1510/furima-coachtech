<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;

// ==============================
// ユーザー認証・プロフィール関連
// ==============================

// 新規ユーザー登録画面の表示
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');

// 入力データを受け取ってユーザー登録
Route::post('/register', [RegisteredUserController::class, 'store']);

// プロフィール編集画面の表示
Route::get('/mypage/profile', [ProfileController::class, 'profile'])
    ->middleware('auth')->name('mypage.profile'); // 認証済みユーザーのみアクセス可能

// プロフィール更新処理
Route::put('/mypage/profile', [ProfileController::class, 'update'])
    ->middleware('auth')->name('mypage.profile.update'); // 認証済みユーザーのみアクセス可能

// ==============================
// 商品関連
// ==============================

// 商品一覧画面（トップ画面）の表示
Route::get('/', [ProductController::class, 'index'])->name('products.index');

// 商品詳細画面の表示
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// ==============================
// 検索機能
// ==============================

// ヘッダー検索フォームからキーワードを受け取り、商品を検索
Route::get('/search', [SearchController::class, 'index'])->name('search');

// ==============================
// ログイン関連
// ==============================

// ログイン画面の表示
Route::get('/login', [LoginController::class, 'loginForm'])->name('login');

// ログイン処理
Route::post('/login', [LoginController::class, 'login']);

// ==============================
// いいね・コメント機能
// ==============================

// 商品にいいねをつける
Route::post('/products/{product}/like', [LikeController::class, 'store'])->middleware('auth')->name('products.like');

// 商品のいいねを解除する
Route::delete('/products/{product}/like', [LikeController::class, 'destroy'])->middleware('auth')->name('products.unlike');

// 商品にコメントを投稿する
Route::post('/products/{product}/comments', [CommentController::class, 'store'])->middleware('auth')->name('products.comments.store');