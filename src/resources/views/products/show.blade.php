@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>

<img src="{{ asset('storage/' . $product->image) }}" alt="商品画像" width="100">
<p>ブランド: {{ $product->brand->name ?? 'なし' }}</p>
<p>価格: {{ $product->price }}円</p>
<p>説明: {{ $product->description }}</p>
<p>カテゴリ: {{ $product->categories->pluck('name')->join(', ') }}</p>
<p>状態: {{ $product->status }}</p>
<p>いいね数: {{ $product->likes->count() }}</p>
<p>コメント数: {{ $product->comments->count() }}</p>

{{-- いいねボタン --}}
@auth
    <form method="POST" action="{{ route('products.like', $product) }}">
        @csrf
        <button type="submit">
            @if($product->likes->contains('user_id', auth()->id()))
                ❤️ いいね解除
            @else
                🤍 いいね
            @endif
        </button>
    </form>
@endauth

{{-- コメント一覧 --}}
<h2>コメント</h2>
@foreach($product->comments as $comment)
    <div style="border-bottom:1px solid #ccc; margin-bottom:10px;">
        <strong>{{ $comment->user->name }}</strong>：{{ $comment->content }}
    </div>
@endforeach

{{-- コメント投稿フォーム --}}
@auth
    <form method="POST" action="{{ route('products.comments.store', $product) }}">
        @csrf
        <textarea name="content" maxlength="255" required></textarea>
        <button type="submit">コメントする</button>
    </form>
@endauth

@endsection