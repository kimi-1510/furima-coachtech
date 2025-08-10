@extends('layouts.app')

@section('content')
<div class="shipping-edit-container">
    <h1 class="shipping-edit-title">住所の変更</h1>
    
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

    <form method="POST" action="{{ route('mypage.shipping.update') }}" class="shipping-edit-form">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="post_code" class="form-label">郵便番号</label>
            <input type="text" id="post_code" name="post_code" value="{{ old('post_code', $user->post_code) }}" 
                   class="form-control" required maxlength="8" placeholder="例: 123-4567">
        </div>

        <div class="form-group">
            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" 
                   class="form-control" required maxlength="255" placeholder="例: 東京都渋谷区...">
        </div>

        <div class="form-group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}" 
                   class="form-control" maxlength="255" placeholder="例: ○○マンション101号室">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn--update">更新する</button>
        </div>
    </form>
</div>

<style>
.shipping-edit-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.shipping-edit-title {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

.alert {
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.alert-success {
    background-color: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border: 1px solid #f5c6cb;
    color: #721c24;
}

.alert ul {
    margin: 0;
    padding-left: 20px;
}

.shipping-edit-form {
    background: #fff;
    padding: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 30px;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    text-align: center;
    transition: background-color 0.3s;
}

.btn--update {
    background-color: #ff5454;
    color: white;
}
</style>
@endsection
