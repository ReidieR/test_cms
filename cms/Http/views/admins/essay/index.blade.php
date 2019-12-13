<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 文章管理 </title>
</head>
<body>
  <div class="layui-fluid">
    <button class="layui-btn" onclick="editEssay()">添加文章</button>
    <table class="layui-table">
      <colgroup>
        <col width="80">
        <col width="100">
        <col width="200">
        <col width="100">
        <col width="180">
        <col width="100">
        <col width="130">
        <col>
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>文章分类</th>
          <th>文章名称</th>
          <th>作者</th>
          <th>修改时间</th>
          <th>状态</th>
          <th>是否隐藏</th>
          <th>操作</th>
        </tr>        
      </thead>
      <tbody>
        @foreach($result as $item)
        <tr>
          <td>{{$item['aid']}}</td>
          <td>{{$item['cate_title']}}</td>
          <td>{{$item['title']}}</td>
          <td>{{$item['author']}}</td>
          <td>{{date('Y-m-d H:m:s',$item['updated_at'])}}</td>
          <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
          <td>{{$item['is_hidden'] == 2 ? '是' : '否'}}</td>
          <td>
            @csrf
            <button class="layui-btn" onclick="editEssay({{$item['aid']}})">修改</button>
            <button class="layui-btn layui-btn-danger" onclick="deleteEssay({{$item['aid']}})">删除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <script>
    // 编辑文章
    function editEssay(mid){
      let pid = $('input[name="pid"]').val();
      layer.open({
        type: 2,
        title: mid>0 ? '修改文章' : '编辑文章',
        shadeClose: true,
        shade: 0.4,
        area: ['580px', '80%'],
        content: `/admins/Essay/edit?mid=${mid}&pid=${pid}`
      })
    }

    // 删除文章
    function deleteEssay(mid){
      layer.confirm('您确定要删除吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        let _token = $('input[name="_token"]').val();
        $.post('/admins/Essay/delete',{_token,mid},res => {
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