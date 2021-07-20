<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>{{$student->name}}的作答情況</h1>
    <p>邀請問卷網址</p>
    <p>
        <a href="http://growquestionnaire.herokuapp.com/{{$student->id}}/others">http://growquestionnaire.herokuapp.com/{{$student->id}}/others</a>
    </p>
<table border="1" width="250" align="center">

@foreach($answers as $answer)
    <tr>
        <td align="center"><span style="font-size:18px;">第{{$answer->questionID}}題</span></td>
        <td align="center"><span style="font-size:18px;">{{$answer->answer}}</span></td>
    </tr>
@endforeach
    <Form method="get" action="{{ route('student.OtherIndex',['Sid' => $student->id])}}">
        <button type="submit" class="label label-default pull-xs-right">others填寫狀況</button>
    </Form>
<div style="position: absolute;bottom: 10px; right: 10px;">
<img src="{{ route('logo')}}" alt="加載錯誤">
    </div>
@include('sweetalert::alert')
</body>
</html>
