<!DOCTYPE html>
<html lang="en">
<head>
  @include('admins.public.link')
  <title>后台管理系统</title>
</head>
<body>
  <div class="layui-fluid">
      <!--顶部固定区  -->
      <div class="top-box">
        <ul class="layui-nav">
          <li class="layui-nav-item">
            <a href="javascript:;" id="top_title">cms后台管理系统</a>
          </li>
          <li class="layui-nav-item" id="top_li"  onmouseout="hiddenAdminList()">
            <a href="javascript:;" onmouseover="showAdminList()"><img src="//t.cn/RCzsdCq" class="layui-nav-img">{{$username}}</a>
            <dl class="layui-nav-child" onmouseover="showAdminList()">
              <dd><a href="javascript:;" controller="home" action="admininfo">个人资料</a></dd>
              <dd><a href="javascript:;" controller="home" action="changepwd">修改密码</a></dd>
              <dd><a href="/admins/home/logout">退出登录</a></dd>
            </dl>
          </li>
        </ul>
      </div>
      <!-- 底部 -->
      <div class="layer-row layui-col-space10"id="container">
        <!-- 左边导航 -->
        <div class="layui-col-xs3 layui-col-sm3 layui-col-md2"style="margin-right: 10px;" >
          <ul class="layui-nav layui-nav-tree layui-inline" id="left_nav" style="width:100%;">
          @foreach($menus as $item)
          <li class="layui-nav-item">
              <a href="javascript:;">{{$item['title']}}</a>
              <dl class="layui-nav-child" name="left_nav_dl">
                @if(isset($item['children']))
                  @foreach($item['children'] as $chd)
                  <dd><a href="javascript:;"
                        controller={{$chd['controller']}}
                        action={{$chd['action']}}>{{$chd['title']}}</a></dd>
                  @endforeach
                @endif
              </dl>
          </li>
          @endforeach
          </ul>
        </div>
        <!-- 右边iframe -->
        <div id="iframe_box" class="layui-col-xs9 layui-col-sm9 layui-col-md10">
          <iframe src="/admins/home/welcome" style="height:100%;width:100%;padding:20px" frameborder="0"></iframe>
        </div>
      </div>
  </div>
</body>
</html>