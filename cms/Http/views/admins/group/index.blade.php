<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 角色列表 </title>
</head>
<body>
    <div class="layui-fluid">
      <button class="layui-btn" onclick="editGroup()">添加角色</button>
      <table class="layui-table">
        <colgroup>
          <col width="130">
          <col width="130">
          <col width="130">
          <col width="130">
          <col>
        </colgroup>
        <thead>
          <tr>
            <th>ID</th>
            <th>角色名称</th>
            <th>是否禁用</th>
            <th>操作</th>
          </tr>        
        </thead>
        <tbody>
          @foreach($group as $item)
          <tr>
            <td>{{$item['gid']}}</td>
            <td>{{$item['title']}}</td>
            <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
            <td>
              @csrf
              <button class="layui-btn" onclick="editGroup({{$item['gid']}})">修改</button>
              <button class="layui-btn layui-btn-danger" onclick="deleteMenu({{$item['gid']}})">删除</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <script>
      // 角色编辑
      function editGroup(gid){
        layer.open({
          type: 2,
          title: gid>0 ? '修改角色' : '添加角色',
          shadeClose: true,
          shade: 0.4,
          area: ['580px', '80%'],
          content: `/admins/group/edit?gid=${gid}`
        })
      }
      // 角色删除
      function deleteMenu(gid){
        layer.confirm('您确定要删除吗？', {
          btn: ['确定','取消'] //按钮
        }, function(){
          let _token = $('input[name="_token"]').val()
          $.post('/admins/group/delete',{_token,gid},res=>{
                  if (res.code != 0) return layer.msg('删除失败',{title:'友情提示',icon:2})
                  layer.msg(res.msg,{title:'友情提示',icon:1})
                  setTimeout(() => window.location.reload(),1000)
                },'json')
        }, function(){
          layer.msg('删除已取消',{time:1000})
        });
      }
    </script>
</body>
</html>