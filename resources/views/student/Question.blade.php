<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>

<h1>你會如何回應 ?</h1>
<h3>{{$question->id}}. 情境</h3>
    <h3>{{$question->Question}}</h3>
    <form action="{{ route('student.StoreAnswer',['Sid' => $Sid,'Qid'=>$Qid]) }}" enctype="multipart/form-data" method="post">
        @csrf
<div>
    <h3>行動選項 – 你可能會 ...</h3>
    <div class="row">
    <input type="radio" name="answer" id="A" value="A" />
    <label for="A">(A){{$question->Option1}}  </label>
</div>

<div>
    <input type="radio" name="answer" id="B" value="B" />
    <label for="B">(B) {{$question->Option2}} </label>
</div>

<div>
    <input type="radio" name="answer" id="C" value="C" />
    <label for="C">(C) {{$question->Option3}} </label>
</div>

<div>
    <input type="radio" name="answer" id="D" value="D" />
    <label for="D">D) {{$question->Option4}} </label>
</div>

            <button class="btn">下一頁</button>
        </div>
</form>
</body>
</html>
