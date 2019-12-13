<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 管理员列表 </title>
</head>
<body>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    @include('admins.public.link')
    <title> 管理员管理 </title>
    </head>
    <body>
      <div class="layui-fluid">
        <button class="layui-btn" onclick="editAdmin()">添加管理员</button>
        <table class="layui-table">
          <colgroup>
            <col width="80">
            <col width="100">
            <col width="120">
            <col width="100">
            <col width="100">
            <col width="100">
            <col>
          </colgroup>
          <thead>
            <tr>
              <th>ID</th>
              <th>管理员名称</th>
              <th>管理员角色</th>
              <th>管理员电话</th>
              <th>管理员邮箱</th>
              <th>是否禁用</th>
              <th>操作</th>
            </tr>        
          </thead>
          <tbody>
            @foreach($admin as $item)
            <tr>
              <td>{{$item['id']}}</td>
              <td>{{$item['username']}}</td>
              <td>{{$item['group_title'] ? $item['group_title'] : ''}}</td>
              <td>{{$item['mobile']}}</td>
              <td>{{$item['email']}}</td>
              <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
              <td>
                @csrf
                <button class="layui-btn" onclick="editAdmin({{$item['id']}})">修改</button>
                <button class="layui-btn layui-btn-danger" onclick="deleteAdmin({{$item['id']}})">删除</button>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <script>
        // 编辑管理员
        function editAdmin(id){
          layer.open({
            type: 2,
            title: id>0 ? '修改管理员' : '编辑管理员',
            shadeClose: true,
            shade: 0.4,
            area: ['580px', '80%'],
            content: `/admins/admin/edit?id=${id}`
          })
        }
        // 删除管理员
        function deleteAdmin(id){
          layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
          }, function(){
            let _token = $('input[name="_token"]').val();
            $.post('/admins/admin/delete',{_token,id},res => {
              if (res.code !=0) return layer.msg('删除失败',{title:'友情提示',icon:2})
              layer.msg(res.msg,{title:'友情提示',icon:1})
              setTimeout(() => window.location.reload(), 1000)
            },'json')
          }, function(){
            layer.closeAll();
            });
        }
      </script>
    </body>
    </html>
</body>
</html>