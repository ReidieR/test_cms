<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑角色 </title>
<style>
  #admin_edit_box {
    padding-right: 10px;
  }
  #admin_edit_box form{
    margin-top: 30px;
    margin-bottom: 30px;
  }
  #admin_edit_box form label{
    width:100px;
  }
</style>
</head>
<body>
  <div class="layer-fluid" id="admin_edit_box">
    <form action="post" class="layui-form" id="admin_form">
      <input type="hidden" name="id" value={{$id}}>
      @csrf
      <div class="layui-form-item">
        <label class="layui-form-label">管理员名称</label>
        <div class="layui-input-block">
        <input type="text" name="username" lay-filter="username" value="{{$admin['username']}}" class="layui-input" placeholder="请输入管理员名称">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">管理员密码</label>
        <div class="layui-input-block">
        <input type="password" name="password" lay-filter="password" value="" class="layui-input"  placeholder="{{isset($admin['id'])? '不修改无需填写':'请输入管理员密码'}}">
        </div>
      </div>
      <div class="layui-form-item" pane="">
        <label class="layui-form-label">管理员角色</label>
        <div class="layui-input-block">
        <select name="group_id" id="" lay-filter="group_id">
            <option value="0">请选择</option>
            @foreach ($group as $item)
            <option value="{{$item['gid']}}" {{$admin['group_id']==$item['gid']?'selected':''}}>{{$item['title']}}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">管理员电话</label>
        <div class="layui-input-block">
        <input type="text" name="mobile" lay-filter="mobile" value="{{$admin['mobile']}}" class="layui-input" placeholder="请输入管理员电话">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">管理员邮箱</label>
        <div class="layui-input-block">
        <input type="text" name="email" lay-filter="email" value="{{$admin['email']}}" class="layui-input" placeholder="请输入管理员邮箱">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{isset($status)&&$status?$status:1}}" {{isset($status)&&$status == 2 ?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="开启|关闭">
        </div>
      </div>
      <div class="layui-input-block">
        <button type="button" class="layui-btn" onclick="adminSave()">保存</button>
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
    })
    // 管理员保存
    function adminSave(){
      let data = $('form').serializeArray();
      let status = $('input[name="status"]').val()
      let id =$('input[name="id"]').val()
      $.post(`/admins/admin/save?status=${status}&id=${id}`,data,res => {
        if (res.code != 0) return layer.msg(res.msg,{title:'友情提示',icon:2})
        layer.msg(res.msg,{title:'友情提示',icon:1})
        setTimeout(() => parent.window.location.reload(),1000)
      },'json')
    }
  </script>
</body>
</html>