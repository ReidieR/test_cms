@if ($errors->any())
    <div class="layui-form-item">
    <dl class="layui-input-block" style="border:1px solid red;background:pink;border-radius:5px;{{count($errors->all())==1?'line-height:38px':''}}">
            @foreach ($errors->all() as $error)
                <dd style="margin-left:10px;">{{ $error }}</dd> 
            @endforeach
        </dl>
    </div>
@endif

     
    