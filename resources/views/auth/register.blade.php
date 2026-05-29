@extends('layouts.auth')

@section('title', '註冊 – 情境領導力問卷')

@section('content')
<div class="card auth-card">
    <div class="card-body">
        <h5 class="font-weight-bold mb-4" style="color: var(--color-primary);">建立帳號</h5>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">姓名</label>
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}"
                       required autocomplete="name" autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">電子郵件</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}"
                       required autocomplete="email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">密碼</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required autocomplete="new-password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm">確認密碼</label>
                <input id="password-confirm" type="password"
                       class="form-control"
                       name="password_confirmation"
                       required autocomplete="new-password">
            </div>
            <button type="submit" class="btn btn-primary btn-block">建立帳號</button>
        </form>
    </div>
</div>
@endsection
