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
    <input type="hidden" name="cate_id" value={{$title['art_cate_id']}}>
    <div id="list_cate_title">{{$title['art_cate_title']}}文章列表</div>
    @foreach($result as $chd)
    <article class="home-article">
    @if(isset($chd['cover_img']))
      <img src="{{$chd['cover_img']}}" alt="">
    @endif
      <div class="home-article-content">
        <h3 id=article_title onclick="clickArticleTitle({{$chd['aid']}})"><a href="/detail/{{$chd['aid']}}">{{$chd['title']}}</a></h3>
        <p>{{$chd['descs']}}</p>
        <dl>
          <dd><span class="conllect_art_span"
            onclick="{{\Auth::guard('member')->user()?'collectArticle':'conllectToLogin'}}(this,{{$chd['aid']}})">
            {{isset($conllection) && in_array($chd['aid'],$conllection) ? '已收藏':'点击收藏'}}
            <i class="layui-icon {{isset($conllection) && in_array($chd['aid'],$conllection) ? 'layui-icon-star-fill':'layui-icon-star'}}" ></i>
          </span></dd>
          <dd>阅读量:<span>{{$chd['read_num']}}</span></dd>
        </dl>
      </div>
    </article>
    @endforeach
  </div>
  {{$links}}
  {{-- <div id="paginate"></div> --}}
</div>
{{-- 主体右侧固定内容区 --}}
@include('index.public.rightContent')
</div>  
</div>

{{-- 底部固定区 --}}
@include('index.public.footer')

{{-- <script>
  layui.use('laypage', function(){
  var laypage = layui.laypage;
  
  //执行一个laypage实例
  laypage.render({
    elem: 'paginate' //注意，这里的 test1 是 ID，不用加 # 号
    ,count: {{$total}} //数据总数，从服务端得到
    ,layout: ['limit', 'prev', 'page', 'next','skip']
    ,jump:function(obj,first){
      if(!first){
        let cate_id = $('input[name="cate_id"]').val()
        let curr_page = obj.curr
        let limit = obj.limit
      //do something
      $.post('/list/paginate',{_token:"{{csrf_token()}}",curr_page,limit,cate_id},res=>{
        if(res.code != 0 ) return layer.msg(res.msg,{title:'温馨提示',icon:'2'})
        window.location.reload()
      },'json')

    }
    }
  });
});
</script> --}}
</body>
</html>