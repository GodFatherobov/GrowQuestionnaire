<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '後台管理') – 情境領導力問卷</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="admin-layout">

    <button class="sidebar-toggle" id="sidebarToggle" aria-label="開啟選單">&#9776;</button>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <a href="{{ Auth::check() ? route('backend.ClassIndex') : route('login') }}"
               style="color: #fff; text-decoration: none;">情境領導力問卷</a>
        </div>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('backend.ClassIndex') }}"
                   class="sidebar-nav-link {{ request()->routeIs('backend.ClassIndex') ? 'active' : '' }}">
                    課程列表
                </a>
            </li>
        </ul>
        <div class="sidebar-footer">
            @auth
                <div class="sidebar-user">{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm w-100">登出</button>
                </form>
            @endauth
        </div>
    </nav>

    <div class="admin-main">
        <main class="admin-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('open');
        });
        function toggleHelp(page) {
            var el  = document.getElementById('helpContent_' + page);
            var btn = document.getElementById('helpBtn_' + page);
            if (el.style.display === 'none') {
                el.style.display = '';
                btn.innerHTML = '▲ 收起說明';
                localStorage.removeItem('help_' + page);
            } else {
                el.style.display = 'none';
                btn.innerHTML = '▼ 展開說明';
                localStorage.setItem('help_' + page, '0');
            }
        }
        function confirmDelete(formId, title, text) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74c3c',
                confirmButtonText: '確定刪除',
                cancelButtonText: '取消'
            }).then(function (result) {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: '成功', text: '{{ session("success") }}', timer: 2000, showConfirmButton: false });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: '無法執行', text: '{{ session("error") }}', confirmButtonColor: '#2C3E50' });
    </script>
    @endif
    @yield('scripts')

</body>
</html>
