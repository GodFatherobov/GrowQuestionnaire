<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '情境領導力問卷')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-layout">
    <div class="auth-container">
        <div class="auth-brand">
            <a href="{{ route('home') }}" style="color: inherit; text-decoration: none;">情境領導力問卷</a>
        </div>
        @yield('content')
        <div class="auth-back">
            <a href="{{ route('home') }}">&larr; 返回首頁</a>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
