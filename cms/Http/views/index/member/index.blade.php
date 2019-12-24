<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> 个人中心 </title>
</head>
<body>
{{-- 顶部导航区 --}}
@include('index.public.header')
{{-- 内容主体区域 --}}
<div class="layui-container">
  <div class="layui-row">
    {{-- 主体右侧固定内容区 --}}
    <div class="layui-col-lg2" style="border:red 1px solid;height:500px">
      <div class="layui-row">
        <div class="layui-card">
          <div class="layui-card-header">header</div>
          <div class="layui-card-body">
            <ul id="user_center_nav">
              <li><a href="javascript:0" onclick="contentSwith(this)" con_ac="user_info">个人信息</a></li>
              <li><a href="javascript:0" onclick="contentSwith(this)" con_ac="user_index">我的主页</a></li>
              <li><a href="javascript:0" onclick="contentSwith(this)" con_ac="user_conllect">我的收藏</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    {{-- 主体左侧内容展示区 --}}
    <div class="layui-col-lg10">
      <div class="member-content-header">
        <h3>个人资料</h3>
      </div>
      <iframe src="/index/member/member_info" frameborder="0" style="with:100%;height:100%;"></iframe>
    </div>
  </div>  
</div>
{{-- 底部固定区 --}}
@include('index.public.footer')
</body>
</html>