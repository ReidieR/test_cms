<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 图片管理 </title>
<style>
  #pre_img {
    height: 25px;
  }
</style>
</head>
<body>
  <div class="layui-fluid">
    <button class="layui-btn" onclick="editImage()">添加图片</button>
    <table class="layui-table">
      <colgroup>
        <col width="80">
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
          <th>图片标题</th>
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
          <td>{{$item['img_id']}}</td>
          <td><img src="{{$item['img_url']}}" alt="" id="pre_img">{{$item['title']}}</td>
          <td>{{$item['user_id']}}</td>
          <td>{{date('Y-m-d H:m:s',$item['updated_at'])}}</td>
          <td>{{$item['status'] == 2 ? '是' : '否'}}</td>
          <td>{{$item['is_hidden'] == 2 ? '是' : '否'}}</td>
          <td>
            @csrf
            <button class="layui-btn" onclick="editImage({{$item['img_id']}})">修改</button>
            <button class="layui-btn layui-btn-danger" onclick="deleteImage({{$item['img_id']}})">删除</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <script>
    // 编辑图片
    function editImage(id){
      layer.open({
        type: 2,
        title: id>0 ? '修改图片' : '添加图片',
        shadeClose: true,
        shade: 0.4,
        area: ['100%', '100%'],
        content: `/admins/image/edit?img_id=${id}`
      })
    }

    // 删除图片
    function deleteImage(img_id){
      layer.confirm('您确定要删除吗？', {
        btn: ['确定','取消'] //按钮
      }, function(){
        let _token = $('input[name="_token"]').val();
        $.post('/admins/image/delete',{_token,img_id},res => {
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