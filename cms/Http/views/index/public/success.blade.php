@if(session()->has('success'))
  <div class="alert alert-success" style="position:relative">
    <i class="layui-icon layui-icon-close close-message-box" style="position:absolute;top:0;right:0;cursor:pointer"></i>
    {{session()->get('success')}}
  </div>
@endif