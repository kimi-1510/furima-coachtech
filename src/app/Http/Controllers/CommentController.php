<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // コメント投稿
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'content' => 'required|max:255',
        ]);

        $product->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back();
    }
}