<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    // 支払い方法の定数
    const PAYMENT_METHOD_CONVENIENCE = 'convenience';
    const PAYMENT_METHOD_CARD = 'card';

    // 決済状況の定数
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    // 一括代入を許可するカラム
    protected $fillable = [
        'product_id',
        'user_id',
        'shipping_address',
        'payment_method',
        'stripe_payment_intent_id',
        'status',
    ];

    // リレーション
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 支払い方法の表示名を取得
    public function getPaymentMethodNameAttribute()
    {
        return [
            self::PAYMENT_METHOD_CONVENIENCE => 'コンビニ支払い',
            self::PAYMENT_METHOD_CARD => 'カード支払い',
        ][$this->payment_method] ?? '不明';
    }

    // 決済状況の表示名を取得
    public function getStatusNameAttribute()
    {
        return [
            self::STATUS_PENDING => '決済待ち',
            self::STATUS_COMPLETED => '決済完了',
            self::STATUS_FAILED => '決済失敗',
        ][$this->status] ?? '不明';
    }
}
