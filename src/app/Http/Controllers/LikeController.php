<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        // 全メソッドに対して認証を必須にする
        $this->middleware('auth');
    }

    // いいね追加
    public function store($item_id)
    {
        $product = Product::findOrFail($item_id);
        $product->likes()->firstOrCreate(['user_id' => auth()->id(),]);

        // いいね数を最新化
        $product->loadCount('likes');

        return back();
    }

    // いいね解除
    public function destroy($item_id)
    {
        $product = Product::findOrFail($item_id);
        $product->likes()->where('user_id', auth()->id())->delete();

        // いいね数を最新化
        $product->loadCount('likes');

        return back();
    }
}