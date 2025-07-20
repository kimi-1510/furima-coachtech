<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index(Request $request)
    {
        // 検索キーワードがあれば部分一致で検索
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // ログインユーザーが出品した商品は除外
        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        // 商品と関連データを取得
        $products = $query->with(['brand', 'categories', 'likes'])->get();

        return view('products.index', compact('products'));
    }

    // 商品詳細表示
    public function show(Product $product)
    {
        // 関連データもまとめて取得
        $product->load(['brand', 'categories', 'likes', 'comments.user']);

        return view('products.show', compact('product'));
    }
}