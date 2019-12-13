<!DOCTYPE html>
<html lang="en">
<head>
  @include('admins.public.link')
  <title>后台登录</title>
</head>
<body>
  <div class="layui-fluid" id="login_container">
    <div id="login_box">
        <form class="layui-form" method="" id="login_form" action="">
          @csrf
          <div class="layui-form-item">
            <label class="layui-form-label">用户名</label>
            <div class="layui-input-block">
              <input type="text" name="username" placeholder="请输入用户名" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
              <input type="password" name="password" placeholder="请输入密码" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-inline">
              <label class="layui-form-label">验证码</label>
              <div class="layui-input-block" id="verify_code_box">
                <input type="tel" name="captcha" class="layui-input" onkeydown="enter()" placeholder="请输入验证码">
                <img src="{{captcha_src()}}" id='capcha_code' onclick="reload_captcha()">
              </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button type="button" class="layui-btn" onclick="dologin()">登录</button>
              <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
          </div>
       </form>
    </div>
</body>
</html>