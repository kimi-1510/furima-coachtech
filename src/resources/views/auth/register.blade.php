@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/common.css"> <!-- CSS読み込み -->

<div class="form-container"> <!-- フォームのコンテナ -->
    <h2>会員登録</h2>

    <form method="POST" action="{{ route('register') }}" novalidate> <!-- フォームの送信先 -->
        @csrf <!-- CSRFトークンの挿入 -->

        {{-- ユーザー名 --}}
        <label for="name">ユーザー名</label> <!-- ラベル -->
        <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus class="common-input"> <!-- ユーザー名の入力フィールド -->
        @error('name') <p class="error">{{ $message }}</p> @enderror <!-- エラーメッセージ -->

        {{-- メールアドレス --}}
        <label for="email">メールアドレス</label> <!-- ラベル -->
        <input id="email" type="email" name="email" value="{{ old('email') }}" class="common-input"> <!-- メールアドレスの入力フィールド -->
        @error('email') <p class="error">{{ $message }}</p> @enderror <!-- エラーメッセージ -->

        {{-- パスワード --}}
        <label for="password">パスワード</label> <!-- ラベル -->
        <input id="password" type="password" name="password" class="common-input"> <!-- パスワードの入力フィールド -->
        @error('password') <p class="error">{{ $message }}</p> @enderror <!-- エラーメッセージ -->

        {{-- 確認用パスワード --}}
        <label for="password_confirmation">確認用パスワード</label> <!-- ラベル -->
        <input id="password_confirmation" type="password" name="password_confirmation" class="common-input"> <!-- 確認用パスワードの入力フィールド -->
        @error('password_confirmation') <p class="error">{{ $message }}</p> @enderror <!-- エラーメッセージ -->

        <button type="submit" class="common-btn">登録する</button> <!-- 登録ボタン -->

        <p class="text-center">
            <a href="{{ route('login') }}">ログインはこちら</a> <!-- ログイン画面に遷移 -->
        </p>
    </form>
</div>
@endsection
