@extends('layouts.quiz')

@section('title', '第 ' . ($Qid - 12) . ' 題 – 他評問卷')

@section('progress-width'){{ round(($Qid - 12) / 12 * 100) }}@endsection
@section('progress-label'){{ $Qid - 12 }} / 12@endsection

@section('content')

{{-- Question card --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center">
        <span class="badge badge-secondary mr-2"
              style="font-size: 0.8rem; background: var(--color-primary);">
            情境 {{ $question->id - 12 }}
        </span>
        <span>這位領導者會如何回應？&nbsp;
            <span class="text-muted font-weight-normal" style="font-size: 0.85rem;">How would this leader respond?</span>
        </span>
    </div>
    <div class="card-body" style="padding: 1.5rem;">
        <p class="font-weight-bold mb-2" style="font-size: 1.05rem; color: var(--color-primary);">
            {{ $question->Question }}
        </p>
        <p class="text-muted mb-0" style="font-size: 0.9rem; line-height: 1.7;">
            @php $qNum = $question->id - 12; @endphp
            @if($qNum == 1) A team member is not responding lately to this leader's friendly conversation and obvious concern for her welfare. She seems frustrated and is not finishing tasks on time.
            @elseif($qNum == 2) A new team member is beginning to learn, at a steady pace, the task this leader has assigned and his performance is improving. He is prematurely asking for more challenging tasks.
            @elseif($qNum == 3) A team member is concerned about a recently assigned routine project. On projects like this, this leader has normally left him alone. The team member's past performance and interpersonal relations have been good.
            @elseif($qNum == 4) A team member has proposed a change that she wants to implement. She is enthusiastic and has a fine record of accomplishment in this area. This leader views her suggestion as extremely valuable.
            @elseif($qNum == 5) A team member's performance has been dropping during the last few months. She has been unconcerned with meeting objectives. She continually needs coaching to ensure her tasks are done on time.
            @elseif($qNum == 6) Based on feedback from a previous supervisor, this leader has been closely supervising and directing a team member on a critical task. She is responding favorably and this leader would now like to help her become more efficient.
            @elseif($qNum == 7) This leader is considering changing a work procedure. This leader assigns the task to a team member who knows the procedure well. He expresses concern about his workload and the things that could go wrong.
            @elseif($qNum == 8) A team member's performance and peer relationships are strong. This leader feels somewhat concerned about letting her independently take on an important project.
            @elseif($qNum == 9) This leader has been appointed to head a task force. One team member in particular presents a number of challenges. He appears to be unclear on the goals of the task force and his attendance at scheduled meetings has been sporadic. From what this leader has observed, he treats the meetings he does attend as social gatherings. His behavior is affecting the other team members.
            @elseif($qNum == 10) A team member who is usually able to take responsibility is having difficulty understanding some recent redefining of standards.
            @elseif($qNum == 11) This leader has assigned a task to a team member who has completed it before at an acceptable level. This leader has allowed her to work fairly independently in the past, but she now wants the leader's input and involvement.
            @elseif($qNum == 12) In a recent meeting, a team member passionately stated his point of view. In this meeting, his peers expressed disagreement with this team member's viewpoint. This particular team member has a remarkable record of accomplishment. The team, as a whole, has worked in harmony for the past year and all are well qualified for the task.
            @endif
        </p>
    </div>
</div>

{{-- Options --}}
<form id="otherQuestionForm"
      action="{{ route('student.StoreOtherAnswer', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => $Qid]) }}"
      method="POST" enctype="multipart/form-data">
    @csrf

    <p class="font-weight-bold mb-3" style="color: var(--color-primary);">
        行動選項 – 這位領導者可能會…
        <span class="text-muted font-weight-normal ml-1" style="font-size: 0.85rem;">ALTERNATIVE ACTIONS – This leader would…</span>
    </p>

    {{-- Option A --}}
    <input type="radio" name="answer" id="optA" value="A" class="option-radio" {{ $currentAnswer == 'A' ? 'checked' : '' }}>
    <label for="optA" class="option-card">
        <span class="option-letter">A</span>
        <div class="option-text">
            <div class="option-chinese">{{ $question->Option1 }}</div>
            <div class="option-english">
                @if($qNum == 1) Help her learn the task step by step and let her know the consequences of missed deadlines.
                @elseif($qNum == 2) Praise his improvement, explain next steps in mastering his current tasks and explain how they connect to the bigger picture.
                @elseif($qNum == 3) Give specific directions on the new project while providing him the opportunity to ask clarifying questions.
                @elseif($qNum == 4) Involve her in developing the change plans while providing ongoing encouragement.
                @elseif($qNum == 5) Observe and monitor her performance over time, as needed.
                @elseif($qNum == 6) Discuss ideas on improving productivity and encourage her to be more efficient.
                @elseif($qNum == 7) Define the changed procedure and supervise carefully.
                @elseif($qNum == 8) Ask for periodic project updates and continue to monitor her performance.
                @elseif($qNum == 9) Observe the task force action and allow them to work this out on their own.
                @elseif($qNum == 10) Listen to concerns and reassure the team member about the new standards.
                @elseif($qNum == 11) Provide her with step-by-step directions on how to carry out the task.
                @elseif($qNum == 12) Convince the team member of the need to reach agreement.
                @endif
            </div>
        </div>
    </label>

    {{-- Option B --}}
    <input type="radio" name="answer" id="optB" value="B" class="option-radio" {{ $currentAnswer == 'B' ? 'checked' : '' }}>
    <label for="optB" class="option-card">
        <span class="option-letter">B</span>
        <div class="option-text">
            <div class="option-chinese">{{ $question->Option2 }}</div>
            <div class="option-english">
                @if($qNum == 1) Ask her how she plans to get back on track, and encourage her to do so.
                @elseif($qNum == 2) Observe performance and provide feedback, when appropriate.
                @elseif($qNum == 3) Give him the necessary resources and authority, then monitor as needed.
                @elseif($qNum == 4) Provide guidance on how to implement the change.
                @elseif($qNum == 5) Explain what needs to be done and why it is important. Answer questions, as needed.
                @elseif($qNum == 6) Continue to closely supervise and direct her activity.
                @elseif($qNum == 7) Discuss the team member's concerns, offer support and express confidence in his ability.
                @elseif($qNum == 8) Ask for her input as the leader makes necessary decisions.
                @elseif($qNum == 9) Ask the team member for his recommendations, but see that task force goals are met.
                @elseif($qNum == 10) Be clear that the new standards are set and supervise closely.
                @elseif($qNum == 11) Involve her in the decision-making process, assure her of support and give her feedback, when appropriate.
                @elseif($qNum == 12) Stay observant of the team member's behavior, but allow him to work out the disagreement with the group.
                @endif
            </div>
        </div>
    </label>

    {{-- Option C --}}
    <input type="radio" name="answer" id="optC" value="C" class="option-radio" {{ $currentAnswer == 'C' ? 'checked' : '' }}>
    <label for="optC" class="option-card">
        <span class="option-letter">C</span>
        <div class="option-text">
            <div class="option-chinese">{{ $question->Option3 }}</div>
            <div class="option-english">
                @if($qNum == 1) Discuss the issue with her and then set goals.
                @elseif($qNum == 2) Provide encouragement on how quickly he is learning, and ask his opinions on the type of new assignments he would like.
                @elseif($qNum == 3) Break the new tasks down into detailed step-by-step instructions and communicate them to him.
                @elseif($qNum == 4) Listen carefully, ask clarifying questions and let her run with it.
                @elseif($qNum == 5) Clearly define her role, responsibilities and objectives and supervise closely.
                @elseif($qNum == 6) Provide her with the freedom to take risks to become more efficient.
                @elseif($qNum == 7) Listen to his concerns and explain to him why the changed procedure would work while maintaining control of the implementation.
                @elseif($qNum == 8) Take steps to direct her toward working in a well-defined manner.
                @elseif($qNum == 9) Establish and communicate clear goals and expectations for this team member.
                @elseif($qNum == 10) Monitor the team member's performance to see if further action is necessary.
                @elseif($qNum == 11) Discuss how she can build on her past performance and then provide her with specific directions for carrying out the task.
                @elseif($qNum == 12) Act quickly and firmly to get the team to reach agreement.
                @endif
            </div>
        </div>
    </label>

    {{-- Option D --}}
    <input type="radio" name="answer" id="optD" value="D" class="option-radio" {{ $currentAnswer == 'D' ? 'checked' : '' }}>
    <label for="optD" class="option-card">
        <span class="option-letter">D</span>
        <div class="option-text">
            <div class="option-chinese">{{ $question->Option4 }}</div>
            <div class="option-english">
                @if($qNum == 1) Monitor performance and let her know support is available if she needs it.
                @elseif($qNum == 2) Emphasize the importance of the existing tasks he needs to complete.
                @elseif($qNum == 3) Discuss his concerns and provide support and encouragement.
                @elseif($qNum == 4) Listen to her suggestion, explain how it will impact her role and tell her how to implement the change.
                @elseif($qNum == 5) Approach her with friendly conversation and obvious concern.
                @elseif($qNum == 6) Explain why efficiency is important while continuing to provide guidance and support.
                @elseif($qNum == 7) Give the team member the authority and resources to implement the procedure.
                @elseif($qNum == 8) Compliment her work and involve her in making decisions about the project.
                @elseif($qNum == 9) Encourage the team member's input and compliment any positive contributions he makes.
                @elseif($qNum == 10) Talk with the team member and explain the need for the new standards.
                @elseif($qNum == 11) Continue to allow her to function independently.
                @elseif($qNum == 12) Consult with the team member about the disagreement and let him know you support him.
                @endif
            </div>
        </div>
    </label>

    <div class="mt-4">
        <div class="d-flex" style="gap: 0.75rem;">
            @if($Qid > 13)
                <a href="{{ route('student.OthersQuestion', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => $Qid - 1]) }}"
                   class="btn btn-outline-secondary quiz-nav-link" style="padding: 0.7rem 1rem; white-space: nowrap;">
                    &larr; 上一題
                </a>
            @endif
            <button type="submit" class="btn btn-accent flex-fill" style="padding: 0.7rem; font-size: 1rem;">
                {{ $Qid == 24 ? '完成問卷' : '下一題 →' }}
            </button>
            @if($currentAnswer !== null && $Qid < 24)
                <a href="{{ route('student.OthersQuestion', ['Sid' => $Sid, 'Oid' => $Oid, 'Qid' => $Qid + 1]) }}"
                   class="btn btn-outline-primary quiz-nav-link" style="padding: 0.7rem 1rem; white-space: nowrap;">
                    下一題 &rarr;
                </a>
            @endif
        </div>
        <p id="noAnswerMsg" class="text-danger text-center mt-2 mb-0"
           style="display:none; font-size: 0.875rem;">請選擇一個選項後再繼續</p>
    </div>
</form>

@include('sweetalert::alert')

@endsection

@section('scripts')
<script>
    var isSubmitting = false;

    document.getElementById('otherQuestionForm').addEventListener('submit', function (e) {
        if (!document.querySelector('input[name="answer"]:checked')) {
            e.preventDefault();
            document.getElementById('noAnswerMsg').style.display = 'block';
        } else {
            isSubmitting = true;
        }
    });

    document.querySelectorAll('input[name="answer"]').forEach(function (r) {
        r.addEventListener('change', function () {
            document.getElementById('noAnswerMsg').style.display = 'none';
        });
    });

    document.querySelectorAll('.quiz-nav-link').forEach(function (link) {
        link.addEventListener('click', function () {
            isSubmitting = true;
        });
    });

    window.addEventListener('beforeunload', function (e) {
        if (!isSubmitting) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
@endsection
