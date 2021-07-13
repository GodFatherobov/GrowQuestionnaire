<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>
<li>
<h1>你會如何回應 ?</h1>
    <h3>{{$question->Question}}</h3>
<div>
    <input type="radio" name="question-1-answers" id="question-1-answers-A" value="A" />
    <label for="question-1-answers-A">A){{$question->Option1}}  </label>
</div>

<div>
    <input type="radio" name="question-1-answers" id="question-1-answers-B" value="B" />
    <label for="question-1-answers-B">B) {{$question->Option2}} </label>
</div>

<div>
    <input type="radio" name="question-1-answers" id="question-1-answers-C" value="C" />
    <label for="question-1-answers-C">C) {{$question->Option3}} </label>
</div>

<div>
    <input type="radio" name="question-1-answers" id="question-1-answers-D" value="D" />
    <label for="question-1-answers-D">D) {{$question->Option4}} </label>
</div>
<li>
</body>
</html>
