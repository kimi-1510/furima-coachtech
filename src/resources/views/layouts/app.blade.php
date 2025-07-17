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
    <a href="{{ route('register') }}" class="navbar-brand">
      <img src="/images/logo.svg" alt="coachtech" class="navbar-logo">
    </a>
    @auth
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
      @csrf
      <button type="submit" class="logout-btn">ログアウト</button>
    </form>
    @endauth
  </div>
</nav>

  <main>
    @yield('content') <!-- コンテンツの挿入 -->
  </main>
</body>

</html>
