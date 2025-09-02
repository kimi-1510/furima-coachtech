@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/show.css"> <!-- CSS読み込み -->

<div class="product-detail">     {{-- 商品詳細全体を囲むFlexboxレイアウトの親要素 --}}

    <div class="product-detail__left">  {{-- 左側カラム：商品画像用エリア --}}
    <img
        src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="product-detail__image">
    </div>

    <div class="product-detail__right"> {{-- 右側カラム：商品情報を縦に並べる --}}
        <h1 class="product-detail__title">{{ $product->name }}</h1> {{-- 商品名を大見出しで表示 --}}

        <p class="product-detail__brand">
            {{ $product->brand_name ?? 'なし' }}               {{-- ブランド名を直接表示 --}}
        </p>

        <div class="product-detail__price-row">               {{-- 価格とコメントアイコンを横並び --}}
            <span class="product-detail__price">
            ¥{{ number_format($product->price) }}（税込）      {{-- 価格をカンマ区切りで表示 --}}
            </span>
        </div>

        {{-- いいね＆コメント数 --}}
        @php
        // ログイン済みかつ自分がいいね済みか判定
        $liked = auth()->check()
                && $product->likes->contains('user_id', auth()->id());
        @endphp

        <div class="product-detail__counts">
            {{-- いいねエリア --}}
            <div class="action-item">
                <form
                    action="{{ $liked
                        ? route('products.unlike', $product)
                        : route('products.like',   $product) }}"
                    method="POST"
                    class="action-item__form"
                >
                    @csrf
                    @if ($liked)
                    @method('DELETE')
                    @endif
                    {{-- いいねアイコン --}}
                    <button type="submit" class="action-item__icon @if($liked) liked @endif">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                        </svg>
                    </button>
                </form>
                {{-- 数字 --}}
                <span class="action-item__count">
                {{ $product->likes->count() }}
                </span>
            </div>
            {{-- コメントエリア --}}
            <div class="action-item">
                {{-- コメントアイコン --}}
                <span class="action-item__icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h4l4 4 4-4h4c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
                    </svg>
                </span>
                <span class="action-item__count">
                {{ $product->comments->count() }}
                </span>
            </div>
        </div>

        <a href="{{ route('products.purchase', $product) }}" class="btn btn--primary product-detail__buy">
            購入手続きへ                                       {{-- 購入ページへ遷移するボタン --}}
        </a>

        <h2 class="product-detail__section-title">商品説明</h2>  {{-- セクション見出し（小） --}}
        <p class="product-detail__description">
            {{ $product->description }}                         {{-- 商品説明文を表示 --}}
        </p>

        <h2 class="product-detail__section-title">商品の情報</h2>  {{-- セクション見出し（小） --}}
        <div class="product-detail__info product-detail__categories-row">
            <strong class="product-category__info-label">カテゴリー</strong>
            @foreach($product->categories as $category)
                <span class="category-badge">{{ $category->name }}</span>  {{-- カテゴリーバッジを表示 --}}
            @endforeach
        </div>
        <div class="product-detail__info product-detail__categories-row">
            <strong class="product-detail__info-label">商品の状態</strong>
                <span class="detail-badge">{{ $product->status }}</span>   {{-- 状態ラベルを表示 --}}
        </div>
        <div class="comments">                                       {{-- コメント一覧全体を囲む --}}
            <h2 class="comments__title">
            コメント（{{ $product->comments->count() }}）          {{-- コメント数を見出しに --}}
            </h2>

            @foreach($product->comments as $comment)
            <div class="comment">
                <div class="comment__user">                             {{-- 各コメントを横並びレイアウト --}}
                    @if($comment->user->profile_image && !empty($comment->user->profile_image))
                        <img
                            src="{{ asset('storage/'.$comment->user->profile_image) }}"           {{-- ユーザーのプロフィール画像 --}}
                            alt="{{ $comment->user->name }}さんのアイコン"
                            class="comment__avatar"                             {{-- 丸く表示するクラス --}}
                        >
                    @else
                        <div class="comment__avatar"></div>                    {{-- 画像がない場合のプレースホルダー --}}
                    @endif
                    <p class="comment__name">{{ $comment->user->name }}</p> {{-- ユーザー名 --}}
                </div>
                <div class="comment__body">                           {{-- 名前と本文を縦並び --}}
                    <p class="comment__text">{{ $comment->content }}</p>   {{-- コメント内容 --}}
                </div>
            </div>
            @endforeach

            <h3 class="comments__form-title">商品へのコメント</h3>  {{-- コメント入力セクションの見出し --}}
            <form
                method="POST"
                action="{{ route('products.comments.store', $product) }}"
                class="comments__form" novalidate
            >
            @error('content')
                <p class="error">{{ $message }}</p>
            @enderror
                @csrf
                <textarea
                    name="content"
                    class="comments__textarea"
                    maxlength="255"
                    required
                    placeholder="コメントを入力"
                ></textarea>                                           {{-- コメント入力欄 --}}
                <button
                    type="submit"
                    class="btn btn--secondary comments__submit"
                >
                コメントを送信する                             {{-- 送信ボタン --}}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection