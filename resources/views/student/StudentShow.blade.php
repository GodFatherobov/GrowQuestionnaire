@extends('layouts.quiz')

@section('title', $student->name . ' 的作答結果')

@section('content')

<div class="text-center mb-4">
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary); font-size: 1.5rem;">
        {{ $student->name }} 的作答結果
    </h2>
    <p class="text-muted mb-0" style="font-size: 0.875rem;">Self-Assessment Responses</p>
</div>

<div class="mb-4" id="helpWrapper_studentshow">
    <div class="d-flex justify-content-end mb-1">
        <button type="button" id="helpBtn_studentshow" onclick="toggleHelp('studentshow')"
                class="btn btn-link btn-sm p-0 text-muted" style="font-size: 0.8rem; text-decoration: none;">
            ▲ 收起說明
        </button>
    </div>
    <div id="helpContent_studentshow" class="card"
         style="border-color: rgba(26,188,156,0.25); background: rgba(26,188,156,0.04);">
        <div class="card-body" style="padding: 1rem 1.25rem; font-size: 0.875rem; line-height: 1.75; color: var(--color-text);">
            這是您的自評作答記錄。您可以在此邀請主管、同事或部屬填寫他人評量問卷，完成後即可產生完整的領導力分析報告。
        </div>
    </div>
</div>

{{-- 邀請連結 --}}
<div class="card mb-4" style="border-left: 3px solid var(--color-accent);">
    <div class="card-body" style="padding: 1rem 1.25rem;">
        <div class="text-muted mb-1" style="font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.06em;">他評邀請連結</div>
        <a href="{{ route('student.OthersQuiz', ['Sid' => $student->id]) }}"
           style="font-size: 0.875rem; color: var(--color-accent); word-break: break-all; font-family: monospace;">
            {{ route('student.OthersQuiz', ['Sid' => $student->id]) }}
        </a>
    </div>
</div>

{{-- 作答記錄 --}}
<div class="card mb-4">
    <div class="card-header">12 題作答記錄</div>
    <div class="table-responsive">
        @if($answers->isEmpty())
            <div class="text-center py-4 text-muted" style="font-size: 0.875rem;">尚無作答記錄</div>
        @else
            <table class="table table-hover mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none; padding: 0.75rem 1.25rem;">題目</th>
                        <th style="font-size: 0.8rem; color: var(--color-muted); font-weight: 600; border-top: none;">作答選項</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($answers as $answer)
                        <tr>
                            <td style="padding: 0.85rem 1.25rem; vertical-align: middle; color: var(--color-text);">
                                第 {{ $answer->questionID }} 題
                            </td>
                            <td style="vertical-align: middle;">
                                @php
                                    $badgeColors = [
                                        'A' => '#3498db',
                                        'B' => '#1ABC9C',
                                        'C' => '#f39c12',
                                        'D' => '#9b59b6',
                                    ];
                                    $color = $badgeColors[$answer->answer] ?? '#6c757d';
                                @endphp
                                <span class="badge badge-pill"
                                      style="background: {{ $color }}; color: #fff; font-size: 0.9rem; padding: 0.4em 0.9em; font-weight: 700;">
                                    {{ $answer->answer }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

{{-- 操作按鈕 --}}
<div class="d-flex flex-wrap" style="gap: 0.75rem;">
    <a href="{{ route('student.OtherIndex', ['Sid' => $student->id]) }}"
       class="btn btn-primary">
        查看他人評量
    </a>
    <a href="{{ route('student.page2_pdf', ['Sid' => $student->id]) }}"
       class="btn btn-accent" target="_blank">
        產生分析報告
    </a>
    <a href="{{ route('backend.ClassShow', ['id' => $student->classID]) }}"
       class="btn btn-outline-secondary">&larr; 返回課程</a>
</div>

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    (function () {
        if (localStorage.getItem('help_studentshow') === '0') {
            document.getElementById('helpContent_studentshow').style.display = 'none';
            document.getElementById('helpBtn_studentshow').innerHTML = '▼ 展開說明';
        }
    })();
</script>
@endsection
