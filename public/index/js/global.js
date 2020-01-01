// 导航栏layui js 模块
layui.use('element', function() {
  let element = layui.element
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
// 收藏中心取消收藏
function memberConllectArticle(aid) {
  $.get(
    `/member/conllect/${aid}`,
    function(res) {
      if (res.code != 0) return layer.msg(res.msg, { icon: 2 })
      layer.msg(res.msg, { icon: 1 })
      setTimeout(() => {})
    },
    'json'
  )
}

// 获取当前时间并且格式化1Y-m-d H:m:s
function getFormatDateOne() {
  let nowDate = new Date()
  let year = nowDate.getFullYear()
  let month =
    nowDate.getMonth() + 1 < 10
      ? '0' + (nowDate.getMonth() + 1)
      : nowDate.getMonth() + 1
  let date =
    nowDate.getDate() < 10 ? '0' + nowDate.getDate() : nowDate.getDate()
  let hour =
    nowDate.getHours() < 10 ? '0' + nowDate.getHours() : nowDate.getHours()
  let minute =
    nowDate.getMinutes() < 10
      ? '0' + nowDate.getMinutes()
      : nowDate.getMinutes()
  let second =
    nowDate.getSeconds() < 10
      ? '0' + nowDate.getSeconds()
      : nowDate.getSeconds()
  return `${year}-${month}-${date} ${hour}:${minute}:${second}`
}

// 获取当前时间并且格式化2Y-m-d
function getFormatDateTwo() {
  let nowDate = new Date()
  let year = nowDate.getFullYear()
  let month =
    nowDate.getMonth() + 1 < 10
      ? '0' + (nowDate.getMonth() + 1)
      : nowDate.getMonth() + 1
  let date =
    nowDate.getDate() < 10 ? '0' + nowDate.getDate() : nowDate.getDate()

  return `${year}-${month}-${date}`
}

// 关闭消息提示框
$(function() {
  $('.close-message-box').on('click', function() {
    $(this)
      .parent('div')
      .remove()
  })
})
