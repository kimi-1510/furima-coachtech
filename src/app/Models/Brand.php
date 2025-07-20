<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    
    // ブランドに属する商品
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
