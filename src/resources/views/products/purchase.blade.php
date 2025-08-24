@extends('layouts.app')

@section('content')
@php
    $sessionPaymentMethod = session('selected_payment_method');
    $oldPaymentMethod = old('payment_method');
    
    // デバッグ用（開発時のみ表示）
    if (config('app.debug')) {
        \Log::info("Payment method debug", [
            'session_payment_method' => $sessionPaymentMethod,
            'session_payment_method_type' => gettype($sessionPaymentMethod),
            'old_payment_method' => $oldPaymentMethod,
            'old_payment_method_type' => gettype($oldPaymentMethod)
        ]);
    }
    
    // セッションの値が配列でないことを確認
    if (is_array($sessionPaymentMethod)) {
        $sessionPaymentMethod = null;
    }
    if (is_array($oldPaymentMethod)) {
        $oldPaymentMethod = null;
    }
    
    $currentPaymentMethod = $sessionPaymentMethod ?? $oldPaymentMethod ?? 'convenience';
@endphp
<link rel="stylesheet" href="/css/purchase.css">

<div class="purchase-container">
    <div class="purchase-layout">
        {{-- 左側：商品情報・支払い方法・配送先 --}}
        <div class="left-section">
            {{-- 商品情報 --}}
            <div class="product-info">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                </div>
                <div class="product-details">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-price">¥{{ number_format($product->price) }}</p>
                </div>
            </div>

            {{-- 支払い方法選択 --}}
            <div class="payment-section">
                <div class="section-header">
                    <h3 class="section-title">支払い方法</h3>
                </div>
                <form method="POST" action="{{ route('products.payment.method', $product->id) }}" id="payment-method-form">
                    @csrf
                    <select name="payment_method" class="payment-select" onchange="this.form.submit()">
                        <option value="convenience" {{ $currentPaymentMethod == 'card' ? '' : 'selected' }}>コンビニ支払い</option>
                        <option value="card" {{ $currentPaymentMethod == 'card' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </form>
                
                <form method="POST" action="{{ route('products.purchase.process', $product->id) }}" id="payment-form">
                    @csrf
                    <input type="hidden" name="payment_method" value="{{ $currentPaymentMethod }}">
                </form>
            </div>

            {{-- 配送先住所 --}}
            <div class="shipping-section">
                <div class="section-header">
                    <h3 class="section-title">配送先</h3>
                    <a href="{{ route('mypage.shipping.edit', $product->id) }}" class="edit-link">変更する</a>
                </div>
                <div class="address-display">
                    @php
                        $shippingAddress = session("shipping_address_{$product->id}");
                        
                        // セッションの値を安全に取得
                        if (is_array($shippingAddress) && isset($shippingAddress['post_code'])) {
                            $displayPostCode = $shippingAddress['post_code'];
                        } else {
                            $displayPostCode = auth()->user()->post_code ?? '';
                        }
                        
                        if (is_array($shippingAddress) && isset($shippingAddress['address'])) {
                            $displayAddress = $shippingAddress['address'];
                        } else {
                            $displayAddress = auth()->user()->address ?? '';
                        }
                        
                        if (is_array($shippingAddress) && isset($shippingAddress['building'])) {
                            $displayBuilding = $shippingAddress['building'];
                        } else {
                            $displayBuilding = auth()->user()->building ?? '';
                        }
                        
                        // 住所の組み立て
                        $fullAddress = trim($displayAddress . ' ' . $displayBuilding);
                    @endphp
                    <p class="post-code">〒{{ $displayPostCode }}</p>
                    <p class="current-address">{{ $fullAddress }}</p>
                </div>
            </div>
        </div>

        {{-- 右側：料金情報・購入ボタン --}}
        <div class="right-section">
            {{-- 商品代金 --}}
            <div class="price-summary">
                <div class="info-row">
                    <span class="info-label">商品代金</span>
                    <span class="info-value price-value">¥{{ number_format($product->price) }}</span>
                </div>
            </div>

            {{-- 支払い方法表示 --}}
            <div class="payment-display">
                <div class="info-row">
                    <span class="info-label">支払い方法</span>
                    <span class="info-value payment-method-value">
                        @if($currentPaymentMethod == 'card')
                            カード支払い
                        @else
                            コンビニ支払い
                        @endif
                    </span>
                </div>
            </div>

            {{-- 購入アクション --}}
            <div class="purchase-actions">
                <button type="submit" form="payment-form" class="btn btn--purchase">
                    購入する
                </button>
            </div>
        </div>
    </div>
</div>



@endsection
