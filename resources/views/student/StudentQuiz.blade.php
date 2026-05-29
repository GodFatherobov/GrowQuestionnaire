@extends('layouts.quiz')

@section('title', '問卷填寫')

@section('content')

@if($isDemo ?? false)
<div class="alert alert-warning mb-4" role="alert" style="border-radius: 0.4rem; font-size: 0.9rem;">
    <strong>範例模式</strong>　您正在使用範例模式，填寫的資料不會被儲存。
</div>
@endif

<div class="text-center mb-4">
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary); font-size: 1.65rem;">
        {{ $class->ClassName ?? '情境領導力問卷' }}
    </h2>
    <p class="text-muted mb-0">LEAD Self 領導力自我評估</p>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding: 1.75rem;">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
                <label for="Name" class="font-weight-bold">
                    您的姓名
                    <span class="font-weight-normal text-muted ml-1" style="font-size: 0.85rem;">Your Name</span>
                </label>
                <input id="Name" type="text"
                       class="form-control form-control-lg @error('Name') is-invalid @enderror"
                       name="Name" value="{{ old('Name') }}"
                       placeholder="請輸入您的姓名"
                       required autocomplete="off" autofocus>
                @error('Name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-accent btn-block" style="padding: 0.7rem; font-size: 1rem;">
                開始填寫 &rarr;
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">目的 &nbsp;Purpose</div>
    <div class="card-body" style="font-size: 0.875rem; line-height: 1.85; padding: 1.5rem;">
        <p class="mb-1">此評量工具用於評估你嘗試影響他人的行為和態度時，所使用的領導行為。透過「LEAD Self 自我評估」所收集的資訊，可以深入了解你目前的優勢，以及領導力技巧發展的領域。</p>
        <p class="text-muted mb-4" style="font-size: 0.825rem;">This assessment is used to evaluate the leadership behaviors you use when attempting to influence the actions and attitudes of others. The LEAD Self provides insight into your current strengths and areas for leadership skill development.</p>

        <h6 class="font-weight-bold mb-2">說明 &nbsp;Instructions</h6>
        <ul style="padding-left: 1.25rem; margin-bottom: 0.75rem;">
            <li>假設你參與以下 12 種情境，每種情境有四種行動選項</li>
            <li>請選擇你認為最接近你在該情境中<strong>實際會</strong>採取的行動</li>
            <li>快速瀏覽並堅持第一選擇，第一直覺通常最準確</li>
        </ul>
        <ul class="text-muted mb-4" style="padding-left: 1.25rem; font-size: 0.825rem;">
            <li>Each of the 12 situations has four alternative actions — select the one most like what you would do</li>
            <li>Move through quickly and stick with your first choice — it tends to be the most accurate</li>
        </ul>

        <div class="alert alert-warning mb-0" style="font-size: 0.875rem; border-radius: 0.4rem;">
            <strong>重要：</strong>選擇你<strong>可能做出</strong>的反應，而非你<strong>應該做出</strong>的反應。<br>
            <span class="text-muted" style="font-size: 0.825rem;"><strong>Important:</strong> Choose what you <strong>would</strong> do — not what you <strong>should</strong> do.</span>
        </div>
    </div>
</div>

@include('sweetalert::alert')

@endsection
