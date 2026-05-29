@extends('layouts.quiz')

@section('title', '完成他評問卷')

@section('progress-width')100@endsection
@section('progress-label')完成 ✓@endsection

@section('content')

@if($isDemo ?? false)
<div class="alert alert-warning mb-4" role="alert" style="border-radius: 0.4rem; font-size: 0.9rem;">
    <strong>範例模式</strong>　這是範例模式，資料不會儲存。如需正式使用，請洽詢課程負責人或註冊帳號。
</div>
@endif

<div class="text-center mb-4">
    <div style="font-size: 3.5rem; line-height: 1; color: var(--color-accent); margin-bottom: 0.75rem;">&#10003;</div>
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary);">感謝您的填寫！</h2>
    <p class="text-muted">Thank you for completing the feedback!</p>
</div>

<div class="card">
    <div class="card-body text-center" style="padding: 2rem;">
        <p class="mb-2" style="font-size: 0.95rem;">
            您的回饋將幫助該領導者更了解自身的領導風格，非常感謝您的參與！
        </p>
        <p class="text-muted mb-0" style="font-size: 0.875rem;">
            Your feedback will help this leader better understand their leadership style.<br>
            Thank you for your participation!
        </p>
    </div>
</div>

@include('sweetalert::alert')

@endsection
