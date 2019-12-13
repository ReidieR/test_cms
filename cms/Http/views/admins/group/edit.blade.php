<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 编辑角色 </title>
<style>
  #group_edit_box {
    padding-right: 10px;
  }
  #group_edit_box form{
    margin-top: 30px;
    margin-bottom: 30px;
  }
  #group_edit_box form label{
    width:100px;
  }
</style>
</head>
<body>
  <div class="layer-fluid" id="group_edit_box">
    <form action="post" class="layui-form">
      @csrf
      <input type="hidden" name="gid" value={{isset($gid)?$gid:''}}>
      <div class="layui-form-item">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-block">
        <input type="text" name="title" value="{{isset($title)?$title:''}}" class="layui-input">
        </div>
      </div>
      <div class="layui-form-item" pane="">
        <label class="layui-form-label">角色权限</label>
        <div class="layui-input-block">
          @foreach($menu as $item)
        <input type="checkbox" lay-filter="right" value="{{$item['mid']}}" {{isset($rights) && ($rights=="all"||in_array($item['mid'],$rights)) ? 'checked': ''}} name="{{$item['title']}}" lay-skin="primary" title="{{$item['title']}}" placeholder="请输入角色名称">
          <br/>
          @if($item['children'])
            @foreach ($item['children'] as $chd)
            <input type="checkbox" lay-filter="right" value="{{$chd['mid']}}" name="{{$chd['title']}}" {{isset($rights) && ($rights=="all"||in_array($chd['mid'],$rights)) ? 'checked': ''}} lay-skin="primary" title="{{$chd['title']}}">   
            @endforeach
            <br/>
          @endif
          @endforeach
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否禁用</label>
        <div class="layui-input-block">
        <input type="checkbox" name="status" value="{{isset($status)&&$status?$status:1}}" {{isset($status)&&$status == 2 ?'checked':''}} lay-filter="status" lay-skin="switch" lay-text="开启|关闭">
        </div>
      </div>
      <div class="layui-input-block">
        <button type="button" class="layui-btn" onclick="groupSave()">保存</button>
        <button type="reset"  class="layui-btn layui-btn-primary">重置表单</button>
        <button type="button" class="layui-btn layui-btn-danger" onclick="cancle()">取消</button>
      </div>
    </form>
  </div>
  <script>
    layui.use('form', function(){
        let form = layui.form
        form.render()
        form.on('switch(status)',function(){
          // 设置switch开关的value，开为2，关为1
          $('input[name="status"]').val(this.checked?2:1)
        }) 
    })
    function groupSave(){
      let data = $('form').serialize();
      // let gid = $('input[name="gid"]').val()
      let status = $('input[name="status"]').val()
      // let _token = $('input[name="_token"]').val()
      $.post(`/admins/group/save?status=${status}`,data,res => {
        if (res.code != 0) return layer.msg(res.msg,{title:'友情提示',icon:2})
        layer.msg(res.msg,{title:'友情提示',icon:1})
        setTimeout(() => parent.window.location.reload(),1000)
      },'json')
    }
  </script>
</body>
</html>