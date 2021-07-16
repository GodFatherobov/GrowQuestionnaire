<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>{{$student->name}}的作答情況</h1>
<table border="1" width="250" align="center">

@foreach($answers as $answer)
    <tr>
        <td align="center"><span style="font-size:18px;">第{{$answer->questionID}}題</span></td>
        <td align="center"><span style="font-size:18px;">{{$answer->answer}}</span></td>
    </tr>
@endforeach
</table>
    <div>
    <Form method="get" action="{{ route('student.OtherIndex',['Sid' => $student->id])}}">
        <button type="submit" class="label label-default pull-xs-right">others填寫狀況</button>
    </Form>
    <Form method="get" action="{{ route('student.Chart',['Sid' => $student->id]) }}">
        <button type="submit" class="label label-default pull-xs-right">產生分析表</button>
    </Form>
    </div>
</div>
</body>
</html>
