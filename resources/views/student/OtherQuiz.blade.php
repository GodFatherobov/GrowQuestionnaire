<!DOCTYPE html>
<html>
<head>
    <title>Other問卷填寫</title>
</head>
<body>

<h1>Other問卷填寫說明<br><div style="font-size: 20px">Leadership Style/ Perception of Other</div></h1>
<form action="" enctype="multipart/form-data" method="post">
    @csrf
        <p>您是這位領導人的(選擇一個)：<br>You are this leader's… (select one) </p>
    <select name="type" id="type">
        <option value="上級主管">上級主管 Supervisor</option>
        <option value="部屬">部屬 Subordinates</option>
        <option value="同事">同事 Peers</option>
        <option value="其他">其他 Others</option>
    </select>
        <div>
    <h2>領導者名字(This Leader's Name)：{{$student->name}}</h2>
            <h1 style="color:green">目的(Purpose)</h1>
    <p>本評量工具用於概括上述人員的影響行為。<br>
        透過「LEAD Other 他人評估」所收集的資訊，可以深入了解該領導者目前的優勢，以及領導力技巧發展的領域。<br>
        它提供有關該領導者使用哪些影響行為以及這些行為與他人需求匹配程度的資訊。</p>
            <p>This assessment is used to profile the influence behaviors of the person named above.<br>
                The information gathered with the LEAD Other provides insight into this leader's current strengths and<br>
                areas for leadership skill development. It provides information about which influence behaviors they use<br>
                and the extent to which they match those behaviors to the needs of others. </p>
    <h1 style="color:green">說明 - 使用此評量工具(Instructions-Using the Assessment)</h1>
    <p>．假設 {{$student->name}}( 該領導者 ) 參與以下 12 種情境；每種情境都有四種此人可能會採取的行動選項<br>
        ．請仔細閱讀每一種情境<br>
        ．思考你認為該領導者在每種情境中可能會採取的行動<br>
        ．選擇你認為最接近此人在面臨該情境中會採取的行動選項<br>
        ．請為 12 種情境中的每種情境做出選擇；請勿跳過任何情境<br>
        ．快速瀏覽選項，堅持你對選項做出的第一選擇；你的第一選擇通常是最準確的</p>
            <p>
                • Assume {{$student->name}} is involved in each of the following 12 situations. Each situation has four alternative actions that person might initiate<br>
                • Read each situation carefully<br>
                • Think about what you believe this person would do in each situation<br>
                • Select the alternative action you think most closely describes the behavior this person would use in the situation presented<br>
                • Select an action for each of the 12 situations. Do not skip any<br>
                • Move through the items quickly and stick with the first choice you make on each item. Your first choice tends to be the most accurate one<br>
            </p>
            <p style="color:red"><span style="font-weight: bold;font-size: 20px">重要事項：</span>檢查你的選擇是否為該領導者<span style="font-weight: bold;font-size: 20px">可能做出</span>的反應， 而非他<span style="font-weight: bold;font-size: 20px">應該做出</span>的反應。這樣做的目的在於評估他<br>
        實際做出的行為， 而非獲得正確答案。 如果沒有此人可能會採取的行為選項，請選擇你認為最貼近此人反應的<br>
        選項。</p>
            <p style="color:red"><span style="font-weight: bold;font-size: 20px">Important:</span> Check what you think this person <span style="font-weight: bold;font-size: 20px">would</span> do and not what they <span style="font-weight: bold;font-size: 20px">should</span> do. The goal is to evaluate. what behaviors they actually use- not to get<br>
                right answers. If there is no alternative action that describes what this person would do in the situation, select the response that most closely resembles<br>
                what you think they would do. </p>
        <div class="row">
            <button class="btn" style="width: 150px;height: 50px;font-size: 16px">下一頁(next page)</button>
        </div>
        </div>
</form>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
@include('sweetalert::alert')
</body>
</html>
