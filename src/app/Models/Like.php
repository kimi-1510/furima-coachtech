<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // いいねしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // いいねされた商品
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
