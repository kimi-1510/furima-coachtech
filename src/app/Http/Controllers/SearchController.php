<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    /**
     * 検索結果を表示
     */
    public function index(Request $request)
    {
        // フォームから送られてきたキーワードを取得
        $keyword = $request->input('keyword', '');

        // 商品名にキーワードを含むものを部分一致検索
        $products = Product::where('name', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->get();

        // キーワードと結果をビューに渡す
        return view('products.index', compact('products', 'keyword'));
    }
}