<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function __construct()
    {
        // 未ログインユーザーをブロック
        $this->middleware('auth');
    }

    // コメント投稿
    public function store(CommentRequest $request, $item_id)
    {
        $product = Product::findOrFail($item_id);
        // CommentRequestでバリデーション済みのデータを取得
        $validated = $request->validated();

        // リレーション経由でコメントを作成
        $product->comments()->create([
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        // 元ページへリダイレクト
        return back()->with('status', 'コメントを投稿しました。');
    }
}