<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑菜单 </title>
</head>
<style>
  #articleCate_container{
    padding-right:10px;
  }
  #articleCate_container form{
    margin-top:30px;
    margin-bottom: 30px;
  }
  #articleCate_container form label{
    width:100px;
  }
</style>
<body>
  <div class="layer-fluid" id="articleCate_container">
    <form class="layui-form" lay-filter="articleCate_form">
      @csrf
      <input type="hidden" name="art_cart_id" value="{{$id}}">
      <input type="hidden" name="cate_pid" value="{{$cate_pid}}">
      @if($cate_pid)
      <div class="layui-form-item">
        <label class="layui-form-label">父级分类</label>
        <div class="layui-input-block">
        <input type="text" disabled name="pcate_title" value="{{$pcate_title}}" class="layui-input">
        </div>
      </div>
      @endif
      <div class="layui-form-item">
        <label class="layui-form-label">分类名称</label>
        <div class="layui-input-block">
        <input type="text" name="title" value="{{$art_cate['art_cate_title']}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{$art_cate['status']?$art_cate['status']:'1'}}" {{$art_cate['status']==2?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="开启|关闭">
        </div>
      </div>
      <div class="layui-form-item">
          <label class="layui-form-label">是否隐藏</label>
          <div class="layui-input-block">
          <input type="checkbox" name="is_hidden" value="{{$art_cate['is_hidden']?$art_cate['is_hidden']:1}}" {{$art_cate['is_hidden']==2?'checked':''}} lay-filter="is_hidden" lay-skin="switch" lay-text="开启|关闭">
          </div>
        </div>
      <div class="layui-input-block">
          <button type="button" class="layui-btn" onclick="articleCateSave()">保存</button>
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
      function articleCateSave(){
        let status = $('input[name="status"]').val(); 
        let is_hidden = $('input[name="is_hidden"]').val(); 
        let data = new Object()
        data.status = status
        data.is_hidden = is_hidden
        data.art_cate_title = $('input[name="title"]').val()
        data.art_cate_pid = $('input[name="cate_pid"]').val()
        data.art_cate_id = $('input[name="art_cart_id"]').val()
        data._token = $('input[name="_token"]').val()
        if (data.title=='') {
          return layer.msg('请输入菜单名称',{title:'友情提示',icon:5})
        }
        $.post(
          '/admins/article/save',
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