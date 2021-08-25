<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>

<h1>Self問卷填寫說明</h1>

<form action="" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
        <label for="Name" class="col-md-4 col-form-label">您的姓名(Your Name)：</label>
        <input id="Name"
               type="text"
               class="form-control @error('Name') is-invalid @enderror"
               name="Name"
               value="{{ old('Name') }}"
               required autocomplete="Name" autofocus>

        @error('Name')
        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
        @enderror
    </div>
    <h1 style="color:green">目的(Purpose)</h1>
    <p>此評量工具用於評估你嘗試影響他人的行為和態度時，所使用的領導行為。<br>
        透過「LEAD Self 自我評估」所收集的資訊，可以深入了解你目前的優勢，以及領導力技巧發展的領域。它提供<br>
        有關你使用哪些影響行為以及這些行為與他人需求匹配程度的資訊。</p>
    <p>This assessment is used to evaluate the leadership behaviors you use when you are engaged in attempts to influence the actions and attitudes of others.<br>
        The information gathered with the LEAD Self provides insight into your current strengths and areas for your leadership skill development.<br>
        It provides information about which influence behaviors you use and the extent to which you match those behaviors to the needs of others. </p>
    <h1 style="color:green">說明 - 使用此評量工具(Instructions - Using the Assessment)</h1>
    <p>．假設你參與以下 12 種情境；每種情境都有四種你可能會採取的行動選項<br>
        ．請仔細閱讀每一種情境<br>
        ．思考你在每種情境中可能會採取的行動<br>
        ．選擇你認為最接近你在面臨該情境中會採取的行動選項<br>
        ．請為 12 種情境中的每種情境做出選擇；請勿跳過任何情境<br>
        ．快速瀏覽選項，堅持你對選項做出的第一選擇；你的第一選擇通常是最準確的</p>
    <p>．Assume you are involved in each of the following 12 situations. Each situation has four alternative actions you might initiate<br>
        ．Read each situation carefully:<br>
        ．Think about what you would do in each situation<br>
        ．Select the alternative action you think most closely describes what behavior you would use in the situation presented<br>
        ．Select an action for each of the 12 situations. Do not skip any<br>
        ．Move through the items quickly and stick with the first choice you make on each item. Your first choice tends to be the most accurate one. </p>
    <p style="color:red">重要事項：檢查你的選擇是否為你可能做出的反應， 而非你應該做出的反應；這樣做的目的在於評估你實際會<br>
        使用的行為， 而非獲得正確答案。如果沒有你可能會採取的行為選項，請選擇你認為最貼近你可能會做的選項。</p>
    <p style="color:red">Important: Check what you think you would do and not what you should do. The goal is to evaluate. what behaviors you actually use- not to get right answers.<br>
        If there is no alternative action that describes what you would do in the situation, select the response that most closely resembles what you would do. </p>
        <div class="row">
            <button class="btn" style="width: 150px;height: 50px;font-size: 16px">下一頁(next page)</button>
        </div>
</form>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
</body>
@include('sweetalert::alert')
</html>
