<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // カテゴリに属する商品（多対多）
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
