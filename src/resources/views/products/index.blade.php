@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/index.css"> <!-- CSS読み込み -->

{{-- タブ切り替えリンク --}}
<div class="tab-links">
    <a href="{{ route('products.index') }}" class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ route('products.index', ['tab' => 'mylist']) }}" class="{{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

{{-- 商品リスト（カード4列） --}}
<div class="product-list">
    @forelse($products as $product)
    <div class="product-card">
        <a href="{{ route('products.show', $product) }}">
            <div class="image-wrapper">
                <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
            </div>
            <div class="product-name">{{ $product->name }}</div>
        </a>
        @if($product->is_sold)
            <span style="color:red; font-size:0.9em;">Sold</span>
        @endif
    </div>
    @empty
        <p style="margin:32px auto;">表示できる商品がありません。</p>
    @endforelse
</div>
@endsection
