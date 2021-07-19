<!DOCTYPE html>
<html>
<head>
    <title>Other問卷填寫</title>
</head>
<body>

<h1>Other問卷填寫說明</h1>
<form action="" enctype="multipart/form-data" method="post">
    @csrf
        <p>您是這位領導人的(選擇一個)：</p>
    <select name="type" id="type">
        <option value="上級主管">上級主管</option>
        <option value="部屬">部屬</option>
        <option value="同事">同事</option>
        <option value="其他">其他</option>
    </select>
        <div>
    <h2>領導者名字：{{$student->name}}</h2>
    <h1 style="color:green">目的</h1>
    <p>本評量工具用於概括上述人員的影響行為。<br>
        透過「LEAD Other 他人評估」所收集的資訊，可以深入了解該領導者目前的優勢，以及領導力技巧發展的領域。<br>
        它提供有關該領導者使用哪些影響行為以及這些行為與他人需求匹配程度的資訊。</p>
    <h1 style="color:green">說明 - 使用此評量工具</h1>
    <p>．假設 {{$student->name}}( 該領導者 ) 參與以下 12 種情境；每種情境都有四種此人可能會採取的行動選項<br>
        ．請仔細閱讀每一種情境<br>
        ．思考你認為該領導者在每種情境中可能會採取的行動<br>
        ．選擇你認為最接近此人在面臨該情境中會採取的行動選項<br>
        ．請為 12 種情境中的每種情境做出選擇；請勿跳過任何情境<br>
        ．快速瀏覽選項，堅持你對選項做出的第一選擇；你的第一選擇通常是最準確的</p>
    <p style="color:red">：檢查你的選擇是否為該領導者可能做出的反應， 而非他應該做出的反應。這樣做的目的在於評估他<br>
        實際做出的行為， 而非獲得正確答案。 如果沒有此人可能會採取的行為選項，請選擇你認為最貼近此人反應的<br>
        選項。</p>
        <div class="row">
            <button class="btn">下一頁</button>
        </div>
        </div>
</form>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
</body>
</html>
