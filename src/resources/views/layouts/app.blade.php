<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- ビューポートの設定 -->
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRFトークンの設定 -->

  <title>COACHTECH</title>

  <link rel="stylesheet" href="/css/sanitize.css"> <!-- リセットCSS -->
  <link rel="stylesheet" href="/css/layout.css"> <!-- layout CSS -->

</head>

<body>
<nav class="navbar">
  <div class="navbar-container">
    <!-- 左：ロゴ -->
    <a href="/" class="navbar-brand">
      <img src="/images/logo.svg" alt="coachtech" class="navbar-logo">
    </a>

    <!-- 中央：検索フォーム -->
    @if(!request()->routeIs('login', 'register')) <!-- ログイン・会員登録画面以外で表示 -->
    <form action="{{ route('search') }}" method="GET" class="search-form">
      <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search-input" autocomplete="off">
    </form>
    @endif

    <!-- 右：マイページ or ログアウト or ログイン -->
    @auth
    <div class="user-menu">
      <a href="{{ route('products.create') }}" class="sell-link">出品</a>
      <a href="{{ route('mypage.index') }}" class="mypage-link">マイページ</a>
      <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="logout-btn">ログアウト</button>
      </form>
    </div>
    @endauth

    @guest
      <a href="{{ route('login') }}" class="login-link">ログイン</a>
    @endguest
  </div>
</nav>

  <main class="main-content">
    @yield('content') <!-- コンテンツの挿入 -->
  </main>
</body>

</html>
