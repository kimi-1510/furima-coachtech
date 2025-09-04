@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/mypage.css">

<div class="mypage-container">
    {{-- プロフィール情報セクション --}}
    <div class="profile-section">
        <div class="profile-header">
            <div class="profile-image">
                @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}" alt="プロフィール画像">
                @else
                    <div class="profile-placeholder"></div>
                @endif
            </div>
            <div class="profile-info">
                <h2 class="user-name">{{ $user->name }}</h2>
            </div>
            <div class="profile-actions">
                <a href="{{ route('mypage.profile') }}" class="edit-profile-btn">プロフィール編集</a>
            </div>
        </div>
    </div>

    {{-- タブ切り替えリンク --}}
    <div class="tab-links">
        <a href="/mypage?page=sell" class="{{ $page == 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="/mypage?page=buy" class="{{ $page == 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    {{-- 商品リスト（カード4列） --}}
    @if($page == 'buy')
        {{-- 購入した商品一覧 --}}
        <div class="product-list">
            @forelse($purchases as $purchase)
                <div class="product-card">
                    <a href="{{ route('products.show', $purchase->product->id) }}">
                        <div class="image-wrapper">
                            <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="商品画像">
                        </div>
                        <div class="product-name">{{ $purchase->product->name }}</div>
                    </a>
                </div>
            @empty
                <!-- <p class="no-products">購入した商品はありません。</p> -->
            @endforelse
        </div>
    @elseif($page == 'sell')
        {{-- 出品した商品一覧 --}}
        <div class="product-list">
            @forelse($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product->id) }}">
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
                <!-- <p class="no-products">出品した商品はありません。</p> -->
            @endforelse
        </div>
    @else
        {{-- デフォルト表示（出品した商品） --}}
        <div class="product-list">
            @forelse($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.show', $product->id) }}">
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
                <!-- <p class="no-products">出品した商品はありません。</p> -->
            @endforelse
        </div>
    @endif
</div>
@endsection
