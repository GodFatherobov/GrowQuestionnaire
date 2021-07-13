<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>課程名稱：{{$class->ClassName}}</h1>
    <p>課程連結：<a href=" {{ route('student.StudentQuiz', ['ClassLink' => $class->ClassLink]) }}">http://growquestionnaire.herokuapp.com/{{$class->ClassLink}}/Quiz</a></p>
    <p>學員清單</p>
    <table border="1" width="200" align="center">
        <tr>
            <td align="center"><span style="font-size:18px;">學員姓名</span></td>
        </tr>
        @foreach($students as $student)
            <tr>
                <td align="center"><span style="font-size:18px;">{{$student->name}}</span></td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
