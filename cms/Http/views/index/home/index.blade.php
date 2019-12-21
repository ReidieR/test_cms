<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> 首页 </title>
</head>
<body>
  {{-- 顶部导航区 --}}
  @include('index.public.header')
  {{-- 内容主体区域 --}}
  <div class="layui-container">
    <div class="layui-row">
      {{-- 主体左侧内容展示区 --}}
      <div class="layui-col-lg9">
        <div class="layui-row">
            @foreach($result as $item)
            <div id="cate_box">
              <h2 id=cate_title>{{$item['cate_title']}}</h2>
              <span><a href="/list/{{$item['cate_id']}}">更多<i class="layui-icon layui-icon-more"></i></a></span>
            </div>
              @if(!empty($item['chd']))
              @foreach($item['chd'] as $chd)
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
              @else
                <h2 style="margin-left:20px;">这里空空如也,为这个分类加点东西吧!!!</h2>
            @endif
            @endforeach
        </div>
      </div>
      {{-- 主体右侧固定内容区 --}}
      @include('index.public.rightContent')
    </div>  
  </div>
  {{-- 底部固定区 --}}
  @include('index.public.footer')
</body>
</html>