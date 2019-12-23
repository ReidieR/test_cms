// 登录页js
// 点击刷新验证码
function reload_captcha() {
  let src = $('#capcha_code').attr('src') + Math.random()
  $('#capcha_code').attr('src', src)
}

// 登录跳转
function dologin() {
  let username = $('input[name="username"]').val()
  let password = $('input[name="password"]').val()
  let captcha = $('input[name="captcha"]').val()
  // 刷新验证码
  reload_captcha()
  // 验证用户名
  if (username == '' || username == null)
    return layer.alert('用户名不能为空', { title: '错误提示', icon: 2 })
  // 验证密码
  if (password == '' || password == null)
    return layer.alert('密码不能为空', { title: '错误提示', icon: 2 })
  // 验证验证码
  if (captcha == '' || captcha == null)
    return layer.alert('请输入验证码', { title: '错误提示', icon: 2 })
  // 获取整个表单的数据
  let data = $('form').serialize()
  // 发送登录请求
  $.post(
    '/admins/account/dologin',
    data,
    function(res) {
      // 根据返回的数据进行判断
      if (res.code != 0) {
        return layer.msg(res.msg, { title: '错误提示', icon: 2 })
      } // 登录失败
      layer.msg(res.msg, { icon: 1 })
      setTimeout(() => (window.location.href = '/admins/home/index'), 1000) // 登录成功跳转到后台
    },
    'json'
  )
}

// 点击回车登录
function enter() {
  let keyCode = event.keyCode
  if (keyCode == 13) return dologin()
}

// 后台公共区域js顶部和侧边导航栏
// 顶部导航
// 显示菜单
function showAdminList() {
  $('#top_li').addClass('layui-nav-itemed')
}
// 隐藏菜单
function hiddenAdminList() {
  $('#top_li').removeClass('layui-nav-itemed')
}

// 侧边导航
// 设置侧边导航栏的默认高度
$(function() {
  // 初始化侧边导航栏高度
  let height = window.innerHeight
  let nav_height = height - 70
  $('#left_nav')
    .height(nav_height)
    .css('backgound', '#393D49')
  // 一级菜单点击事件
  $('#left_nav li a').click(function() {
    // 移除其他顶级菜单的active类
    $(this)
      .parent()
      .siblings()
      .removeClass('layui-nav-itemed')
    // 给自己添加active类
    if (
      $(this)
        .parent()
        .hasClass('layui-nav-itemed')
    ) {
      return $(this)
        .parent()
        .removeClass('layui-nav-itemed')
    }
    $(this)
      .parent()
      .addClass('layui-nav-itemed')
  })
  // 子菜单点击事件
  $('.layui-nav-child a').click(function() {
    // 改变iframe的src属性
    let controller = $(this).attr('controller')
    let action = $(this).attr('action')
    let src = `/admins/${controller}/${action}`
    $('iframe').attr('src', src)
  })
})

// 菜单管理页面的js
function childMenu(mid) {
  window.location.href = `?pid=${mid}`
  console.log(mid)
}
