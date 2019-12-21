<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> title </title>
</head>
<style>
#edit_container .layui-col-lg2{
    padding:10px;
    overflow-y: scroll;
    min-height:497px;
  }
#edit_container .layui-col-lg2:hover{
  cursor:pointer;
}
#add_article span{
  font-size:18px;
} 

</style>
<body>
{{-- 顶部导航区 --}}
<ul class="layui-nav" lay-filter="">
  <li class="layui-nav-item"><a href="javascript:0">回到首页</a></li>
  <li class="layui-nav-item"><a href="javascript:0">选择编辑器</a></li>
  <li class="layui-nav-item"><a href="javascript:0">退出编辑</a></li>
</ul>

{{-- 内容主体区域 --}}
<div class="layui-container" id="edit_container">
  <div class="layui-row">
        {{-- 主体左侧侧固定内容区 --}}
        <div class="layui-col-lg2">
          <div id="add_article">
            <i class="layui-icon layui-icon-add-1"></i>
            <span>新建文章</span>
          </div>
          <ul>
            
          </ul>
        </div>
        {{-- 主体右侧侧内容展示区 --}}
        <div class="layui-col-lg10">
          <div class="layui-row">
            <form class="layui-form" >
              <div class="layui-form-item" style="margin-top: 20px;">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block">
                  <input type="text" name="" placeholder="请输入文章标题" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item" style="padding-left: 40px;">
                  <!-- 加载编辑器的容器 -->
                  <script id="container" name="content" type="text/plain">
                  </script>         
              </div>
            </form>
          </div>
        </div> 
  </div>
</div>

{{-- 底部固定区 --}}
@include('index.public.footer')
@include('vendor.ueditor.assets')
<script>
   // 百度富文本编辑器实例化
   var ue = UE.getEditor('container',{
    initialFrameHeight:300
   })
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}') // 设置 CSRF token.
    });
  layui.use(['element','form'],function(){
    let form = layui.form
    form.render()
  })

</script>
</body>
</html>