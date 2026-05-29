@extends('layouts.quiz')

@section('title', '完成問卷 – 情境領導力問卷')

@section('progress-width')100@endsection
@section('progress-label')完成 ✓@endsection

@section('content')

@if(($isDemo ?? false) || $Sid === 'demo')
<div class="alert alert-warning mb-4" role="alert" style="border-radius: 0.4rem; font-size: 0.9rem;">
    <strong>範例模式</strong>　這是範例模式，資料不會儲存。如需正式使用，請洽詢課程負責人或註冊帳號。
</div>
@endif

<div class="text-center mb-4">
    <div style="font-size: 3.5rem; line-height: 1; margin-bottom: 0.75rem;">&#10003;</div>
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary);">感謝您的填寫！</h2>
    <p class="text-muted">Thank you for completing the questionnaire!</p>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding: 1.5rem;">
        <p class="mb-2">
            <span style="font-weight: 600; color: var(--color-primary);">1.</span>
            情境領導 LEAD 領導力問卷分析報告將於上課當天分發。
        </p>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            The Situational Leadership® LEAD questionnaire analysis report will be distributed on the training day.
        </p>
    </div>
</div>

<div class="card mb-4" style="border-color: rgba(26,188,156,0.3);">
    <div class="card-header" style="background: rgba(26,188,156,0.06); border-color: rgba(26,188,156,0.2); color: var(--color-accent);">
        <span style="font-weight: 700; font-size: 0.95rem;">2. 邀請他人給您回饋</span>
        <span class="text-muted font-weight-normal ml-2" style="font-size: 0.85rem;">Invite others to give you feedback</span>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <p style="font-size: 0.9rem;">
            請發送以下邀請函給您的<strong>上級主管、部屬、同事</strong>，建議至少 <strong>4 位</strong>，越多越好。
        </p>
        <p class="text-muted" style="font-size: 0.85rem; margin-bottom: 1.25rem;">
            Please send the invitation below to your leaders, subordinates, and peers. We recommend at least 4 people.
        </p>

        <div style="background: #f8fafc; border: 1px solid var(--color-border); border-radius: 0.4rem; padding: 1.25rem; font-size: 0.875rem; line-height: 1.85;">
            <p class="mb-2"><strong>親愛的夥伴：</strong></p>
            <p class="mb-3">
                我即將參加「情境領導 Situational Leadership®」培訓課程，希望邀請您幫我進行領導行為的回饋，以幫助我了解自己領導風格的使用狀況。這份問卷共有 12 道題，大約花費 <strong>8 分鐘</strong>，非常感謝您的投入！
            </p>
            <p class="mb-2 text-muted" style="font-size: 0.825rem;"><strong>Dear Partners:</strong></p>
            <p class="text-muted mb-3" style="font-size: 0.825rem;">
                I am about to attend the Situational Leadership® training program. I would like to invite you to give me feedback on my leadership behaviors. This is a 12-question questionnaire that will take about <strong>8 minutes</strong>. Thank you so much!
            </p>
            <div style="background: #fff; border: 1px dashed var(--color-accent); border-radius: 0.375rem; padding: 0.75rem; text-align: center;">
                <a href="{{ route('student.OthersQuiz', ['Sid' => $Sid]) }}"
                   style="color: var(--color-accent); font-weight: 600; word-break: break-all; font-size: 0.875rem;">
                    {{ route('student.OthersQuiz', ['Sid' => $Sid]) }}
                </a>
            </div>
        </div>
    </div>
</div>

@include('sweetalert::alert')

@endsection
