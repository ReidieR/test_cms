<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 文章编辑 </title>
</head>
<style>
  #essay_container{
    padding-right:10px;
    min-width:900px;
  }
  #essay_container form{
    margin-top:30px;
    margin-bottom: 30px;
  }
  #essay_container form label{
    width:100px;
  }
  #essay_container #ueditor_box {
    padding-left: 20px;
  }
  #bigger_img {
    display:none;
    position:absolute;
    height:100px;
  }
</style>
<body>
  <div class="layer-fluid" id="essay_container">
    <div class="layui-row">
      <div class="layui-col-sm12 layui-col-md4 layui-col-lg4">
        <form class="layui-form" lay-filter="essay_form" id="essay_form">
        <input type="hidden" name="aid" value="{{$aid}}">
          <div class="layui-form-item">
            <label class="layui-form-label">文章标题</label>
            <div class="layui-input-block">
            <input type="text" name="title" value="{{$essay['title']}}" placeholder="请输入文章标题" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            @csrf
            <label class="layui-form-label">封面图</label>
            <div class="layui-input-block">
              <button type="button" name="img_cover" class="layui-btn layui-btn-danger" id="img_cover"><i class="layui-icon"></i>上传图片</button>
            <img src="{{$essay['cover_img']}}" id="pre_img" alt="" onmouseout="imgclose()" onmouseover="enlargeImg()" style="height: 30px;margin-left:5px">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">文章分类</label>
            <div class="layui-input-block">
             <select name="cate_id" id="" lay-filter="cate">
              <option value="0">请选择</option>
              @foreach ($cate as $item)
                <optgroup label="{{$item['art_cate_title']}}">
                  @if(isset($item['chd']))
                  @foreach ($item['chd'] as $chd)
                  <option value="{{$chd['art_cate_id']}}" {{isset($essay['cate_id']) && $essay['cate_id'] == $chd['art_cate_id'] ? 'selected':''}} >{{$chd['art_cate_title']}}</option>
                  @endforeach
                  @endif
                </optgroup>
              @endforeach
             </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">副标题</label>
            <div class="layui-input-block">
              <input type="text" name="subtitle" value="{{$essay['subtitle']}}" placeholder="请输入文章副标题" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">关键词</label>
            <div class="layui-input-block">
              <input type="text" name="keywords" value="{{$essay['keywords']}}" placeholder="请输入文章关键题" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">作者</label>
            <div class="layui-input-block">
              <input type="text" name="author" value="{{$essay['author']}}" placeholder="请输入文章作者" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">来源</label>
            <div class="layui-input-block">
              <input type="text" name="from_url" value="{{$essay['from_url']}}" placeholder="请输入文章来源" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
              <input type="checkbox" name="status" {{isset($essay['status']) && $essay['status']==2?'' : 'checked'}} value={{isset($essay['status'])? $essay['status'] : 1}} lay-filter="status" lay-skin="switch" lay-text="正常|禁用">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">是否私有</label>
            <div class="layui-input-block">
              <input type="checkbox" name="is_hidden" {{isset($essay['is_hidden']) && $essay['is_hidden']==2?'' : 'checked'}} value={{$essay['is_hidden'] ? $essay['is_hidden'] : 1}} lay-filter="is_hidden" lay-skin="switch" lay-text="公开|私有">
            </div>
          </div>
          <div class="layui-form-item">
            <div class="layui-input-block">
              <button type="reset" class="layui-btn">重置</button>
            </div>
          </div>
        </form>
      </div>
      <div class="layui-col-sm12 layui-col-md8 layui-col-lg8" id="ueditor_box">
        <form id="content">
          @csrf
          <!-- 加载编辑器的容器 -->
          <script id="container" name="content" type="text/plain">
            {!!$content['content']!!}
          </script>
        </form>
      </div>
    </div>
    <div class="layui-input-block">
      <button type="button" onclick="essaySave(essay_form)" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
      <button type="reset" class="layui-btn layui-btn-warm">取消</button>
    </div>
  </div>
  <img src="" id="bigger_img">
  <script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
  <script type="text/javascript" src="/static/ueditor/ueditor.all.js"></script>
  <script>
    // 百度富文本编辑器实例化
    let height = $('form').height()
    let ue = UE.getEditor('container',{
      autoHeightEnabled: true,
      autoFloatEnabled: true,
      initialFrameHeight:400
    })
    let data =''
    // 加载luyui模块
    layui.use(['form','upload'], function(){
      let form = layui.form
      let upload = layui.upload
      form.render()
      form.on('switch(status)',function(data){
        // 设置switch开关的value，开为1，关为2
        $('input[name="status"]').val(this.checked?1:2)
      })
      form.on('switch(is_hidden)',function(data){
        // 设置switch开关的value，开为1，关为2
        $('input[name="is_hidden"]').val(this.checked?1:2)
      })
     // 文件上传 
      upload.render({
        elem: '#img_cover'
        ,url: '/admins/image/upload'
        ,size: 1024 //限制文件大小，单位 KB
        ,method:'post'
        ,data:{
          _token:$('input[name="_token"]').val()
        }
        ,done: function(res){
          layer.msg(res.msg,{icon:1})
          $('#pre_img').attr('src',res.data.src)
        }
        ,error: function(res){
          layer.msg('上传出错',{icon:2})
        }
      })
    })
    // 文章保存
    function essaySave(){
      let img_url = $('#pre_img').attr('src')
      let aid = $('input[name="aid"]').val()
      let data = $('#essay_form').serialize()
           + '&' + $('#content').serialize()
           + '&cover_img=' + img_url 
           + '&aid=' + aid
      $.post(
        '/admins/essay/save',
        data,
        res => {
          if (res.code>0) return layer.alert(res.msg,{icon:2})
          layer.msg(res.msg,{icon:1})
          setTimeout(() => parent.window.location.reload(), 1000)
        },
        'json'
      )
    }

    // 取消编辑
    function cancle(){
      layer.closeAll()       
    }

    // 获取鼠标位坐标
    function getMousePos(){
       var e = event || window.event;
       var scrollX = document.documentElement.scrollLeft || document.body.scrollLeft;
       var scrollY = document.documentElement.scrollTop || document.body.scrollTop;
       var x = e.pageX || e.clientX + scrollX;
       var y = e.pageY || e.clientY + scrollY;
       return { 'x': x, 'y': y };
    }

    // 放大预览图片
    function enlargeImg(){
      // 获取鼠标的位置
      let pos = getMousePos();
      console.log(pos);
      let src = $('#pre_img').attr('src')
      $('#bigger_img').attr('src',src)
      .css('display','block').css('top',pos.y).css('left',pos.x)
    }
    // 放大图片消失
    function imgclose(){
      $('#bigger_img').css('display','none').attr('src','')
    }
  </script>
</body>
</html>