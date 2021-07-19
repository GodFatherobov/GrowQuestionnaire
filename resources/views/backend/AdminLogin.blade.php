<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>管理員登入</h1>
<form action="/AdminLogin" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <label for="account" class="col-md-4 col-form-label">帳號：</label>
        <input id="account"
               type="text"
               class="form-control @error('account') is-invalid @enderror"
               name="account"
               value="{{ old('account') }}"
               required autocomplete="account" autofocus>

        @error('account')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
    <div class="row">
    <label for="password" class="col-md-4 col-form-label">密碼：</label>
        <input id="password"
               type="password"
               class="form-control @error('password') is-invalid @enderror"
               name="password" required autocomplete="current-password">

        @error('password')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
    <div class="row">
        <button class="btn">登入</button>
    </div>
</form>
</div>
<div align="right">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
</body>
</html>
