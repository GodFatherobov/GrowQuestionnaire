@extends('layouts.quiz')

@section('title', '他評回饋列表')

@section('content')

<div class="text-center mb-4">
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary); font-size: 1.5rem;">
        {{ $student->name }} 的他評回饋
    </h2>
    <p class="text-muted mb-0" style="font-size: 0.875rem;">Others' Feedback Responses</p>
</div>

@php
    $completed = $others->where('doneQuiz', 1);
    $pending   = $others->where('doneQuiz', '!=', 1);
@endphp

<div class="mb-4" id="helpWrapper_otherindex">
    <div class="d-flex justify-content-end mb-1">
        <button type="button" id="helpBtn_otherindex" onclick="toggleHelp('otherindex')"
                class="btn btn-link btn-sm p-0 text-muted" style="font-size: 0.8rem; text-decoration: none;">
            ▲ 收起說明
        </button>
    </div>
    <div id="helpContent_otherindex" class="card"
         style="border-color: rgba(26,188,156,0.25); background: rgba(26,188,156,0.04);">
        <div class="card-body" style="padding: 1rem 1.25rem; font-size: 0.875rem; line-height: 1.75; color: var(--color-text);">
            此頁面顯示所有已收到的他人評量記錄。他人評量能幫助您了解他人眼中您的領導風格，與自評結果對照，提供更全面的領導力發展建議。
        </div>
    </div>
</div>

{{-- 統計 --}}
<div class="row mb-4">
    <div class="col-6">
        <div class="card text-center py-3">
            <div style="font-size: 1.6rem; font-weight: 700; color: var(--color-accent);">{{ $completed->count() }}</div>
            <div style="font-size: 0.7rem; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.2rem;">已完成</div>
        </div>
    </div>
    <div class="col-6">
        <div class="card text-center py-3">
            <div style="font-size: 1.6rem; font-weight: 700; color: #e74c3c;">{{ $pending->count() }}</div>
            <div style="font-size: 0.7rem; color: var(--color-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-top: 0.2rem;">未完成</div>
        </div>
    </div>
</div>

@if($others->isEmpty())
    <div class="card text-center py-5">
        <p class="text-muted mb-0">尚無他評回饋</p>
    </div>
@else
    @if($completed->isNotEmpty())
        <h6 class="font-weight-bold mb-3" style="color: var(--color-primary); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.06em;">
            已完成回饋
        </h6>
        <div class="row mb-4">
            @foreach($completed as $other)
                <div class="col-sm-6 mb-3">
                    <div class="card h-100" style="border-left: 3px solid var(--color-accent);">
                        <div class="card-body d-flex justify-content-between align-items-center" style="padding: 1rem 1.25rem;">
                            <div>
                                <div class="font-weight-bold" style="color: var(--color-primary);">{{ $other->type }}</div>
                                <div style="font-size: 0.775rem; color: var(--color-muted);">已完成 12 題</div>
                            </div>
                            <div class="d-flex" style="gap: 0.4rem;">
                                <a href="{{ route('student.OtherShow', ['Oid' => $other->id]) }}"
                                   class="btn btn-outline-secondary btn-sm">查看</a>
                                @if($isDemo)
                                    <button type="button" onclick="confirmDeleteDemo()"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                @else
                                    <button type="button"
                                            onclick="confirmDelete('delOther{{ $other->id }}','確定要刪除此評量記錄？','該評量者的所有作答將一併刪除')"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                    <form id="delOther{{ $other->id }}"
                                          action="{{ route('student.destroyOther', $other->id) }}"
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

    @if($pending->isNotEmpty())
        <h6 class="font-weight-bold mb-3" style="color: var(--color-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.06em;">
            填寫中
        </h6>
        <div class="row">
            @foreach($pending as $other)
                <div class="col-sm-6 mb-3">
                    <div class="card h-100" style="border-left: 3px solid #dee2e6;">
                        <div class="card-body d-flex justify-content-between align-items-center" style="padding: 1rem 1.25rem;">
                            <div>
                                <div class="font-weight-bold text-muted">{{ $other->type }}</div>
                                <div style="font-size: 0.775rem; color: var(--color-muted);">尚未完成</div>
                            </div>
                            <div class="d-flex" style="gap: 0.4rem;">
                                <span class="badge badge-secondary" style="align-self: center;">未完成</span>
                                @if($isDemo)
                                    <button type="button" onclick="confirmDeleteDemo()"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                @else
                                    <button type="button"
                                            onclick="confirmDelete('delOther{{ $other->id }}','確定要刪除此評量記錄？','該評量者的所有作答將一併刪除')"
                                            class="btn btn-outline-danger btn-sm">刪除</button>
                                    <form id="delOther{{ $other->id }}"
                                          action="{{ route('student.destroyOther', $other->id) }}"
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
@endif

<div class="mt-4">
    <a href="{{ route('student.StudentShow', ['Sid' => $student->id]) }}"
       class="btn btn-outline-secondary">&larr; 返回學員資訊</a>
</div>

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    (function () {
        if (localStorage.getItem('help_otherindex') === '0') {
            document.getElementById('helpContent_otherindex').style.display = 'none';
            document.getElementById('helpBtn_otherindex').innerHTML = '▼ 展開說明';
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
