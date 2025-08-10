@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/common.css"> <!-- CSS読み込み -->

<div class="form-container"> <!-- フォームのコンテナ -->
    <h2>プロフィール設定</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('mypage.profile.update') }}" novalidate> <!-- フォームの送信先 -->
        @csrf <!-- CSRFトークンの挿入 -->
        @method('PUT')

        {{-- プロフィール画像 --}}
        <div class="profile-image-section">
            @if($user->profile_image)
                <img src="{{ asset('storage/'.$user->profile_image) }}"
                alt="プロフィール画像" class="profile-image" id="preview-image">
            @else
                <div class="profile-placeholder" id="preview-image"></div>
            @endif

            {{-- 画像選択ボタン --}}
            <label for="image" class="image-button">画像を選択する</label>
            <input type="file" id="image" mane="image" accept="image/png,image/jpeg" class="image-input">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ユーザー名 --}}
        <label for="name">ユーザー名</label> <!-- ラベル -->
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus> <!-- ユーザー名の入力フィールド -->
        @error('name')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 郵便番号 --}}
        <label for="post_code">郵便番号</label> <!-- ラベル -->
        <input id="post_code" type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}"> <!-- 郵便番号の入力フィールド -->
        @error('post_code')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 住所 --}}
        <label for="address">住所</label> <!-- ラベル -->
        <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}"> <!-- 住所の入力フィールド -->
        @error('address')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 建物名 --}}
        <label for="building">建物名</label> <!-- ラベル -->
        <input id="building" type="text" name="building" value="{{ old('building', $user->building) }}"> <!-- 建物名の入力フィールド -->
        @error('building')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        <button type="submit">更新する</button> <!--更新ボタン -->
    </form>

    {{-- 購入した商品一覧 --}}
    <div class="purchased-products-section">
        <h3>購入した商品一覧</h3>
        @if($user->purchases->count() > 0)
            <div class="purchased-products-list">
                @foreach($user->purchases as $purchase)
                    <div class="purchased-product-item">
                        <div class="product-image">
                            <img src="{{ asset('storage/' . $purchase->product->image) }}" alt="商品画像">
                        </div>
                        <div class="product-info">
                            <h4 class="product-name">{{ $purchase->product->name }}</h4>
                            <p class="product-price">¥{{ number_format($purchase->product->price) }}</p>
                            <p class="purchase-date">購入日: {{ $purchase->created_at->format('Y年m月d日') }}</p>
                            <p class="payment-method">支払い方法: {{ $purchase->payment_method_name }}</p>
                            <p class="shipping-address">配送先: {{ $purchase->shipping_address }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="no-purchases">購入した商品はありません。</p>
        @endif
    </div>
</div>

<style>
.purchased-products-section {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #ddd;
}

.purchased-products-section h3 {
    margin-bottom: 20px;
    color: #333;
    font-size: 18px;
}

.purchased-products-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.purchased-product-item {
    display: flex;
    gap: 15px;
    padding: 15px;
    border: 1px solid #eee;
    border-radius: 8px;
    background: #f9f9f9;
}

.product-image img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
}

.product-info {
    flex: 1;
}

.product-name {
    margin: 0 0 8px 0;
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

.product-price {
    margin: 0 0 5px 0;
    font-size: 14px;
    color: #e74c3c;
    font-weight: bold;
}

.purchase-date,
.payment-method,
.shipping-address {
    margin: 0 0 3px 0;
    font-size: 12px;
    color: #666;
}

.no-purchases {
    text-align: center;
    color: #666;
    font-style: italic;
}
</style>
@endsection