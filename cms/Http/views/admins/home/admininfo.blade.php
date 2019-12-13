<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 个人信息 </title>
</head>
<body>
  <div class="layui-fluid">
    <form class="layui-form" action="/admins/home/changeinfo" method="POST" >
      @csrf
      <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
        <input type="text" name="username" value="{{$admin->username}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block">
          <input type="text" name="email" value="{{$admin->email}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-block">
          <input type="text" name="mobile" value="{{$admin->mobile}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button type="submit" class="layui-btn" class="layui-btn layui-btn-primary" onclick="changeInfo()">保存</button>
        </div>
      </div>
    </form>
  </div>
  <script>
    let errors = ''
    @if(count($errors)>0)
      @foreach($errors->all() as $error)
        errors += "{{$error}}<br/>"
      @endforeach
      layer.alert(errors,{title:'错误提示',icon:5})
    @endif
  </script>
</body>
</html>