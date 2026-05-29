@extends('layouts.auth')

@section('title', '登入 – 情境領導力問卷')

@section('content')
<div class="card auth-card">
    <div class="card-body">
        <h5 class="font-weight-bold mb-4" style="color: var(--color-primary);">管理員登入</h5>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">電子郵件</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}"
                       placeholder="admin@example.com"
                       required autocomplete="email" autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">密碼</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required autocomplete="current-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group d-flex justify-content-between align-items-center">
                <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">記住我</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="small text-muted">忘記密碼?</a>
                @endif
            </div>
            <button type="submit" class="btn btn-primary btn-block">登入</button>
        </form>
    </div>
</div>
@endsection
