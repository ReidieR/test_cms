<?php
// 前台路由

Route::namespace('Index')->group(function () {
    Route::get('/', 'Home@index');    // 前台主页
    Route::get('/login', 'Account@login');   // 前台登录页
    Route::post('/dologin', 'Account@dologin');  // 登录表单提交验证
    Route::get('/register', 'Account@register');   // 前台注册页面
    Route::post('/doregister', 'Account@doregister');    // 注册
    Route::get('/list/{cate_id}', 'Lists@index');   // 列表頁
    // Route::post('/list/paginate', 'Lists@paginate');    // 列表分页
    Route::get('/detail/{aid}', 'Detail@index');     // 详情页面
    Route::get('/logout', 'Account@logout');     // 登出
});

Route::group(['namespace'=>'Index','middleware'=>'member'], function () {
    Route::get('/member', 'Member@index');       // 個人中心
    Route::get('/member/info', 'Member@info');  // 个人资料
    Route::get('/edit', 'Edit@index');           // 文章编辑页面
    Route::get('/member/conllect/{aid}', 'Member@conllect');     // 收藏或者取消收藏文章
});
