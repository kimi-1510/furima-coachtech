<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        // 購入関連のメソッドに認証を必須にする
        $this->middleware('auth')->only(['purchase', 'processPurchase', 'updatePaymentMethod']);
    }

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
            })->with(['categories', 'likes'])->get();

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
        $products = $query->with(['categories', 'likes'])->get();

        return view('products.index', compact('products'));
    }

    // 商品詳細表示
    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);
        // 関連データもまとめて取得
        $product->load(['categories', 'likes', 'comments.user']);

        return view('products.show', compact('product'));
    }

    // 商品購入画面表示
    public function purchase($item_id)
    {
        $product = Product::findOrFail($item_id);
        // 関連データもまとめて取得
        $product->load(['categories']);

        return view('products.purchase', compact('product'));
    }

    // 商品購入処理
    public function processPurchase(Request $request, $item_id)
    {
        \Log::info('processPurchase method called', [
            'item_id' => $item_id,
            'payment_method' => $request->input('payment_method'),
            'user_id' => auth()->id()
        ]);

        $product = Product::findOrFail($item_id);
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

        \Log::info('Validation passed, redirecting to Stripe', [
            'product_id' => $product->id,
            'payment_method' => $request->payment_method
        ]);

        // 支払い方法に関係なく、Stripe決済画面に遷移
        // 支払い方法をセッションに保存（Stripe決済完了後に使用）
        session([
            'purchase_payment_method' => $request->payment_method,
            'purchase_item_id' => $item_id
        ]);

        return redirect()->route('stripe.checkout', $product->id);
    }

    // 支払い方法の更新（表示更新用）
    public function updatePaymentMethod(Request $request, $item_id)
    {
        $request->validate([
            'payment_method' => 'required|in:convenience,card',
        ]);

        // セッションに支払い方法を保存
        session(['selected_payment_method' => $request->payment_method]);

        // 支払い方法の選択のみを更新
        return redirect()->route('products.purchase', $item_id)
            ->withInput($request->only('payment_method'));
    }

    // 商品出品画面を表示
    public function create()
    {
        $categories = Category::all();
        
        return view('products.create', compact('categories'));
    }

    // 商品出品処理
    public function store(ExhibitionRequest $request)
    {
        try {
            // 画像をアップロード
            $imagePath = $request->file('image')->store('products', 'public');
            
            // 商品を作成
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
                'brand_name' => $request->brand_name,
                'image' => $imagePath,
                'user_id' => auth()->id(),
                'is_sold' => false,
            ]);

            // カテゴリを関連付け
            $product->categories()->attach($request->categories);

            return redirect()->route('products.show', $product->id)
                ->with('success', '商品を出品しました！');

        } catch (\Exception $e) {
            // 画像アップロードに失敗した場合、画像を削除
            if (isset($imagePath) && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            
            return back()->withInput()->withErrors(['error' => '商品の出品に失敗しました。もう一度お試しください。']);
        }
    }
}