<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> 详情页 </title>
</head>
<body>
{{-- 顶部导航区 --}}
@include('index.public.header')
{{-- 内容主体区域 --}}
<div class="layui-container">
<div class="layui-row">
{{-- 主体左侧内容展示区 --}}
<div class="layui-col-lg9">
  <article>
  <h2>{{$article['title']}}</h2>
  <p>{{$content['content']}}</p>
  </article>
</div>
{{-- 主体右侧固定内容区 --}}
@include('index.public.rightContent')
</div>  
</div>
{{-- 底部固定区 --}}
@include('index.public.footer')