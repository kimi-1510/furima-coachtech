@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="/css/common.css">

<div class="form-container">
    <h2>商品の出品</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" novalidate>
        @csrf

        {{-- 商品画像 --}}
        <label for="image">商品画像</label>
        <input id="image" type="file" name="image" accept="image/*" class="common-input" required>
        @error('image')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- カテゴリ --}}
        <label for="categories">カテゴリ</label>
        <div class="category-selection">
            @foreach($categories as $category)
                <label class="category-option">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-checkbox" 
                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                    <span class="category-badge">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
        @error('categories')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 商品の状態 --}}
        <label for="status">商品の状態</label>
        <select id="status" name="status" class="common-input" required>
            <option value="">選択してください</option>
            <option value="良好" {{ old('status') == '良好' ? 'selected' : '' }}>良好</option>
            <option value="目立った傷や汚れなし" {{ old('status') == '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
            <option value="やや傷や汚れあり" {{ old('status') == 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
            <option value="状態が悪い" {{ old('status') == '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
        </select>
        @error('status')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 商品名 --}}
        <label for="name">商品名</label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" class="common-input" required>
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- ブランド名 --}}
        <label for="brand_name">ブランド名</label>
        <input id="brand_name" type="text" name="brand_name" value="{{ old('brand_name') }}" class="common-input">
        @error('brand_name')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 商品の説明 --}}
        <label for="description">商品の説明</label>
        <textarea id="description" name="description" class="common-input" rows="5" required>{{ old('description') }}</textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror

        {{-- 販売価格 --}}
        <label for="price">販売価格</label>
        <div class="price-input">
            <input id="price" type="number" name="price" value="{{ old('price') }}" class="common-input" min="1" required>
        </div>
        @error('price')
            <p class="error">{{ $message }}</p>
        @enderror

        <button type="submit" class="common-btn">出品する</button>
    </form>
</div>
@endsection
