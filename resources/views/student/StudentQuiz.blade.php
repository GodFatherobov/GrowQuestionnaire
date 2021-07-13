<!DOCTYPE html>
<html>
<head>
    <title>Lead Self問卷填寫</title>
</head>
<body>

<h1>Self問卷填寫說明</h1>

<form action="'/{{$ClassLink}}/Quiz'" enctype="multipart/form-data" method="post">
    @csrf
    <div class="row">
                <label for="name" class="col-md-4 col-form-label">您的姓名</label>

                <input id="name"
                       type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name"
                       value="{{ old('name') }}"
                       required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
            </div>
    <h1>目的</h1>
    <p>此評量工具用於評估你嘗試影響他人的行為和態度時，所使用的領導行為。<br>
        透過「LEAD Self 自我評估」所收集的資訊，可以深入了解你目前的優勢，以及領導力技巧發展的領域。它提供<br>
        有關你使用哪些影響行為以及這些行為與他人需求匹配程度的資訊。</p>
    <h1>說明 - 使用此評量工具</h1>
    <p>．假設你參與以下 12 種情境；每種情境都有四種你可能會採取的行動選項<br>
        ．請仔細閱讀每一種情境<br>
        ．思考你在每種情境中可能會採取的行動<br>
        ．選擇你認為最接近你在面臨該情境中會採取的行動選項<br>
        ．請為 12 種情境中的每種情境做出選擇；請勿跳過任何情境<br>
        ．快速瀏覽選項，堅持你對選項做出的第一選擇；你的第一選擇通常是最準確的</p>
    <p>重要事項：檢查你的選擇是否為你可能做出的反應， 而非你應該做出的反應；這樣做的目的在於評估你實際會<br>
        使用的行為， 而非獲得正確答案。如果沒有你可能會採取的行為選項，請選擇你認為最貼近你可能會做的選項。</p>
        <div class="row">
            <button class="btn">下一頁</button>
        </div>
</form>

</body>
</html>
