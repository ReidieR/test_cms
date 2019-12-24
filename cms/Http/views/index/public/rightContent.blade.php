<div class="layui-col-lg3" id="right_content_box">
  <div class="layui-row">
    <div class="layui-card" id="right_user_card">
      <div class="layui-card-header">个人中心</div>
      <div class="layui-card-body">
        <dl>
        <dd><a href="/member/{{isset(Auth::guard('member')->user()->user_id)?Auth::guard('member')->user()->user_id:''}}">我的主页</a></dd>
        <dd><a href="/edit/{{isset(Auth::guard('member')->user()->user_id)?Auth::guard('member')->user()->user_id:''}}">写文章</a></dd>
        <dd><a href="/conllect/{{isset(Auth::guard('member')->user()->user_id)?Auth::guard('member')->user()->user_id:''}}">个人收藏</a></dd>
        </dl>
      </div>
    </div>
    <div class="layui-card">
      <div class="site-demo-laydate">
        <div class="layui-inline" id="calendar"></div>
      </div>
    </div>
    <div class="layui-card article-card">
      <div class="layui-card-header">热门文章</div>
      <div class="layui-card-body">
        <ul>
          @foreach($hotArticle as $item)
          <li class="hot-article"><a href="/detail/{{$item['aid']}}">{{$item['title']}}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="layui-card link-card">
      <div class="layui-card-header">友情链接</div>
      <div class="layui-card-body">
        <dl>
          @foreach($link as $item)
          <dd><a href="{{$item['url']}}">{{$item['title']}}</a></dd>
          @endforeach
        </dl>
      </div>
    </div>
  </div>
</div>
<script>
  layui.use(['laydate','util','layer'],function(){
    let laydate = layui.laydate
      ,util = layui.util
      ,layer = layui.layer
    laydate.render({
    elem: '#calendar'
    ,position: 'static'
    }) 
    util.fixbar({
      css: {right: 50, bottom: 50}
      ,bgcolor: '#393D49'
    })
  })
</script>