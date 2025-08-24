@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/common.css">

<div class="form-container">
    <h2>住所の変更</h2>

    <form method="POST" action="{{ route('mypage.shipping.update', $item_id) }}" novalidate>
        @csrf
        @method('PUT')
        
        {{-- 郵便番号 --}}
        <label for="post_code">郵便番号</label>
        <input id="post_code" type="text" name="post_code" value="{{ old('post_code', $user->post_code) }}" 
               class="common-input" required maxlength="8">
        @error('post_code')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 住所 --}}
        <label for="address">住所</label>
        <input id="address" type="text" name="address" value="{{ old('address', $user->address) }}" 
               class="common-input" required maxlength="255">
        @error('address')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 建物名 --}}
        <label for="building">建物名</label>
        <input id="building" type="text" name="building" value="{{ old('building', $user->building) }}" 
               class="common-input" maxlength="255">
        @error('building')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit" class="common-btn">更新する</button>
    </form>
</div>


@endsection
