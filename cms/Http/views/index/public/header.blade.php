<ul class="layui-nav" id="public_nave">
  <div class="site-title">
    <span class="layui-nav-item">
      学习园地
    </span>
  </div>
  <div class="nav-box">
    <div class="left-nav">
      <li class="layui-nav-item">
        <a href="/">首页</a>
      </li>
      @foreach($nav as $item)
      <li class="layui-nav-item">
        <a href="">{{$item['art_cate_title']}}</a>
        @if(isset($item['children']))
        <dl class="layui-nav-child">
          @foreach($item['children'] as $chd)
          <dd><a href="/list/{{$chd['art_cate_id']}}">{{$chd['art_cate_title']}}</a></dd>
          @endforeach
        </dl>
        @endif
      </li>
      @endforeach
    </div>
    <div class="right-nav">
      @if(\Auth::guard('member')->user())
      <li class="layui-nav-item">
        <a href="javascript:;"><img src="//t.cn/RCzsdCq" class="layui-nav-img">{{session('username')}}</a>
        <dl class="layui-nav-child">
          <dd><a href="javascript:;">我的主页</a></dd>
          <dd><a href="javascript:;">个人设置</a></dd>
          <dd><a href="/logout">退了</a></dd>
        </dl>
      </li>
      @else
      <li class="layui-nav-item">
        <a href="/login">登录</a>
      </li>
        <span> | </span>
      <li class="layui-nav-item">
        <a href="/register">注册</a>
      </li>
      @endif
    </div>
  </div>
</ul>