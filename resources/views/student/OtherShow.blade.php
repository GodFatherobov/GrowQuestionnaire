<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>作答情況</h1>
<table border="1" width="250" align="center">

@foreach($answers as $answer)
    <tr>
        <td align="center"><span style="font-size:18px;">第{{($answer->questionID)-12}}題</span></td>
        <td align="center"><span style="font-size:18px;">{{$answer->answer}}</span></td>
    </tr>
@endforeach
</table>
</div>
</body>
</html>