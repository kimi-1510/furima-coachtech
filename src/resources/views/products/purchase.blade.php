@extends('layouts.app')

@section('content')
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
                    <span class="selected-payment">{{ old('payment_method', 'convenience') == 'convenience' ? 'コンビニ支払い' : 'カード支払い' }}</span>
                </div>
                <form method="POST" action="{{ route('products.purchase.process', $product) }}" id="payment-form">
                    @csrf
                    <select name="payment_method" class="payment-select" onchange="this.form.submit()">
                        <option value="convenience" {{ old('payment_method', 'convenience') == 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                        <option value="card" {{ old('payment_method', 'convenience') == 'card' ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </form>
            </div>

            {{-- 配送先住所 --}}
            <div class="shipping-section">
                <div class="section-header">
                    <h3 class="section-title">配送先</h3>
                    <a href="{{ route('mypage.shipping.edit') }}" class="edit-link">変更する</a>
                </div>
                <div class="address-display">
                    <p class="current-address">{{ auth()->user()->full_address }}</p>
                </div>
            </div>
        </div>

        {{-- 右側：料金情報・購入ボタン --}}
        <div class="right-section">
            {{-- 商品代金 --}}
            <div class="price-summary">
                <h3 class="section-title">商品代金</h3>
                <div class="payment-info">
                    <span class="payment-label">商品代金</span>
                    <span class="payment-value">¥{{ number_format($product->price) }}</span>
                </div>
            </div>

            {{-- 支払い方法表示 --}}
            <div class="payment-display">
                <h3 class="section-title">支払い方法</h3>
                <div class="payment-info">

                    <span class="payment-value">{{ old('payment_method', 'コンビニ支払い') }}</span>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentSelect = document.querySelector('select[name="payment_method"]');
    const paymentValue = document.querySelector('.payment-value');
    
    // 支払い方法の選択を監視
    paymentSelect.addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        paymentValue.textContent = selectedText;
    });
    
    // 初期値の設定
    const initialText = paymentSelect.options[paymentSelect.selectedIndex].text;
    paymentValue.textContent = initialText;
});
</script>

@endsection
