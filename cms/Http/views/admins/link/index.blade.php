<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 友情链接列表 </title>
</head>
<body>
    <div class="layui-fluid">
      <button class="layui-btn" onclick="editLink()">添加链接</button>
      <table class="layui-table">
        <colgroup>
          <col width="130">
          <col width="140">
          <col width="140">
          <col width="140">
          <col>
        </colgroup>
        <thead>
          <tr>
            <th>ID</th>
            <th>链接名称</th>
            <th>链接地址</th>
            <th>是否禁用</th>
            <th>操作</th>
          </tr>        
        </thead>
        <tbody>
          @foreach($links as $item)
          <tr>
            <td>{{$item['id']}}</td>
            <td>{{$item['title']}}</td>、
            <td>{{$item['url']}}</td>
            <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
            <td>
              @csrf
              <button class="layui-btn" onclick="editLink({{$item['id']}})">修改</button>
              <button class="layui-btn layui-btn-danger" onclick="deleteLink({{$item['id']}})">删除</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <script>
      // 编辑文章链接
      function editLink(id){
        layer.open({
          type: 2,
          title: id>0 ? '修改链接' : '编辑链接',
          shadeClose: true,
          shade: 0.4,
          area: ['580px', '60%'],
          content: `/admins/links/edit?id=${id}`
        })
      }
      // 删除文章链接
      function deleteLink(id){
        layer.confirm('您确定要删除吗？', {
          btn: ['确定','取消'] //按钮
        }, function(){
          let _token = $('input[name="_token"]').val();
          $.post('/admins/links/delete',{_token,id},res => {
            if (res.code !=0) return layer.msg(res.msg,{title:'友情提示',icon:2})
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