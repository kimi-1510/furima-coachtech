@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/common.css"> <!-- CSS読み込み -->

<div class="form-container"> <!-- フォームのコンテナ -->
    <h2>ログイン</h2>

    <form method="POST" action="{{ route('login') }}" novalidate> <!-- フォームの送信先 -->
        @csrf <!-- CSRFトークンの挿入 -->

        {{-- メールアドレス --}}
        <label for="email">メールアドレス</label> <!-- ラベル -->
        <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus> <!-- メールアドレスの入力フィールド -->
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- パスワード --}}
        <label for="password">パスワード</label>
        <input id="password" type="password" name="password"> <!-- パスワードの入力フィールド -->
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit">ログイン</button> <!--ログインボタン -->

        <p class="text-center">
            <a href="{{ route('register') }}">会員登録はこちら</a> <!-- 会員登録画面に遷移 -->
        </p>
    </form>
</div>
@endsection