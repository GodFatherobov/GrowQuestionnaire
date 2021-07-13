<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<h1>{{$student->name}}的作答情況</h1>
<table border="1" width="500" align="center">

@foreach($answers as $answer)
        <tr>
            <td align="center"><span style="font-size:18px;">第{{$answers->questionID}}題</span></td>
        </tr>
    <tr>
        <td align="center"><span style="font-size:18px;">{{$answer->answer}}</span></td>
    </tr>
@endforeach
</table>
</body>
</html>
