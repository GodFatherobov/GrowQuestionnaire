<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '情境領導力問卷')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="quiz-layout">

    <header class="quiz-header">
        <div class="quiz-header-inner">
            <a href="{{ Auth::check() ? route('backend.ClassIndex') : route('login') }}"
               class="quiz-brand" style="text-decoration: none;">情境領導力問卷</a>
            @hasSection('progress-width')
                <div class="quiz-progress-wrap">
                    <div class="quiz-progress-bar" style="width: @yield('progress-width')%"></div>
                </div>
                <span class="quiz-progress-label">@yield('progress-label')</span>
            @endif
        </div>
    </header>

    <main class="quiz-main">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
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
