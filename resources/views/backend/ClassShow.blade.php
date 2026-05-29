@extends('layouts.app')

@section('title', $class->ClassName)

@section('content')

<div class="page-header d-flex justify-content-between align-items-start flex-wrap">
    <div>
        <h1>{{ $class->ClassName }}</h1>
        <p>
            問卷連結：
            <a href="{{ route('student.StudentQuiz', ['ClassLink' => $class->ClassLink]) }}"
               target="_blank" style="color: var(--color-accent); font-size: 0.85rem; font-family: monospace;">
                {{ Request::root() }}/{{ $class->ClassLink }}/Quiz
            </a>
        </p>
    </div>
    <a href="{{ route('backend.ClassIndex') }}" class="btn btn-secondary btn-sm mt-1">
        &larr; 返回課程列表
    </a>
</div>

<div class="mb-4" id="helpWrapper_classshow">
    <div class="d-flex justify-content-end mb-1">
        <button type="button" id="helpBtn_classshow" onclick="toggleHelp('classshow')"
                class="btn btn-link btn-sm p-0 text-muted" style="font-size: 0.8rem; text-decoration: none;">
            ▲ 收起說明
        </button>
    </div>
    <div id="helpContent_classshow" class="card"
         style="border-color: rgba(26,188,156,0.25); background: rgba(26,188,156,0.04);">
        <div class="card-body" style="padding: 1rem 1.25rem; font-size: 0.875rem; line-height: 1.75; color: var(--color-text);">
            此頁面顯示課程內所有學員的作答狀態。<strong>已完成</strong>表示 12 題自評全部完成；<strong>作答中</strong>表示尚未完成所有題目；<strong>未開始</strong>表示尚未填寫任何題目。點擊學員姓名可查看詳細作答內容。
        </div>
    </div>
</div>

{{-- 統計卡片 --}}
<div class="row mb-4">
    <div class="col-6 col-md-3 mb-3">
        <div class="card text-center py-3" style="border-top: 3px solid #1ABC9C;">
            <div class="course-stat" style="color: #1ABC9C;">{{ $completed }}</div>
            <div class="course-stat-label mt-1">已完成</div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card text-center py-3" style="border-top: 3px solid #f39c12;">
            <div class="course-stat" style="color: #f39c12;">{{ $inProgress }}</div>
            <div class="course-stat-label mt-1">作答中</div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card text-center py-3" style="border-top: 3px solid #e74c3c;">
            <div class="course-stat" style="color: #e74c3c;">{{ $notStarted }}</div>
            <div class="course-stat-label mt-1">未開始</div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3">
        <div class="card text-center py-3" style="border-top: 3px solid var(--color-primary);">
            <div id="peopleDisplay">
                <div class="course-stat" style="color: var(--color-primary);">{{ $class->People }}</div>
                <div class="course-stat-label mt-1">
                    課程人數
                    @if($class->ClassLink !== 'demo')
                    <button type="button" onclick="togglePeopleEdit()"
                            title="修改人數"
                            style="background:none;border:none;padding:0 0 2px 4px;cursor:pointer;
                                   color:var(--color-muted);font-size:0.8rem;line-height:1;vertical-align:middle;">
                        ✎
                    </button>
                    @endif
                </div>
            </div>
            @if($class->ClassLink !== 'demo')
            <div id="peopleEdit" style="display:none; padding: 0.25rem 0.75rem 0;">
                <form action="{{ route('backend.ClassUpdate', $id) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="input-group input-group-sm">
                        <input type="number" name="People" value="{{ $class->People }}" min="1"
                               id="peopleInput"
                               class="form-control text-center"
                               style="font-size:1.1rem;font-weight:700;color:var(--color-primary);padding:0.2rem 0.4rem;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary btn-sm" type="button"
                                    onclick="togglePeopleEdit()" title="取消"
                                    style="padding:0.2rem 0.45rem;line-height:1;">✕</button>
                            <button class="btn btn-sm" type="submit" title="儲存"
                                    style="background:var(--color-accent);color:#fff;padding:0.2rem 0.45rem;line-height:1;">✓</button>
                        </div>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- 學員列表 --}}
<div class="card">
    <div class="card-header">學員自評問卷列表</div>
    <div class="table-responsive">
        @if($students->isEmpty())
            <div class="text-center py-5 text-muted" style="font-size: 0.875rem;">
                尚無學員填寫問卷
            </div>
        @else
            <table class="table table-hover mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none; padding: 0.75rem 1.25rem;">學員姓名</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">問卷連結</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">他評問卷數</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">分析報表</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @php
                            $answerCount = \App\Models\answer::where('studentID', $student->id)
                                ->whereNull('otherID')->count();
                            if ($answerCount == 12) {
                                $statusColor  = '#1ABC9C';
                                $statusLabel  = '已完成';
                                $statusBg     = 'rgba(26,188,156,0.1)';
                            } elseif ($answerCount > 0) {
                                $statusColor  = '#f39c12';
                                $statusLabel  = '作答中 ' . $answerCount . '/12';
                                $statusBg     = 'rgba(243,156,18,0.1)';
                            } else {
                                $statusColor  = '#e74c3c';
                                $statusLabel  = '未開始';
                                $statusBg     = 'rgba(231,76,60,0.1)';
                            }
                        @endphp
                        <tr>
                            <td style="padding: 0.85rem 1.25rem; vertical-align: middle;">
                                <div class="d-flex align-items-center" style="gap: 0.6rem;">
                                    <a href="{{ route('student.StudentShow', ['Sid' => $student->id]) }}"
                                       style="color: {{ $statusColor }}; font-weight: 600;">
                                        {{ $student->name }}
                                    </a>
                                    <span style="font-size: 0.72rem; font-weight: 600; color: {{ $statusColor }};
                                                 background: {{ $statusBg }}; border-radius: 20px;
                                                 padding: 0.15em 0.65em; white-space: nowrap;">
                                        {{ $statusLabel }}
                                    </span>
                                </div>
                            </td>
                            <td style="vertical-align: middle; max-width: 260px;">
                                @php $quizUrl = route('student.ResumeQuiz', ['Sid' => $student->id]); @endphp
                                <div class="d-flex align-items-center" style="gap: 0.4rem;">
                                    <span class="course-link-box" style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                        {{ $quizUrl }}
                                    </span>
                                    <button type="button"
                                            onclick="copyUrl('{{ $quizUrl }}', this)"
                                            class="btn btn-outline-secondary btn-sm flex-shrink-0"
                                            style="padding: 0.2rem 0.5rem; font-size: 0.75rem;">
                                        複製
                                    </button>
                                </div>
                            </td>
                            <td style="vertical-align: middle;">
                                @php $totalOthers = \App\Models\other::where('studentID', $student->id)->count(); @endphp
                                <span style="font-size: 0.875rem; color: var(--color-text);">
                                    共 {{ $totalOthers }} 個
                                </span>
                                <span style="color: var(--color-muted); font-size: 0.8rem; margin: 0 0.15rem;">·</span>
                                <span style="font-size: 0.875rem; color: var(--color-accent); font-weight: 600;">
                                    已完成 {{ $student->OthersCount }}
                                </span>
                            </td>
                            <td style="vertical-align: middle;">
                                <a href="{{ route('student.page2_pdf', ['Sid' => $student->id]) }}"
                                   class="btn btn-outline-secondary btn-sm" target="_blank">
                                    產生分析表
                                </a>
                            </td>
                            <td style="vertical-align: middle;">
                                @if($class->ClassLink === 'demo')
                                    <button type="button" onclick="confirmDeleteDemo()"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                @else
                                    <button type="button"
                                            onclick="confirmDelete('delStudent{{ $student->id }}','確定要刪除此學員？','將同時刪除該學員的所有作答記錄')"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                    <form id="delStudent{{ $student->id }}"
                                          action="{{ route('student.destroyStudent', $student->id) }}"
                                          method="POST" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert" style="border-radius:0.4rem;font-size:0.9rem;">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert" style="border-radius:0.4rem;font-size:0.9rem;">
    {{ session('error') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    function togglePeopleEdit() {
        var display = document.getElementById('peopleDisplay');
        var edit    = document.getElementById('peopleEdit');
        var input   = document.getElementById('peopleInput');
        if (edit.style.display === 'none') {
            edit.style.display = 'block';
            display.style.display = 'none';
            if (input) { input.focus(); input.select(); }
        } else {
            edit.style.display = 'none';
            display.style.display = 'block';
        }
    }
    (function () {
        if (localStorage.getItem('help_classshow') === '0') {
            document.getElementById('helpContent_classshow').style.display = 'none';
            document.getElementById('helpBtn_classshow').innerHTML = '▼ 展開說明';
        }
    })();
    function confirmDeleteDemo() {
        Swal.fire({
            title: '確定要刪除？',
            text: '此操作將同時刪除所有相關作答記錄，無法復原！',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            confirmButtonText: '確定刪除',
            cancelButtonText: '取消'
        }).then(function (result) {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'error',
                    title: '無法刪除',
                    text: '範例課程的資料僅供展示使用，無法刪除。',
                    confirmButtonColor: '#2C3E50'
                });
            }
        });
    }
</script>
@endsection

@section('scripts')
<script>
    function copyUrl(url, btn) {
        navigator.clipboard.writeText(url).then(function () {
            var orig = btn.textContent;
            btn.textContent = '已複製';
            btn.style.color = '#1ABC9C';
            btn.style.borderColor = '#1ABC9C';
            setTimeout(function () {
                btn.textContent = orig;
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 1500);
        });
    }
</script>
@endsection
