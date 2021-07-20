<!DOCTYPE html>
<html>
<head>
    <title>問卷後台</title>
</head>
<body>
<div align="center">
<h1>課程列表</h1>

        <form action="/ClassCreate" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <label for="ClassName" class="col-md-4 col-form-label">新增課程：</label>
                <input id="ClassName"
                       type="text"
                       class="form-control @error('ClassName') is-invalid @enderror"
                       name="ClassName"
                       value="{{ old('ClassName') }}"
                       required autocomplete="ClassName" autofocus>

                @error('ClassName')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <label for="people" class="col-md-4 col-form-label">課程人數：</label>
                <input id="people"
                       type="text"
                       class="form-control @error('people') is-invalid @enderror"
                       name="people"
                       value="{{ old('people') }}"
                       required autocomplete="people" autofocus>

                @error('people')
                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                @enderror
                <button class="btn">新增</button>
            </div>
        </form>

<table border="1" width="700" align="center">
    <tr>
        <td align="center"><span style="font-size:18px;">課程名稱</span></td>
        <td align="center"><span style="font-size:18px;">課程人數</span></td>
        <td align="center"><span style="font-size:18px;">問卷網址</span></td>
    </tr>
    @foreach($classes as $class)
        <tr>
            <td align="center"><span style="font-size:18px;"><a href=" {{ route('backend.ClassShow', ['id' => $class->id]) }}">{{$class->ClassName}}</a></span></td>
            <td align="center"><span style="font-size:18px;">{{$class->People}}</span></td>
            <td align="center"><span style="font-size:18px;"><a href=" {{ route('student.StudentQuiz', ['ClassLink' => $class->ClassLink]) }}" target="_blank">http://growquestionnaire.herokuapp.com/{{$class->ClassLink}}/Quiz</a></span></td>
        </tr>
    @endforeach
</table>
</div>
<div style="position: absolute;bottom: 10px; right: 10px;">
    <img src="{{ route('logo')}}" alt="加載錯誤">
</div>
@include('sweetalert::alert')
</body>
</html>
