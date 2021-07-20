<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>
<h1>感謝您的填寫 !</h1>
<h2>1. LEAD領導力問卷分析報告會於課堂上分發。</h2>
<h2 style="color:green">2.請您發送以下連結邀請他人給您回饋，其中可以包含上級主管、部屬、同事或其他，至少四位。</h2>
<h2><a href="http://growquestionnaire.herokuapp.com/{{$Sid}}/others">http://growquestionnaire.herokuapp.com/{{$Sid}}/others</a></h2>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
@include('sweetalert::alert')
</body>
</html>
