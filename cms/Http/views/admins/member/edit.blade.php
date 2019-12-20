<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑角色 </title>
<style>
  #member_edit_box {
    padding-right: 10px;
  }
  #member_edit_box form{
    margin-top: 30px;
    margin-bottom: 30px;
  }
  #member_edit_box form label{
    width:100px;
  }
</style>
</head>
<body>
  <div class="layer-fluid" id="member_edit_box">
    <form action="post" class="layui-form" id="member_form">
      <input type="hidden" name="user_id" value={{$user_id}}>
      @csrf
      <div class="layui-form-item">
        <label class="layui-form-label">用户名称</label>
        <div class="layui-input-block">
        <input type="text" name="username" lay-verify="required" lay-filter="username" value="{{$member['username']}}" class="layui-input" placeholder="请输入用户名称">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">用户密码</label>
        <div class="layui-input-block">
        <input type="password" name="password" lay-verify="{{isset($member['user_id'])? '':'required'}}" lay-filter="password" value="" class="layui-input"  placeholder="{{isset($member['user_id'])? '不修改无需填写':'请输入用户密码'}}">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">用户电话</label>
        <div class="layui-input-block">
        <input type="text" name="mobile" lay-verify="phone" value="{{$member['mobile']}}" class="layui-input" placeholder="请输入用户电话">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">用户邮箱</label>
        <div class="layui-input-block">
        <input type="text" name="email" lay-verify="email" value="{{$member['email']}}" class="layui-input" placeholder="请输入用户邮箱">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">用户性别</label>
        <div class="layui-input-block">
          <input type="radio" name="gender" value="1" title="男" {{$member['gender']==2 || $member['gender']==3 ?'':'checked'}}>
          <input type="radio" name="gender" value="2" title="女" {{$member['gender']==2?'checked':''}}>
          <input type="radio" name="gender" value="3" title="保密" {{$member['gender']==3?'checked':''}}>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{ isset($member['status']) && $member['status']? $member['status']:1}}" {{isset($member['status']) && $member['status'] == 2 ?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="是|否">
        </div>
      </div>
      <div class="layui-input-block">
        <button type="button" class="layui-btn" lay-filter="save" lay-submit>保存</button>
        <button type="reset"  class="layui-btn layui-btn-primary">重置表单</button>
        <button type="button" class="layui-btn layui-btn-danger" onclick="cancle()">取消</button>
      </div>
    </form>
  </div>
  <script>
    let datas = ''
    layui.use('form', function(){
        let form = layui.form
        form.render()
        form.on('switch(status)',function(){
        // 设置switch开关的value，开为2，关为1
          $('input[name="status"]').val(this.checked?2:1)
        })
        // 用户保存 
        form.on('submit(save)',function(data){
          let status = $('input[name="status"]').val()
          let id =$('input[name="user_id"]').val()
          data.field.status = status
          data.field.user_id = id
          $.post('/admins/member/save',data.field,res => {
            if (res.code != 0) return layer.msg(res.msg,{title:'友情提示',icon:2})
            layer.msg(res.msg,{title:'友情提示',icon:1})
            setTimeout(() => parent.window.location.reload(),1000)
          },'json')
        })
    })
    // 用户保存
    function memberSave(){
      let status = $('input[name="status"]').val()
      let id =$('input[name="uer_id"]').val()
      let data = $('form').serialize() + '&status=' + status + '&user_id=' +id
      $.post('/admins/member/save',data,res => {
        if (res.code != 0) return layer.msg(res.msg,{title:'友情提示',icon:2})
        layer.msg(res.msg,{title:'友情提示',icon:1})
        setTimeout(() => parent.window.location.reload(),1000)
      },'json')
    }
  </script>
</body>
</html>