<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑链接 </title>
</head>
<style>
  #link_container{
    padding-right:10px;
  }
  #link_container form{
    margin-top:30px;
    margin-bottom: 30px;
  }
  #link_container form label{
    width:100px;
  }
</style>
<body>
  <div class="layer-fluid" id="link_container">
    <form class="layui-form" lay-filter="link_form">
      @csrf
      <input type="hidden" name="id" value="{{$id}}">
      <div class="layui-form-item">
        <label class="layui-form-label">链接名称</label>
        <div class="layui-input-block">
        <input type="text" name="title" lay-filter="title" lay-verify="required" lay-reqtext="请输入网站名称" value="{{$link['title']}}" class="layui-input">
        </div> 
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">链接地址</label>
        <div class="layui-input-block">
        <input type="text" name="url" lay-filter="url" lay-verify="required|url" value="{{$link['url']}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{$link['status']?$link['status']:'1'}}" {{$link['status']==2?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="开启|关闭">
        </div>
      </div>
      <div class="layui-input-block">
          <button type="button" class="layui-btn" onclick="linkSave()">保存</button>
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
      });
      // 链接保存
      function linkSave(){
        let data=$('form').serialize() + '&status=' + $('input[name="status"]').val();
        $.post(
          '/admins/links/save',
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