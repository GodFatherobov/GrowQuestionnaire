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
                <button class="btn">新增</button>
            </div>
        </form>

<table border="1" width="200" align="center">
    @foreach($classes as $class)
        <tr>
            <td align="center"><span style="font-size:20px;"><a href=" {{ route('backend.ClassShow', ['id' => $class->id]) }}">{{$class->ClassName}}</a></span></td>
        </tr>
    @endforeach
</table>
</div>
</body>
</html>
