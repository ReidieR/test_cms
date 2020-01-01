<!DOCTYPE html>
<html lang="en">
<head>
  @include('index.public.link')
  <title>登录</title>
</head>
<style>
  #login_container{

  }
  body {
    /* background-image:url('/static/images/下载 (1).jpg'); */
    /* background-size:100% 100%; */
  }
  #login_box{
    padding: 20px;
    padding-right: 60px;
    border:1px solid #eee;
    box-shadow: 0 0 5px rgba(150,150,150);
    position:absolute;
    width: 500px;
    left:50%;
    top:150px;
    transform: translate(-50%);
  }
  #verify_code_box{
    display: flex;
    justify-content: flex-start;
  }
  #verify_code_box img {
    margin-left: 10px;
  }
</style>
<body>
  <div class="layui-fluid" id="login_container">
    <div id="login_box">
        <form class="layui-form" method="POST" id="login_form" action="/dologin">
          @csrf
          <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-block">
            <input type="text" value="{{old('username')}}" name="username" lay-verify="required" lay-reqtext="请输入账号" placeholder="请输入用户名/邮箱/手机号" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-block">
              <input type="password" name="password" lay-verify="required" lay-reqtext="请输入密码" placeholder="请输入密码" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-form-item">
              <label class="layui-form-label">验证码</label>
              <div class="layui-input-block" id="verify_code_box">
                <input type="tel" name="captcha" lay-verify="required" lay-reqtext="请输入验证码" class="layui-input" onkeydown="enter()" placeholder="请输入验证码">
                <img src="{{captcha_src()}}" id='capcha_code' onclick="reload_captcha()">
              </div>
          </div>
          @include('index.public.errors')
          <div class="layui-form-item" style="margin-bottom: 0px;">
            <div class="layui-input-block">      
              <button type="submit" class="layui-btn" lay-submit="" lay-filter="login">登录</button>
              <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
          </div>
       </form>
    </div>
    <script>
      layui.use(['form','layer'],function(){
        console.log(123)
        let form = layui.form 
        let layer = layui.layer

      })
      // 刷新验证码
      function reload_captcha(){
        let src = $('#capcha_code').attr('src') + Math.random()
        $('#capcha_code').attr('src',src)
      }
    </script>
</body>
</html>