<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> title </title>
</head>
<style>
  #edit_container{
    margin-top:0;
    background-color: #fff;
  }
  #edit_container .layui-col-lg3{
      padding:10px;
      overflow-y: scroll;
      min-height:575px;
    }
  #edit_container .layui-col-lg3:hover{
    cursor:pointer;
  }
  #add_article span{
    font-size:18px;
  } 
  #edit_container .article-list {
    margin-top:10px;
  }
  #edit_container .article-list li{
  
    margin-top:5px;
    font-size: 16px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position:relative;
  }
  #edit_container .article-list li span:first-of-type{
    width: 100%; 
    white-space: nowrap;  
    overflow: hidden;
    text-overflow:ellipsis;
  }
  #edit_container .article-list li span:last-of-type{
    width:50px;
    margin: 2px 5px;
    align-self:flex-end;
    text-align: center;
    font-size: 12px;
    background:#eee;
    border-radius:10px;
  }
  #edit_container .article-list li:hover{
    background-color: aqua;
  }
  #edit_container .article-list li i {
    margin-right: 3px;
  }
  #edit_container .active {
    background-color: aqua;
  }
</style>
<body>
  {{-- 内容主体区域 --}}
  <div class="layui-container" id="edit_container">
    <div class="layui-row">
      {{-- 主体左侧侧固定内容区 --}}
      <div class="layui-col-lg3">
        <div id="add_article" onclick="newArticle()">
          <i class="layui-icon layui-icon-add-1"></i>
          <span>新建文章</span>
        </div>
        <ul class="article-list">
          @if(isset($article))
            @foreach ($article as $item)
              <li aid="{{$item['aid']}}" title="{{$item['title']}}" onclick="showArticle(this)">
                <span><i class="layui-icon layui-icon-read"></i>{{$item['title']}}</span>
                <span >{{$item['is_hidden']==1?'已发表':'未发表'}}</span>
              </li>
            @endforeach
          @endif()
        </ul>

      </div>
      {{-- 主体右侧侧内容展示区 --}}
      <form class="layui-col-lg9">
        <div class="layui-row">
          <form class="layui-form" >
            <div class="layui-form-item" style="padding-left: 40px;margin-top:10px;">
              <a href="/" class="layui-btn layui-btn-primary" value="回到首页">回到首页</a>
              <input type="button" class="layui-btn layui-btn-normal" onclick="saveArticle()" value="保存">
              <input type="button" class="layui-btn layui-btn-warm" onclick="articlePost()" value="发表">
              <span id="save_sign" style="float: right">已保存</span>
            </div>
            <div class="layui-form-item" style="margin-top: 20px;">
              <label class="layui-form-label">标题</label>
              <div class="layui-input-block">
                @csrf
                <input type="text" name="title" placeholder="请输入文章标题" autocomplete="off" class="layui-input">
              </div>
            </div>
          </form>
          <div class="layui-form-item" >
            <label class="layui-form-label">分类</label>
            <div class="layui-input-block" >
              <select name="cate_id" class="form-control" lay-filter="cates" >
                <option value="0">请选择</option>
                @foreach($cate as $item)
                  <option value="{{$item['art_cate_id']}}"
                  >{{$item['art_cate_title']}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="layui-form-item" style="padding-left: 40px;" id="article_content">
            <!-- 加载编辑器的容器 -->
            <script id="container" name="content" type="text/plain">     
            </script>         
          </div>
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
      initialFrameHeight:320,
      zIndex:0
    })
    ue.ready(function() {
      ue.execCommand('serverparam', '_token', '{{ csrf_token() }}') // 设置 CSRF token.
    })
    // layui组件
    layui.use(['element','form'],function(){
      let form = layui.form
      form.render()
      form.on('select(cates)',function(data){
        console.log(data.value)
      })
    })
    // 点击显示文章内容
    function showArticle(index) {
      let aid = $(index).attr('aid')  // 获取文章id
      $(index).siblings('li').removeClass('active').children('i').remove()   // 将其它li的激活状态取消
      $(index).addClass('active')   // 给自己添加激活状态
      $.get(`/edit/${aid}`,function(res){  // 发送获取数据请求
        let title = res.data.title   
        let content = res.data.content
        let cate_id = res.data.cate_id
        $('input[name="title"]').val(title)
        $('select[name="cate_id"]').val(cate_id)
        ue.ready(function() {
          ue.setContent(content)
        });
      },'json')
    }
    // 新建文章
    function newArticle(){  
        let i = `<i class="layui-icon layui-icon-delete" onclick="articleDelete(this)" style="position:absolute;top:0;right:0"></i>`
        let time = getFormatDateTwo()
        let li = `<li onclick="showArticle(this)">
                  <span><i class="layui-icon layui-icon-read"></i>${time}</span>
                  <span>未发表</span>
                  </li>`
        $('#edit_container ul').prepend(li)
        $('#edit_container ul li').removeClass('active').children('i').remove() 
        $('#edit_container ul li').first().addClass('active').prepend(i).hover(
          function(){
            if(($(this).children('i')).length == 0){  // 判断是否存在删除标志
              let i = `<i class="layui-icon layui-icon-delete" onclick="articleDelete(this)" style="position:absolute;top:0;right:0"></i>`
              $(this).prepend(i)
            }
          },
          function(){
            if(!$(this).hasClass('active')){   // 判断li标签是否激活
              $(this).children('i').eq(0).remove()
            }
          }
          )
      $('input[name="title"]').val(time)
      $('select[name="cate_id"]').val('0') 
      ue.setContent('')
    }
    // 标题改变的时候左侧显示栏变化
    $('input[name="title"]').keyup(function(){
      let title = $(this).val()
      let i = `<i class="layui-icon layui-icon-read"></i>`
      $('.article-list .active span').eq(0).text(title).prepend(i)
    })
    // 标题输入框失去焦点保存文章
    $('input[name="title"]').blur(function(){
        let i = `<i class="layui-icon layui-icon-loading" style="margin-right:5px"></i>`
        $('#save_sign').text('保存中').prepend(i)
        saveArticle()
      })
    // 当编辑区内容改变的时候，自动保存
    ue.ready(function() {
      ue.addListener('contentChange',function(){
          if (($('.article-list li').length !=0) ) {
            let content = ue.getContent()
            let descs = ue.getContentTxt().substr(0,142)
            let title = $('input[name="title"]').val()
            let cate_id = $('select[name="cate_id"]').val()
            let data = {
              title,
              content,
              descs,
              cate_id,
              _token:'{{csrf_token()}}'
            }
          let aid = ''
          if (typeof($('.article-list .active').attr('aid')) == "undefined") {  
            aid = ''
          }else{
            aid = $('.article-list .active').attr('aid')
          }
          let i = `<i class="layui-icon layui-icon-loading" style="margin-right:5px"></i>`
          $('#save_sign').text('保存中').prepend(i)
          $.post(`/edit/save?aid=${aid}`,data,res=>{
              if (res.code != 0) return false
              $('.article-list .active').attr('aid',res.data).attr('title',title)
              $('.article-list .active').on('showArticle')
              $('#save_sign').text('已保存')
            },'json')
          }
        }) 
    })
    // 点击按钮保存文章
    function saveArticle()
    {
      // 改变保存标志
      let i = `<i class="layui-icon layui-icon-loading" style="margin-right:5px"></i>`
      $('#save_sign').text('保存中').prepend(i)
      // 获取表单和ueditor中的内容
      let content = ue.getContent()
      let descs = ue.getContentTxt().substr(0,142)
      let title = $('input[name="title"]').val()
      let cate_id = $('select[name="cate_id"]').val()
      let data = {
        title,
        content,
        descs,
        cate_id,
        _token:'{{csrf_token()}}'
      }
      let aid = ''
      if (typeof($('.article-list .active').attr('aid')) == "undefined") {  
        aid = ''
        console.log(aid)
      }else{
        aid = $('.article-list .active').attr('aid')
      }
      $.post(`/edit/save?aid=${aid}`,data,res=>{
        if (res.code != 0) return layer.msg(res.msg)
        $('#save_sign').text('已保存')
      },'json')
    }
    // 发表文章
    function articlePost()
    {
      let aid = $('.article-list .active').attr('aid') 
      $.get(`/edit/post/${aid}`,res=>{
        if (res.code != 0) return layer.msg(res.msg)
        layer.msg(res.msg)
        setTimeout(() => {
          // 将发表标志改为已发表
          $('.article-list .active').children('span').eq(1).text('已发表')
        }, 1000)
      },'json')
    }
    // 删除图标显示
    $(function(){
      $('.article-list li').hover(
        function(){
          if(($(this).children('i')).length == 0){  // 判断是否存在删除标志
            let i = `<i class="layui-icon layui-icon-delete" onclick="articleDelete(this)" style="position:absolute;top:0;right:0"></i>`
            $(this).prepend(i)
          }
        },
        function(){
          if(!$(this).hasClass('active')){   // 判断li标签是否激活
            $(this).children('i').eq(0).remove()
          }
        }
      )
    })
    // 删除文章
    function articleDelete(index)
    {
      layer.confirm('您确定删除吗？', {
        icon:3,
        btn: ['确定','取消'] //按钮
      }, function(){
        let aid = $(index).parent('li').attr('aid')
        $.get(`/edit/delete/${aid}`, res=>{
          if (res.code != 0) return layer.msg(res.msg)
          layer.msg(res.msg)
          setTimeout(() => window.location.reload(), 1000)
        },'json')
      }, function(){
        layer.closeAll();
      });
      
    }
    // 初始页面展示
    $(document).ready(function(){
      if(($('.article-list li').length !=0 )){
        let i = `<i class="layui-icon layui-icon-delete" onclick="articleDelete(this)" style="position:absolute;top:0;right:0"></i>`
        $('.article-list li').eq(0).addClass('active').prepend(i)
        let aid = $('.article-list .active').attr('aid')
        $.get(`/edit/${aid}`,function(res){  // 发送获取数据请求
          let title = res.data.title   
          let content = res.data.content
          let cate_id = res.data.cate_id
          $('input[name="title"]').val(title) 
          $('select[name="cate_id"]').val(cate_id)
          ue.ready(function() {
            ue.setContent(content)
          });
        },'json')
      }
    })
  </script>
</body>
</html>