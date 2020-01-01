{{-- @if ($errors->any())
    <div class="layui-form-item">
    <dl class="layui-input-block" style="border:1px solid red;background:pink;border-radius:5px;{{count($errors->all())==1?'line-height:38px':''}}">
            @foreach ($errors->all() as $error)
                <dd style="margin-left:10px;">{{ $error }}</dd> 
            @endforeach
        </dl>
    </div>
@endif --}}

@if ($errors->any())
<div class="alert alert-danger ml-1" style="position:relative">
    <i class="layui-icon layui-icon-close close-message-box" style="position:absolute;top:0;right:0;cursor:pointer"></i>
    <dl>
        @foreach ($errors->all() as $error)
            <dd style="margin-left:10px;">{{ $error }}</dd> 
        @endforeach
    </dl>
</div>
@endif

    