<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // 商品一覧表示
    public function index(Request $request)
    {
        // マイリストタブの場合
        if ($request->get('tab') === 'mylist') {
            // 未認証の場合は空のコレクションを返す
            if (!auth()->check()) {
                $products = collect();
                return view('products.index', compact('products'));
            }

            // ログインユーザーがいいねした商品を取得
            $products = Product::whereHas('likes', function ($query) {
                $query->where('user_id', auth()->id());
            })->with(['brand', 'categories', 'likes'])->get();

            return view('products.index', compact('products'));
        }

        // 通常のおすすめタブの場合
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

    // 商品購入画面表示
    public function purchase(Product $product)
    {
        // 関連データもまとめて取得
        $product->load(['brand', 'categories']);

        return view('products.purchase', compact('product'));
    }

    // 商品購入処理（コンビニ支払い）
    public function processPurchase(Request $request, Product $product)
    {
        // 商品が売り切れでないかチェック
        if ($product->is_sold) {
            return redirect()->back()->with('error', 'この商品は既に売り切れです。');
        }

        // 自分が出品した商品は購入できない
        if (auth()->check() && $product->user_id === auth()->id()) {
            return redirect()->back()->with('error', '自分が出品した商品は購入できません。');
        }

        // 支払い方法のバリデーション
        $request->validate([
            'payment_method' => 'required|in:convenience,card',
        ]);

        try {
            // 商品を売り切れ状態に更新
            $product->update(['is_sold' => true]);

            // 購入履歴を作成
            Purchase::create([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'shipping_address' => auth()->user()->full_address,
                'payment_method' => $request->payment_method,
                'status' => Purchase::STATUS_COMPLETED,
            ]);

            return redirect()->route('products.index')->with('success', '商品の購入が完了しました！');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', '購入処理中にエラーが発生しました。');
        }
    }
}