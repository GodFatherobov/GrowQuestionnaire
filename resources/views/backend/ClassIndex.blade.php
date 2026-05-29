@extends('layouts.app')

@section('title', '課程列表')

@section('content')

<div class="mb-4" id="helpWrapper_classindex">
    <div class="d-flex justify-content-end mb-1">
        <button type="button" id="helpBtn_classindex" onclick="toggleHelp('classindex')"
                class="btn btn-link btn-sm p-0 text-muted" style="font-size: 0.8rem; text-decoration: none;">
            ▲ 收起說明
        </button>
    </div>
    <div id="helpContent_classindex" class="card"
         style="border-color: rgba(26,188,156,0.25); background: rgba(26,188,156,0.04);">
        <div class="card-body" style="padding: 1rem 1.25rem; font-size: 0.875rem; line-height: 1.75; color: var(--color-text);">
            歡迎使用情境領導力問卷系統。在這裡您可以建立問卷課程，將問卷連結分享給學員填寫，並查看學員的作答狀況與分析報告。點擊「範例課程」可以查看完整的示範資料。
        </div>
    </div>
</div>

<div class="page-header d-flex justify-content-between align-items-start flex-wrap">
    <div>
        <h1>課程列表</h1>
        <p>管理所有問卷課程，點擊「查看詳情」可查看學員填寫狀況。</p>
    </div>
    <button type="button" class="btn btn-accent mt-1"
            data-toggle="modal" data-target="#createClassModal">
        + 新增課程
    </button>
</div>

@if($classes->isEmpty())
    <div class="card text-center py-5">
        <div class="card-body">
            <p class="text-muted mb-3">尚未建立任何課程</p>
            <button type="button" class="btn btn-accent"
                    data-toggle="modal" data-target="#createClassModal">
                建立第一個課程
            </button>
        </div>
    </div>
@else
    <div class="row">
        @foreach($classes as $class)
            @php
                $completedCount = \App\Models\student::where('classID', $class->id)->count();
            @endphp
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card course-card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title font-weight-bold mb-3" style="color: var(--color-primary);">
                            {{ $class->ClassName }}
                            @if($class->ClassLink === 'demo')
                                <span style="font-size: 0.65rem; font-weight: 700; background: #1ABC9C; color: #fff;
                                             padding: 0.25em 0.6em; border-radius: 3px; vertical-align: middle;
                                             margin-left: 0.4rem; letter-spacing: 0.03em;">範例</span>
                            @endif
                        </h5>
                        <div class="d-flex mb-3">
                            <div class="mr-4">
                                <div class="course-stat">{{ $class->People }}</div>
                                <div class="course-stat-label">課程人數</div>
                            </div>
                            <div>
                                <div class="course-stat" style="color: var(--color-accent);">
                                    {{ $completedCount }}
                                </div>
                                <div class="course-stat-label">已完成</div>
                            </div>
                        </div>
                        <div class="course-link-box mb-3">
                            {{ Request::root() }}/{{ $class->ClassLink }}/Quiz
                        </div>
                        <div class="d-flex mt-auto" style="gap: 0.5rem;">
                            <a href="{{ route('backend.ClassShow', ['id' => $class->id]) }}"
                               class="btn btn-primary btn-sm flex-fill">查看詳情</a>
                            @if($class->ClassLink === 'demo')
                                <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="confirmDeleteDemo()">刪除</button>
                            @else
                                <button type="button"
                                        onclick="confirmDelete('delClass{{ $class->id }}','確定要刪除此課程？','此操作將同時刪除所有學員資料和作答記錄，無法復原！')"
                                        class="btn btn-outline-danger btn-sm">刪除</button>
                                <form id="delClass{{ $class->id }}"
                                      action="{{ route('backend.ClassDestroy', $class->id) }}"
                                      method="POST" class="d-none">
                                    @csrf @method('DELETE')
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Create Class Modal --}}
<div class="modal fade" id="createClassModal" tabindex="-1" role="dialog"
     aria-labelledby="createClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createClassModalLabel">新增課程</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('backend.ClassCreate') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="ClassName">課程名稱</label>
                        <input id="ClassName"
                               type="text"
                               class="form-control @error('ClassName') is-invalid @enderror"
                               name="ClassName"
                               value="{{ old('ClassName') }}"
                               placeholder="例：2024 Q1 情境領導培訓"
                               required autofocus>
                        @error('ClassName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label for="people">課程人數</label>
                        <input id="people"
                               type="number"
                               class="form-control @error('people') is-invalid @enderror"
                               name="people"
                               value="{{ old('people') }}"
                               placeholder="請輸入預計人數"
                               min="1"
                               required>
                        @error('people')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-accent">建立課程</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    (function () {
        if (localStorage.getItem('help_classindex') === '0') {
            document.getElementById('helpContent_classindex').style.display = 'none';
            document.getElementById('helpBtn_classindex').innerHTML = '▼ 展開說明';
        }
    })();

    function confirmDeleteDemo() {
        Swal.fire({
            title: '確定要刪除此課程？',
            text: '此操作將同時刪除所有學員資料和作答記錄，無法復原！',
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
                    text: '範例課程僅供展示使用，無法刪除。',
                    confirmButtonColor: '#2C3E50'
                });
            }
        });
    }
</script>
@if($errors->any())
<script>
    $(document).ready(function () {
        $('#createClassModal').modal('show');
    });
</script>
@endif
@endsection
