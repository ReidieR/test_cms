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
    </script>
</body>
</html>