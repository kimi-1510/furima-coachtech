@extends('layouts.app') <!-- レイアウトの継承 -->

@section('content') <!-- コンテンツの挿入 -->
<link rel="stylesheet" href="/css/common.css"> <!-- CSS読み込み -->

<div class="form-container"> <!-- フォームのコンテナ -->
    <h2>プロフィール設定</h2>

    {{-- 成功メッセージ --}}
    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('mypage.profile.update') }}" enctype="multipart/form-data" novalidate> <!-- フォームの送信先 -->
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
            <input type="file" id="image" name="image" accept="image/png,image/jpeg,image/jpg" class="image-input">
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        {{-- ユーザー名 --}}
        <label for="name">ユーザー名</label> <!-- ラベル -->
        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" autofocus class="common-input"> <!-- ユーザー名の入力フィールド -->
        @error('name')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 郵便番号 --}}
        <label for="post_code">郵便番号</label> <!-- ラベル -->
        <input id="post_code" type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}" class="common-input"> <!-- 郵便番号の入力フィールド -->
        @error('post_code')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 住所 --}}
        <label for="address">住所</label> <!-- ラベル -->
        <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" class="common-input"> <!-- 住所の入力フィールド -->
        @error('address')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        {{-- 建物名 --}}
        <label for="building">建物名</label> <!-- ラベル -->
        <input id="building" type="text" name="building" value="{{ old('building', $user->building) }}" class="common-input"> <!-- 建物名の入力フィールド -->
        @error('building')
            <p class="error">{{ $message }}</p> <!-- エラーメッセージ -->
        @enderror

        <button type="submit" class="common-btn">更新する</button> <!--更新ボタン -->
    </form>

</div>

@endsection