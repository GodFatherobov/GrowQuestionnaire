@extends('layouts.auth')

@section('title', '登入 – 情境領導力問卷')

@section('content')
<div class="card auth-card">
    <div class="card-body">
        <h5 class="font-weight-bold mb-4" style="color: var(--color-primary);">管理員登入</h5>
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 0.875rem;">{{ $errors->first() }}</div>
        @endif
        <form action="{{ route('backend.AdminLogin') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="account">電子郵件</label>
                <input id="account" type="email"
                       class="form-control @error('account') is-invalid @enderror"
                       name="account" value="{{ old('account') }}"
                       placeholder="請輸入電子郵件"
                       required autocomplete="email" autofocus>
                @error('account')
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
            <button type="submit" class="btn btn-primary btn-block">登入</button>
        </form>
    </div>
</div>
<p class="text-center mt-3" style="font-size: 0.875rem; color: var(--color-muted);">
    還沒有帳號？<a href="{{ route('register') }}" style="color: var(--color-accent);">立即註冊</a>
</p>
@include('sweetalert::alert')
@endsection
