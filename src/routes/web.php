<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\StripeController;

// ---------------------
// 認証不要：公開ページ
// ---------------------
Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/purchase', [ProductController::class, 'purchase'])->name('products.purchase');

Route::get('/search', [SearchController::class, 'index'])->name('search');

// Stripe Webhook（認証不要）
Route::post('/stripe/webhook', [StripeController::class, 'webhook'])->name('stripe.webhook');

// ---------------------
// ゲスト専用：ログイン/登録
// ---------------------
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

// ---------------------
// 認証済み専用：マイページ・いいね・コメント
// ---------------------
Route::middleware('auth')->group(function () {
    // プロフィール
    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('mypage.profile');
    Route::put('/mypage/profile', [ProfileController::class, 'update'])->name('mypage.profile.update');

    // 配送先住所変更
    Route::get('/mypage/shipping/edit', [ProfileController::class, 'editShipping'])->name('mypage.shipping.edit');
    Route::put('/mypage/shipping/update', [ProfileController::class, 'updateShipping'])->name('mypage.shipping.update');

    // ログアウト
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // いいね機能
    Route::post('/products/{product}/like',   [LikeController::class, 'store'])->name('products.like');
    Route::delete('/products/{product}/like',   [LikeController::class, 'destroy'])->name('products.unlike');

    // コメント投稿
    Route::post('/products/{product}/comments', [CommentController::class, 'store'])->name('products.comments.store');

    // 商品購入処理
    Route::post('/products/{product}/purchase', [ProductController::class, 'processPurchase'])->name('products.purchase.process');

    // Stripe決済
    Route::get('/stripe/checkout/{product}', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success/{product}', [StripeController::class, 'success'])->name('stripe.success');
});
