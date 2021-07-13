<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>課程名稱：{{$class->ClassName}}</h1>
    <h1>課程連結：</h1>
    <h1>學員清單</h1>
    <table border="1" width="200" align="center">
        @foreach($students as $student)
            <tr>
                <td align="center"><span style="font-size:20px;">{{$student->name}}</span></td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
