// 导航栏layui js 模块
layui.use('element', function() {
  var element = layui.element
})

// 登录时点击收藏
function collectArticle(index, aid) {
  $.get(
    `/member/conllect/${aid}`,
    function(res) {
      if (res.code != 0) return false
      if (
        $(index)
          .children('i')
          .hasClass('layui-icon-star-fill')
      ) {
        let i = `<i class="layui-icon layui-icon-star" style="margin-left:14px"></i>`
        $(index)
          .text('点击收藏')
          .append(i)
      } else {
        let i = `<i class="layui-icon layui-icon-star-fill" style="margin-left:14px"></i>`
        $(index)
          .text('已收藏')
          .append(i)
      }
    },
    'json'
  )
}

// 未登录时点击收藏
function conllectToLogin() {
  layer.confirm(
    '登录后才能进行该操作',
    {
      title: '友情提示',
      btn: ['确定', '取消'] //按钮
    },
    function() {
      window.location.href = '/login'
    },
    function() {
      layer.closeAll()
    }
  )
}
// 个人中心页面js
function contentSwith(index) {
  let con_ac = $(index).attr('con_ac')
  let url = `/index/user/${con_ac}`
  $('iframe').attr('src', url)
}
