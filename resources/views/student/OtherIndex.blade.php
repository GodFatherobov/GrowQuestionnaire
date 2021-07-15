<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>{{$student->name}}的Others回應</h1>
<table border="1" width="250" align="center">
    <tr>
        <td align="center"><span style="font-size:18px;">職稱</span></td>
    </tr>
@foreach($others as $other)
    <tr>
        <td align="center"><span style="font-size:18px;"><a href=" {{ route('student.OtherShow', ['Oid' => $other->id]) }}">{{$other->type}}</a></span></td>
    </tr>
@endforeach
</table>
</div>
</body>
</html>
