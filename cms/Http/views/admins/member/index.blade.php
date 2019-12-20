<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 用户列表 </title>
</head>
<body>
  <div class="layui-fluid">
    <button class="layui-btn" onclick="editMember()">添加用户</button>
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
          <th>用户名称</th>
          <th>用户电话</th>
          <th>用户邮箱</th>
          <th>用户性别</th>
          <th>是否禁用</th>
          <th>操作</th>
        </tr>        
      </thead>
      <tbody>
        @foreach($result as $item)
        <tr>
          <td>{{$item['user_id']}}</td>
          <td>{{$item['username']}}</td>
          <td>{{$item['mobile']}}</td>
          <td>{{$item['email']}}</td>
          <td>{{$item['gender']}}</td>
          <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
          <td>
            @csrf
            <button class="layui-btn" onclick="editMember({{$item['user_id']}})">修改</button>
            <button class="layui-btn layui-btn-danger" onclick="delettMember({{$item['user_id']}})">删除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{$links}}
  </div>
  <script>
    // 编辑用户
    function editMember(id){
      layer.open({
        type: 2,
        title: id>0 ? '修改用户' : '编辑用户',
        shadeClose: true,
        shade: 0.4,
        area: ['580px', '80%'],
        content: `/admins/member/edit?user_id=${id}`
      })
    }
    // 删除用户
    function delettMember(id){
      layer.confirm('您确定要删除吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        let _token = $('input[name="_token"]').val();
        $.post('tMemberstMember/delete',{_token,id},res => {
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
