<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>

<h1>這位領導者會如何回應 ?(How would this leader respond?)</h1>
<h2 style="color:green">{{$question->id-12}}. 情境情境(SITUATION)</h2>
    <h3 style="color: #38c172">{{$question->Question}}</h3>
@if($question->id-12 == 1)
    <h3>A team member is not responding lately to this leader’s friendly conversation and obvious concern for her<br> welfare. She seems frustrated and is not finishing tasks on time. </h3>
@elseif($question->id-12 == 2)
    <h3>A new team member is beginning to learn, at a steady pace, the task this leader has assigned and his<br> performance is improving. He is prematurely asking for more challenging tasks. </h3>
@elseif($question->id-12 == 3)
    <h3>A team member is concerned about a recently assigned routine project. On projects like this, this leader has<br> normally left him alone. The team member's past performance and interpersonal relations have been good. </h3>
@elseif($question->id-12 == 4)
    <h3>A team member has proposed a change that she wants to implement. She is enthusiastic and has a fine<br> record of accomplishment in this area. This leader views her suggestion as extremely valuable. </h3>
@elseif($question->id-12 == 5)
    <h3>A team member's performance has been dropping during the last few months. She has been unconcerned<br> with meeting objectives. She continually needs coaching to ensure her tasks are done on time. </h3>
@elseif($question->id-12 == 6)
    <h3>Based on feedback from a previous supervisor, this leader has been closely supervising and directing a<br> team member on a critical task. She is responding favorably and this leader would now like to help her<br> become more efficient. </h3>
@elseif($question->id-12 == 7)
    <h3>This leader is considering changing a work procedure. This leader assigns the task to a team member who<br> knows the procedure well. He expresses concern about his workload and the things that could go wrong. </h3>
@elseif($question->id-12 == 8)
    <h3>A team member's performance and peer relationships are strong. This leader feels somewhat concerned<br> about letting her independently take on an important project.</h3>
@elseif($question->id-12 == 9)
    <h3>This leader has been appointed to head a task force. One team member in particular presents a number of<br>
        challenges. He appears to be unclear on the goals of the task force and his attendance at scheduled<br>
        meetings has been sporadic. From what this leader has observed, he treats the meetings he does attend as<br> social gatherings. His behavior is affecting the other team members.</h3>
@elseif($question->id-12 == 10)
    <h3>A team member who is usually able to take responsibility is having difficulty understanding some recent<br> redefining of standards. </h3>
@elseif($question->id-12 == 11)
    <h3>This leader has assigned task to a team member who has completed it before at an acceptable level. This<br>
        leader has allowed her to work fairly independently in the past, but she now wants the leader’s input and<br> involvement. </h3>
@elseif($question->id-12 == 12)
    <h3>In a recent meeting, a team member passionately stated his point of view. In this meeting, his peers<br>
        expressed disagreement with this team member's viewpoint. This particular team member has a remarkable<br>
        record of accomplishment. The team, as a whole, has worked in harmony for the past year and all are well<br> qualified for the task. </h3>
@endif
    <form action="{{ route('student.StoreOtherAnswer',['Sid' => $Sid,'Oid'=>$Oid,'Qid'=>$Qid]) }}" enctype="multipart/form-data" method="post">
        @csrf
<div>
    <h3 style="color: blue">行動選項 – 這位領導者可能會 ...<div style="color: black"> ALTERNATIVE ACTIONS – You would...</div></h3>
    <div style="font-size: 20px">
    <div class="row">
    <input type="radio" name="answer" id="A" value="A" />
    <label for="A" style="color:royalblue">(A){{$question->Option1}}  @if($question->id-12 == 1)<br><div style="padding-left: 30px;color: black">Help her learn the task step by step and let her know the consequences of missed deadlines.</div>
        @elseif($question->id-12 == 2)
            <br><div style="padding-left: 30px;color: black">Praise his improvement, explain next steps in mastering his current tasks and explain how they connect to the bigger<br> picture.</div>
        @elseif($question->id-12 == 3)
            <br><div style="padding-left: 30px;color: black">Give specific directions on the new project while providing him the opportunity to ask clarifying questions.</div>
        @elseif($question->id-12 == 4)
            <br><div style="padding-left: 30px;color: black">Involve her in developing the change plans while providing ongoing encouragement.</div>
        @elseif($question->id-12 == 5)
            <br><div style="padding-left: 30px;color: black">Observe and monitor her performance over time, as needed.</div>
        @elseif($question->id-12 == 6)
            <br><div style="padding-left: 30px;color: black">Discuss ideas on improving productivity and encourage her to be more efficient.</div>
        @elseif($question->id-12 == 7)
            <br><div style="padding-left: 30px;color: black">Define the changed procedure and supervise carefully.</div>
        @elseif($question->id-12 == 8)
            <br><div style="padding-left: 30px;color: black">Ask for periodic project updates and continue to monitor her performance.</div>
        @elseif($question->id-12 == 9)
            <br><div style="padding-left: 30px;color: black">Observe the task force action and allow them to work this out on their own.</div>
        @elseif($question->id-12 == 10)
            <br><div style="padding-left: 30px;color: black">Listen to concerns and reassure the team member about the new standards.</div>
        @elseif($question->id-12 == 11)
            <br><div style="padding-left: 30px;color: black">Provide her with step-by-step directions on how to carry out the task. </div>
        @elseif($question->id-12 == 12)
            <br><div style="padding-left: 30px;color: black">Convince the team member of the need to reach agreement.</div>
        @endif</label>
</div>

<div>
    <input type="radio" name="answer" id="B" value="B" />
    <label for="B" style="color:royalblue">(B) {{$question->Option2}} @if($question->id-12 == 1)<br><div style="padding-left: 30px;color: black">Ask her how she plans to get back on track, and encourage her to do so.</div>
        @elseif($question->id-12 == 2)
            <br><div style="padding-left: 30px;color: black">Observe performance and provide feedback, when appropriate.</div>
        @elseif($question->id-12 == 3)
            <br><div style="padding-left: 30px;color: black">Give him the necessary resources and authority, then monitor as needed.</div>
        @elseif($question->id-12 == 4)
            <br><div style="padding-left: 30px;color: black">Provide guidance on how implement the change.</div>
        @elseif($question->id-12 == 5)
            <br><div style="padding-left: 30px;color: black">Explain what needs to be done and why it is important. Answer questions, as needed. </div>
        @elseif($question->id-12 == 6)
            <br><div style="padding-left: 30px;color: black">Continue to closely supervise and direct her activity.</div>
        @elseif($question->id-12 == 7)
            <br><div style="padding-left: 30px;color: black">Discuss the team member's concerns, offer support and express confidence in his ability.</div>
        @elseif($question->id-12 == 8)
            <br><div style="padding-left: 30px;color: black">Ask for her input as the leader makes necessary decisions. </div>
        @elseif($question->id-12 == 9)
            <br><div style="padding-left: 30px;color: black">Ask the team member for his recommendations, but see that task force goals are met.</div>
        @elseif($question->id-12 == 10)
            <br><div style="padding-left: 30px;color: black">Be clear that the new standards are set and supervise closely.</div>
        @elseif($question->id-12 == 11)
            <br><div style="padding-left: 30px;color: black">Involve her in the decision-making process, assure her of support and give her feedback, when appropriate. </div>
        @elseif($question->id-12 == 12)
            <br><div style="padding-left: 30px;color: black">Stay observant of the team member's behavior, but allow him to work out the disagreement with the group.</div>
        @endif</label>
</div>

<div>
    <input type="radio" name="answer" id="C" value="C" />
    <label for="C" style="color:royalblue">(C) {{$question->Option3}} @if($question->id-12 == 1)<br><div style="padding-left: 30px;color: black">Discuss the issue with her and then set goals.</div>
        @elseif($question->id-12 == 2)
            <br><div style="padding-left: 30px;color: black">Provide encouragement on how quickly he is learning, and ask his opinions on the type of new assignments he would<br> like. </div>
        @elseif($question->id-12 == 3)
            <br><div style="padding-left: 30px;color: black">Break the new tasks down into detailed step-by-step instructions and communicate them to him.</div>
        @elseif($question->id-12 == 4)
            <br><div style="padding-left: 30px;color: black">Listen carefully, ask clarifying questions and let her run with it.</div>
        @elseif($question->id-12 == 5)
            <br><div style="padding-left: 30px;color: black">Clearly define her role, responsibilities and objectives and supervise closely.</div>
        @elseif($question->id-12 == 6)
            <br><div style="padding-left: 30px;color: black">Provide her with the freedom to take risks to become more efficient.</div>
        @elseif($question->id-12 == 7)
            <br><div style="padding-left: 30px;color: black">Listen to his concerns and explain to him why the changed procedure would work while maintaining control of the<br> implementation.</div>
        @elseif($question->id-12 == 8)
            <br><div style="padding-left: 30px;color: black">Take steps to direct her toward working in a well-defined manner.</div>
        @elseif($question->id-12 == 9)
            <br><div style="padding-left: 30px;color: black">Establish and communicate clear goals and expectations for this team member.</div>
        @elseif($question->id-12 == 10)
            <br><div style="padding-left: 30px;color: black">Monitor the team member's performance to see if further action is necessary.</div>
        @elseif($question->id-12 == 11)
            <br><div style="padding-left: 30px;color: black">Discuss how she can build on her past performance and then provide her with specific directions for carrying out the <br>task. </div>
        @elseif($question->id-12 == 12)
            <br><div style="padding-left: 30px;color: black">Act quickly and firmly to get the team to reach agreement.</div>
        @endif</label>
</div>

<div>
    <input type="radio" name="answer" id="D" value="D" />
    <label for="D" style="color:royalblue">(D) {{$question->Option4}} @if($question->id-12 == 1)<br><div style="padding-left: 30px;color: black">Monitor performance and let her know support is available if she needs it.</div>
        @elseif($question->id-12 == 2)
            <br><div style="padding-left: 30px;color: black">Emphasize the importance of the existing tasks he needs to complete. </div>
        @elseif($question->id-12 == 3)
            <br><div style="padding-left: 30px;color: black">Discuss his concerns and provide support and encouragement.</div>
        @elseif($question->id-12 == 4)
            <br><div style="padding-left: 30px;color: black">Listen to her suggestion, explain how it will impact her role and tell her how to implement the change.</div>
        @elseif($question->id-12 == 5)
            <br><div style="padding-left: 30px;color: black">Approach her with friendly conversation and obvious concern. </div>
        @elseif($question->id-12 == 6)
            <br><div style="padding-left: 30px;color: black">Explain why efficiency is important while continuing to provide guidance and support. </div>
        @elseif($question->id-12 == 7)
            <br><div style="padding-left: 30px;color: black">Give the team member the authority and resources to implement the procedure.</div>
        @elseif($question->id-12 == 8)
            <br><div style="padding-left: 30px;color: black">Compliment her work and involve her in making decisions about the project. </div>
        @elseif($question->id-12 == 9)
            <br><div style="padding-left: 30px;color: black">Encourage the team member's input and compliment any positive contributions he makes.</div>
        @elseif($question->id-12 == 10)
            <br><div style="padding-left: 30px;color: black">Talk with the team member and explain the need for the new standards.</div>
        @elseif($question->id-12 == 11)
            <br><div style="padding-left: 30px;color: black">Continue to allow her to function independently.</div>
        @elseif($question->id-12 == 12)
            <br><div style="padding-left: 30px;color: black">Consult with the team member about the disagreement and let him know you support him.</div>
        @endif</label>
</div>
    </div>
            <button class="btn">下一頁</button>
        </div>
</form>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
@include('sweetalert::alert')
</body>
</html>
