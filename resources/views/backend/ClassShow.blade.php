<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>課程名稱：{{$class->ClassName}}</h1>
    <p>課程問卷連結：<a href=" {{ route('student.StudentQuiz', ['ClassLink' => $class->ClassLink]) }}">http://growquestionnaire.herokuapp.com/{{$class->ClassLink}}/Quiz</a></p>>
    <div class="Row">
        <div class="Column">C1</div>
        <div class="Column">C2</div>
        <div class="Column">C3</div>
    </div>
        <div style="color: blue;float:left">學員自評問卷統計</div>
        <div style="color: #38c172">已完成份數</div>
        <div style="color: red">未完成份數</div>
    <table border="1" width="500" align="center">
        <tr>
            <td align="center"><span style="font-size:18px;">學員姓名</span></td>
            <td align="center"><span style="font-size:18px;">他評問卷數</span></td>
            <td align="center"><span style="font-size:18px;">產生問卷分析表</span></td>
        </tr>
        @foreach($students as $student)
            <tr>
                <td align="center"><span style="font-size:18px;"><a href=" {{ route('student.StudentShow', ['Sid' => $student->id]) }}">{{$student->name}}</a></span></td>
                <td align="center"><span style="font-size:18px;">{{$student->OthersCount}}</span></td>
                <td align="center"><span style="font-size:18px;"><a href=" {{ route('student.page2_pdf',['Sid' => $student->id]) }}">▼</a></span></td>
            </tr>
        @endforeach
    </table>
</div>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
@include('sweetalert::alert')
</body>
</html>
