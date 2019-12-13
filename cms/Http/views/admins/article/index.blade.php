<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 文章分类列表 </title>
</head>
<body>
    <div class="layui-fluid">
      <button class="layui-btn" onclick="editArticleCate()">添加分类</button>
      @if($cate_pid)
      <input type="hidden" name="cate_pid" value="{{$cate_pid}}">
      <button class="layui-btn layui-btn-warm" onclick="backArticleCate()">返回上一级</button>
      @endif
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
            <th>分类名称</th>
            <th>是否禁用</th>
            <th>是否隐藏</th>
            <th>操作</th>
          </tr>        
        </thead>
        <tbody>
          @foreach($result as $item)
          <tr>
            <td>{{$item['art_cate_id']}}</td>
            <td>{{$item['art_cate_title']}}</td>
            <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
            <td>{{$item['is_hidden'] == 2 ? '是' : '否'}}</td>
            <td>
              @csrf
              <button class="layui-btn" onclick="editArticleCate({{$item['art_cate_id']}})">修改</button>
              <button class="layui-btn layui-btn-warm" onclick="childArticleCate({{$item['art_cate_id']}})">子文章分类</button>
              <button class="layui-btn layui-btn-danger" onclick="deleteArticleCate({{$item['art_cate_id']}})">删除</button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <script>
      // 编辑文章分类
      function editArticleCate(id){
        let pid = $('input[name="cate_pid"]').val();
        layer.open({
          type: 2,
          title: id>0 ? '修改文章分类' : '编辑文章分类',
          shadeClose: true,
          shade: 0.4,
          area: ['580px', '80%'],
          content: `/admins/article/edit?art_cate_id=${id}&cate_pid=${pid}`
        })
      }
      // 返回上一级
      function backArticleCate(){
        window.history.back();
      }
      // 删除文章分类
      function deleteArticleCate(id){
        layer.confirm('您确定要删除吗？', {
          btn: ['确定','取消'] //按钮
        }, function(){
          let _token = $('input[name="_token"]').val();
          $.post('/admins/article/delete',{_token,id},res => {
            if (res.code !=0) return layer.msg(res.msg,{title:'友情提示',icon:2})
            setTimeout(() => window.location.reload(), 1000)
          },'json')
        }, function(){
          layer.closeAll();
          });
      }
      // 子分类
      function childArticleCate(id) {
        window.location.href = `?cate_pid=${id}`
      }
    </script>
  </body>
</html>