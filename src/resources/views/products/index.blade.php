@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/index.css"> <!-- CSS読み込み -->

{{-- タブ切り替えリンク --}}
<div class="tab-links">
    <a href="{{ route('products.index') }}" class="{{ request('tab') !== 'mylist' ? 'active' : '' }}">おすすめ</a>
    <a href="{{ route('products.index', ['tab' => 'mylist']) }}" class="{{ request('tab') === 'mylist' ? 'active' : '' }}">マイリスト</a>
</div>

{{-- ★ 検索結果情報表示 --}}
@if(request('keyword'))
  <div class="search-info">
    <p>
      「{{ request('keyword') }}」の検索結果：{{ $products->count() }}件
      <a href="{{ route('products.index') }}">全件表示に戻す</a>
    </p>
  </div>
@endif

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
        <span class="sold-badge">Sold</span>
      @endif
    </div>
  @empty
    <!-- @if(request('tab') === 'mylist')
      @if(auth()->check())
        <p class="no-products">いいねした商品がありません。</p>
      @else
        <p class="no-products">ログインが必要です。</p>
      @endif
    @else
      <p class="no-products">表示できる商品がありません。</p>
    @endif -->
  @endforelse
</div>
@endsection

