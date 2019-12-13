<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑菜单 </title>
</head>
<style>
  #menu_container{
    padding-right:10px;
  }
  #menu_container form{
    margin-top:30px;
    margin-bottom: 30px;
  }
  #menu_container form label{
    width:100px;
  }
</style>
<body>
  <div class="layer-fluid" id="menu_container">
    <form class="layui-form" lay-filter="menu_form">
      @csrf
      <input type="hidden" name="mid" value="{{$mid}}">
      <input type="hidden" name="pid" value="{{$pid?$pid:0}}">
      @if($pid)
      <div class="layui-form-item">
        <label class="layui-form-label">父级菜单</label>
        <div class="layui-input-block">
        <input type="text" disabled name="pmenu" value="{{$pmenu}}" class="layui-input">
        </div>
      </div>
      @endif
      <div class="layui-form-item">
        <label class="layui-form-label">菜单名称</label>
        <div class="layui-input-block">
        <input type="text" name="title" value="{{$menu['title']}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">控制器</label>
        <div class="layui-input-block">
          <input type="text" name="controller" value="{{$menu['controller']}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">方法</label>
        <div class="layui-input-block">
          <input type="text" name="action" value="{{$menu['action']}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{$menu['status']?$menu['status']:'1'}}" {{$menu['status']==2?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="开启|关闭">
        </div>
      </div>
      <div class="layui-form-item">
          <label class="layui-form-label">是否隐藏</label>
          <div class="layui-input-block">
          <input type="checkbox" name="is_hidden" value="{{$menu['is_hidden']?$menu['is_hidden']:1}}" {{$menu['is_hidden']==2?'checked':''}} lay-filter="is_hidden" lay-skin="switch" lay-text="开启|关闭">
          </div>
        </div>
      <div class="layui-input-block">
          <button type="button" class="layui-btn" onclick="menuSave()">保存</button>
          <button type="reset"  class="layui-btn layui-btn-primary">重置表单</button>
          <button type="button" class="layui-btn layui-btn-danger" onclick="cancle()">取消</button>
        </div>
    </form>
    <script>

      layui.use('form', function(){
        let form = layui.form
        form.render()
        form.on('switch(status)',function(){
          // 设置switch开关的value，开为2，关为1
          $('input[name="status"]').val(this.checked?2:1)
        })
        form.on('switch(is_hidden)',function(){
          // 设置switch开关的value，开为2，关为1
          $('input[name="is_hidden"]').val(this.checked?2:1)
        })
      });
      // 菜单保存
      function menuSave(){
        let status = $('input[name="status"]').val(); 
        let is_hidden = $('input[name="is_hidden"]').val(); 
        let data = new Object()
        data.status = status
        data.is_hidden = is_hidden
        data.title = $('input[name="title"]').val()
        data.controller = $('input[name="controller"]').val()
        data.action = $('input[name="action"]').val()
        data.pid = $('input[name="pid"]').val()
        data._token = $('input[name="_token"]').val()
        data.mid = $('input[name="mid"]').val()
        // console.log(data.mid)
        // return
        if (data.title=='') {
          return layer.msg('请输入菜单名称',{title:'友情提示',icon:5})
        }
        $.post(
          '/admins/menu/save',
          data,
          res => {
            if (res.code>0) return layer.alert(res.msg,{icon:2})
            layer.msg(res.msg,{icon:1})
            setTimeout(() => parent.window.location.reload(), 1000)
          },
          'json'
        )
      }
      // 取消编辑
      function cancle(){
        layer.closeAll()       
      }
    </script>
</body>
</html>