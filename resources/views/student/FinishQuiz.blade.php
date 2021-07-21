<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>
<div align="center">
<h1>感謝您的填寫 !</h1>
<h2>1.情境領導 LEAD領導力問卷分析報告會於上課當天分發。</h2>
    <br>
    <h2 style="color:green">2.請您發送以下 邀請函及連結 邀請他人給您回饋，其中可以包含上級<br>
        主管、部屬、同事或其他，建議至少四位以上，越多越好。</h2>
    <br>
<h2 style="color:green">3.邀請函內容及連結 :</h2>
    <h2 style="color: blue">親愛的夥伴 :<br><br>

        我即將參加「情境領導 Situational Leadership®」培訓課程，這個課程能夠幫助我更<br>
        了解自己如何在適當的情境下，使用合適的領導風格來領導他人創造績效與激發投<br>
        入度。我希望能邀請您來幫我進行領導行為的回饋，以幫助我更了解自己領導風格<br>
        的使用狀況，以及作為接下來領導力精進的參考依據。這份問卷共有 12道題，大<br>
        約會花您 8分鐘時間完成問卷，也非常感謝您的投入來幫助我變得更好 !<br>
    </h2>
<h2><a href="https://jctraining.herokuapp.com/{{$Sid}}/others">https://jctraining.herokuapp.com/{{$Sid}}/others</a></h2>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
</div>
@include('sweetalert::alert')
</body>
</html>
