<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ブランド
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // カテゴリ（多対多）
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // いいね
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // コメント
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // 一括代入を許可するカラムを指定
    protected $fillable = [
        'name',
        'price',
        'brand_id',
        'description',
        'status',
        'image',
        'user_id',
        'is_sold',
    ];
}
