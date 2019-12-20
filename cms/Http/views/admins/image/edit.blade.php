<!DOCTYPE html>
<html lang="en">
<head>
@include('admins.public.link')
<title> 图片编辑 </title>
</head>
<style>
  #image_container{
    padding-right:10px;
    min-width:900px;
  }
  #image_container form{
    margin-top:30px;
    margin-bottom: 30px;
  }
  #image_container form label{
    width:100px;
  }
  #image_container #ueditor_box {
    padding-left: 20px;
  }
  #bigger_img {
    display:none;
    position:absolute;
    height:100px;
  }
</style>
<body>
  <div class="layer-fluid" id="image_container">
    <div class="layui-row">
      <div class="layui-col-sm12 layui-col-md4 layui-col-lg4">
        <form class="layui-form" lay-filter="image_form" id="image_form">
          <input type="hidden" name="img_id" value="{{$img_id}}">
          <div class="layui-form-item">
            <label class="layui-form-label">图片标题</label>
            <div class="layui-input-block">
            <input type="text" name="title" value="{{$image['title']}}" placeholder="请输入图片标题" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            @csrf
            <label class="layui-form-label">图片上传</label>
            <div class="layui-input-block">
              <button type="button" name="img_url" class="layui-btn layui-btn-danger" id="img_cover"><i class="layui-icon"></i>上传图片</button>
            <img src="{{$image['img_url']}}" id="pre_img" alt="" onmouseout="imgclose()" onmouseover="enlargeImg()" style="height: 30px;margin-left:5px">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
              <input type="checkbox" name="status" {{isset($image['status']) && $image['status']==2?'' : 'checked'}} value={{isset($image['status'])? $image['status'] : 1}} lay-filter="status" lay-skin="switch" lay-text="正常|禁用">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">是否私有</label>
            <div class="layui-input-block">
              <input type="checkbox" name="is_hidden" {{isset($image['is_hidden']) && $image['is_hidden']==2?'' : 'checked'}} value={{$image['is_hidden'] ? $image['is_hidden'] : 1}} lay-filter="is_hidden" lay-skin="switch" lay-text="公开|私有">
            </div>
          </div>
        </form>
      </div>
      <div class="layui-col-sm12 layui-col-md8 layui-col-lg8" id="ueditor_box">
        <form id="content">
          @csrf
          <div class="layui-upload">
            <button type="button" class="layui-btn" id="test2">多图上传</button> 
            <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
              预览图：
              <div class="layui-upload-list" id="demo2"></div>
           </blockquote>
          </div>
        </form>
      </div>
    </div>
    <div class="layui-input-block">
      <button type="button" onclick="imageSave(image_form)" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
      <button type="reset" class="layui-btn layui-btn-warm">取消</button>
    </div>
  </div>
  <img src="" id="bigger_img">
  <script type="text/javascript" src="/static/ueditor/ueditor.config.js"></script>
  <script type="text/javascript" src="/static/ueditor/ueditor.all.js"></script>
  <script>
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
     // 单图上传 
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
      // 多图上传
      upload.render({
        elem: '#test2'
        ,url: '/admins/image/upload'
        ,method:'post'
        ,data: {
          _token:'{{csrf_token()}}'
        }
        ,multiple: true
        ,before: function(obj){
          //预读本地文件示例，不支持ie8
          obj.preview(function(index, file, result){
            $('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
          });
        }
        ,done: function(res){
          //上传完毕
        }
      });
    })
    // 图片保存
    function imageSave(){
      let img_id = $()
      let img_url = $('#pre_img').attr('src')
      let data = $('#image_form').serialize()
           + '&' + $('#content').serialize()
           + '&img_url=' + img_url 
      $.post(
        '/admins/image/save',
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