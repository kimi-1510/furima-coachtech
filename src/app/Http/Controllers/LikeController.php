<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    // いいね追加
    public function store(Product $product)
    {
        $product->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);
        return back();
    }

    // いいね解除
    public function destroy(Product $product)
    {
        $product->likes()->where('user_id', auth()->id())->delete();
        return back();
    }
}