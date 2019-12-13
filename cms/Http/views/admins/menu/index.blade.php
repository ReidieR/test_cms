<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 菜单管理 </title>
</head>
<body>
  <div class="layui-fluid">
    <button class="layui-btn" onclick="editMenu()">添加菜单</button>
    @if($pid)
    <input type="hidden" name="pid" value="{{$pid}}">
    <button class="layui-btn layui-btn-warm" onclick="backMenu()">返回上一级</button>
    @endif
    <table class="layui-table">
      <colgroup>
        <col width="130">
        <col width="130">
        <col width="130">
        <col width="130">
        <col width="130">
        <col width="130">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>菜单名称</th>
          <th>controller</th>
          <th>action</th>
          <th>是否禁用</th>
          <th>是否隐藏</th>
          <th>操作</th>
        </tr>        
      </thead>
      <tbody>
        @foreach($menu as $item)
        <tr>
          <td>{{$item['mid']}}</td>
          <td>{{$item['title']}}</td>
          <td>{{$item['controller']}}</td>
          <td>{{$item['action']}}</td>
          <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
          <td>{{$item['is_hidden'] == 2 ? '是' : '否'}}</td>
          <td>
            @csrf
            <button class="layui-btn" onclick="editMenu({{$item['mid']}})">修改</button>
            <button class="layui-btn layui-btn-warm" onclick="childMenu({{$item['mid']}})">子菜单</button>
            <button class="layui-btn layui-btn-danger" onclick="deleteMenu({{$item['mid']}})">删除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <script>
    // 编辑菜单
    function editMenu(mid){
      let pid = $('input[name="pid"]').val();
      layer.open({
        type: 2,
        title: mid>0 ? '修改菜单' : '编辑菜单',
        shadeClose: true,
        shade: 0.4,
        area: ['580px', '80%'],
        content: `/admins/menu/edit?mid=${mid}&pid=${pid}`
      })
    }
    // 返回上一级
    function backMenu(){
      window.history.back();
    }
    // 删除菜单
    function deleteMenu(mid){
      layer.confirm('您确定要删除吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        let _token = $('input[name="_token"]').val();
        $.post('/admins/menu/delete',{_token,mid},res => {
          if (res.code !=0) return layer.msg(res.msg,{title:'友情提示',icon:2})
          setTimeout(() => window.location.reload(), 1000)
        },'json')
      }, function(){
        layer.closeAll();
        });
    }

  </script>
</body>
</html>