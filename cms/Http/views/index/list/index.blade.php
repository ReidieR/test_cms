<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> 列表页 </title>
<style>
  article {
    display: flex;

  }
  article img {
    width: 100px;
    height: 100px;
  }
</style>
</head>
<body>
{{-- 顶部导航区 --}}
@include('index.public.header')
{{-- 内容主体区域 --}}
<div class="layui-container">
<div class="layui-row">
{{-- 主体左侧内容展示区 --}}
<div class="layui-col-lg9">
  <div class="layui-row" id="list_container">
    <div id="list_cate_title">{{$title['art_cate_title']}}文章列表</div>
    @foreach($article as $chd)
    <article class="home-article">
    @if(isset($chd['cover_img']))
      <img src="{{$chd['cover_img']}}" alt="">
    @endif
      <div class="home-article-content">
        <h3 id=article_title><a href="/detail/{{$chd['aid']}}">{{$chd['title']}}</a></h3>
        <p>{{$chd['descs']}}</p>
        <dl>
          <dd><a href="javascript:0">点击收藏<i class="layui-icon layui-icon-star" style="margin-left: 10px;"></i></a></dd>
          <dd>阅读量:<span>{{$chd['read_num']}}</span></dd>
        </dl>
      </div>
    </article>
    @endforeach
  </div>
  {{$links}}
</div>
{{-- 主体右侧固定内容区 --}}
@include('index.public.rightContent')
</div>  
</div>

{{-- 底部固定区 --}}
@include('index.public.footer')