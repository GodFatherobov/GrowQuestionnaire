@extends('layouts.quiz')

@section('title', '他評問卷填寫')

@section('content')

@if($isDemo ?? false)
<div class="alert alert-warning mb-4" role="alert" style="border-radius: 0.4rem; font-size: 0.9rem;">
    <strong>範例模式</strong>　您正在使用範例模式，填寫的資料不會被儲存。
</div>
@endif

<div class="text-center mb-4">
    <h2 class="font-weight-bold mb-1" style="color: var(--color-primary); font-size: 1.5rem;">
        領導行為他評問卷
    </h2>
    <p class="text-muted mb-0" style="font-size: 0.9rem;">Leadership Style / Perception of Other</p>
</div>

<div class="card mb-4">
    <div class="card-body" style="padding: 1.75rem;">
        <div class="d-flex align-items-center mb-4 p-3"
             style="background: rgba(26,188,156,0.07); border-radius: 0.5rem; border-left: 4px solid var(--color-accent);">
            <div>
                <div class="text-muted" style="font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em;">您正在評估</div>
                <div class="font-weight-bold" style="font-size: 1.15rem; color: var(--color-primary);">
                    {{ $student->name }}
                </div>
            </div>
        </div>

        <form action="" method="POST" id="typeForm">
            @csrf
            <p class="font-weight-bold mb-3" style="color: var(--color-primary);">
                您是這位領導者的
                <span class="font-weight-normal text-muted ml-1" style="font-size: 0.85rem;">You are this leader's… (select one)</span>
            </p>

            <input type="radio" name="type" id="type_boss" value="上級主管" class="option-radio" required>
            <label for="type_boss" class="option-card">
                <div class="option-text">
                    <div class="option-chinese">上級主管</div>
                    <div class="option-english">Supervisor</div>
                </div>
            </label>

            <input type="radio" name="type" id="type_sub" value="部屬" class="option-radio">
            <label for="type_sub" class="option-card">
                <div class="option-text">
                    <div class="option-chinese">部屬</div>
                    <div class="option-english">Subordinate</div>
                </div>
            </label>

            <input type="radio" name="type" id="type_peer" value="同事" class="option-radio">
            <label for="type_peer" class="option-card">
                <div class="option-text">
                    <div class="option-chinese">同事</div>
                    <div class="option-english">Peer</div>
                </div>
            </label>

            <input type="radio" name="type" id="type_other" value="其他" class="option-radio">
            <label for="type_other" class="option-card">
                <div class="option-text">
                    <div class="option-chinese">其他</div>
                    <div class="option-english">Other</div>
                </div>
            </label>

            <div class="mt-4">
                <button type="submit" class="btn btn-accent btn-block" style="padding: 0.7rem; font-size: 1rem;">
                    開始填寫 &rarr;
                </button>
                <p id="noTypeMsg" class="text-danger text-center mt-2 mb-0" style="display:none; font-size: 0.875rem;">
                    請選擇您與此領導者的關係
                </p>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">目的 &nbsp;Purpose</div>
    <div class="card-body" style="font-size: 0.875rem; line-height: 1.85; padding: 1.5rem;">
        <p class="mb-2">本評量工具用於概括 <strong>{{ $student->name }}</strong> 的影響行為，透過「LEAD Other 他人評估」可深入了解該領導者目前的優勢及領導力技巧發展領域。</p>
        <p class="text-muted mb-4" style="font-size: 0.825rem;">This assessment profiles the influence behaviors of <strong>{{ $student->name }}</strong>. The LEAD Other provides insight into this leader's current strengths and areas for leadership skill development.</p>

        <h6 class="font-weight-bold mb-2">說明 &nbsp;Instructions</h6>
        <ul style="padding-left: 1.25rem; margin-bottom: 0.75rem;">
            <li>假設 {{ $student->name }} 參與以下 12 種情境，思考您認為他/她在每種情境中可能採取的行動</li>
            <li>選擇最接近此人在面臨情境時會採取的行動選項，請勿跳過任何情境</li>
            <li>快速瀏覽並堅持第一選擇</li>
        </ul>
        <div class="alert alert-warning mb-0" style="font-size: 0.875rem; border-radius: 0.4rem;">
            <strong>重要：</strong>選擇此領導者<strong>可能做出</strong>的反應，而非<strong>應該做出</strong>的反應。<br>
            <span class="text-muted" style="font-size: 0.825rem;"><strong>Important:</strong> Check what you think this person <strong>would</strong> do — not what they <strong>should</strong> do.</span>
        </div>
    </div>
</div>

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    document.getElementById('typeForm').addEventListener('submit', function (e) {
        if (!document.querySelector('input[name="type"]:checked')) {
            e.preventDefault();
            document.getElementById('noTypeMsg').style.display = 'block';
        }
    });
    document.querySelectorAll('input[name="type"]').forEach(function (r) {
        r.addEventListener('change', function () {
            document.getElementById('noTypeMsg').style.display = 'none';
        });
    });
</script>
@endsection
