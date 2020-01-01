<!DOCTYPE html>
<html lang="en">
<head>
@include('index.public.link')
<title> 个人中心 </title>
<style>
  #pageModal{
    margin-top:30px;
    height:100%;
  }
  #user_avator{
    display: flex;
    align-items: center;
  }
</style>
</head>
<body>
{{-- 顶部导航区 --}}
@include('index.public.header')
{{-- 内容主体区域 --}}
<div class="layui-container" style="min-height:550px;">
  <div class="layui-row" id="app">
    {{-- 主体左侧固定内容区 --}}
    <div class="layui-col-lg2">
      <div class="layui-row">
        <div class="layui-card">
          <div class="layui-card-header">个人中心</div>
          <div class="layui-card-body">
            <ul id="user_center_nav">
              <li><a @click.prevent="comName='memberInfo'" con_ac="user_info">个人信息</a></li>
              <li><a @click.prevent="comName='memberPage'" con_ac="user_index">我的主页</a></li>
              <li><a @click.prevent="comName='memberConllect'" con_ac="user_conllect">我的收藏</a></li>
              <li><a href="/edit">写文章</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    {{-- 主体右侧内容展示区 --}}  
    <div class="layui-col-lg10">
      <component :is="comName" :parent-data="userData" @func="changeData">
      </component>
    </div>
  </div>
  @include('index.member.info')  
  @include('index.member.page') 
  @include('index.member.conllect') 

</div>
{{-- 底部固定区 --}}
@include('index.public.footer')
@include('vendor.ueditor.assets')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
{{-- webuploader 文件上传插件引入 --}}
<script src="/webuploader-0.1.5/webuploader.css"></script>
<script src="/webuploader-0.1.5/webuploader.min.js"></script>
<script>
  // 个人资料组件
  Vue.component('memberInfo',{
    template:'#infotmp',
    props:['parentData'],
    data(){
      return {
        selfData:''
      }
    },
    methods:{
      // 表单提交验证
      checkForm(){
        let username = this.selfData.username
        let email = this.selfData.email
        let mobile = this.selfData.mobile
        let avator = this.selfData.avator
        if (username == '') {
          return '用户名不能为空'
        }
        let emailPatt = '/\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}/'
        if (!email.match(emailPatt)) {
          return '请输入正确的邮箱'
        }
        let mobilePat = '/0?(13|14|15|17|18|19)[0-9]{9}/'
        if (!mobile.match(mobilePat)) {
          return '请输入正确的电话'
        }
      }
    },
    mounted(){
      // webuploader头像上传
      jQuery(function() {
        var $ = jQuery,
        $list = $('#fileList'),
        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,
        // 缩略图大小
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,
        // Web Uploader实例
        uploader

        // 初始化Web Uploader
        uploader = WebUploader.create({
          // 自定义的数据
          formData: {
            _token:'{{csrf_token()}}'
          },
          // 自动上传。
          auto: true,

          // swf文件路径
          swf: '/webuploader-0.1.5/Uploader.swf',

          // 文件接收服务端。
          server: '/member/avator ',

          // 选择文件的按钮。可选。
          // 内部根据当前运行是创建，可能是input元素，也可能是flash.
          pick: '#filePicker',

          // 只允许选择文件，可选。
          accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
          }
        })

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on('uploadSuccess', function(file,res) {
          $('img[name="avator"]').attr('src',res.src)
          $('input[name="avator"]').val(res.src)
        })

        // 文件上传失败，现实上传出错。
        uploader.on('uploadError', function(file) {
          var $li = $('#' + file.id),
            $error = $li.find('div.error')

          // 避免重复创建
          if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li)
          }

          $error.text('上传失败')
        })

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on('uploadComplete', function(file) {
          $('#' + file.id)
            .find('.progress')
            .remove()
        })
      })

    },
    //  watch很重要。data（）函数只是在初始化的时候会运行一次。
    // 所以总是空。而我们异步过来的数据，需要watch他 才能得到。
    watch:{
      parentData:function(newVal,oldVal){
        this.selfData = newVal
      }
    },
  })
  // 个人文章组件
  Vue.component('memberPage',{
    template:'#pagetmp',
    data(){
      return {
        // 编辑文章数据
        articleData:'',
        // 更改后的文章数据
        chidUserData:'',
        
      }
    },
    props:['parentData'],
    methods:{
      // 文章编辑
      articleEdit(aid){
        // 获取文章数据
        this.$http.get(`/article/edit/${aid}`).then(function(res){     
          if(res.data.code !=0) return false
          this.articleData = res.data.data
            // 百度富文本编辑器实例化
          let ue = UE.getEditor('container',{
            initialFrameHeight:200,
            initialFrameWidth: '100%',
          })
          ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}') // 设置 CSRF token.
            ue.setContent(res.data.data.content)
          })
        },function(){
          return false
        })
      },
      // 获取子组件值改变
      dataChange(val){
        this.chidUserData = val
      }
    },
    watch:{
      chidUserData:function(){
        this.$emit('func',this.chidUserData)
      }
    },
   
    components:{
      comedit:{
        template:'#pageChildren',
        props:['articleData'],
        data:function(){
          return {
            childData:'',
            flag:''
          }
        },
        methods: {
          // 保存编辑文章
          articleSave(aid){
            let title = this.articleData.title
            let cate_id = this.$refs.select.value
            let ue = UE.getEditor('container')
            let _token = this.$refs._token.value
            let descs = ue.getContentTxt().substr(0,142)
            let content = ue.getContent()
            data = {title,cate_id,descs,content,_token}
            this.$http.post(`/edit/save?aid=${aid}`,data).then(function(res){
              if(res.data.code != 0) return false
              this.$http.get('/member/page').then(function(res){
                this.childData = res.data.data
                this.$emit('childfun',this.childData)
                $('#pageModal').modal('hide');//隐藏modal
                $('.modal-backdrop').remove();//去掉遮罩层
              },function(){
                return false
              })
            },function(){
              return false
            })
          }
        },
        mounted(){
          this.flag = true
        },
        watch:{
          flag:function(){
            if(this.flag){
              UE.getEditor('container').destroy()
              $('#container').remove()
              let html = `<script id="container" name="content" type="text/plain"><\/script> `
              $('#articleEditor').append(html)
            }
          }
        }
      }
    }
  })
  // 个人收藏组件
  Vue.component('memberConllect', {
    template:'#conllecttmp',
    data:function(){
      return {
        chidUserData:''
      }
    },
    props:['parentData'],
    methods:{
      // 取消收藏
      cancelCollection(aid){
        this.$http.get(`/member/conllect/${aid}`).then(function(res){
          if(res.data.code != 0) return false
          // 取消收藏成功后重新发起请求获取获取收藏文章的数据
            this.$http.get('/conllect').then(function(res){
              // 修改收藏文章数据
              this.chidUserData = res.data.data
              // 将收藏文章数据传递给父组件
              this.$emit('func',this.chidUserData)
            }),function(){
              return false
            }
          },function(){
              return false
          })
        }
      },  
  })
  var vm = new Vue(
    {
      el:'#app',
      data: {
        comName: 'memberInfo',
        userData:''
      },
      methods:{
        getData(){
          let url = ''
          // 判断请求的组件
          if (this.comName ==  'memberInfo') {  // 用户信息
            url = '/member/info'
          }
          if (this.comName == 'memberPage') {  // 用户主页
            url = '/member/page'
          }
          if (this.comName == 'memberConllect') {     // 收藏文章
            url = '/conllect'
          }
          this.userData=''
          //发送get请求
          this.$http.get(url).then(function(res){
            if((res.data.data).length != 0){
              this.userData = res.data.data
            }else {
              this.userData = ''
            }
          },function(){
              return false
          })
        },
        // 接收子组件传递过来的数据
        changeData(val){
          this.userData = val
        }
      },
      created(){
        this.getData()
      },
      watch:{
        comName:function(){
          this.getData()
        },
        // userData(){
        //   console.log(this.userData)
        // }
      }
    }
  )
</script>
</body>
</html>
