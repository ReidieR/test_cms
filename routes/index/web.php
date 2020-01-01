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
    // 个人中心页面
    Route::get('/member', 'Member@index');       // 個人中心
    Route::get('/member/info', 'Member@info');  // 个人资料
    Route::post('/member/avator', 'Image@upload');  // 头像上传
    Route::post('/member/{user_id}/save', 'Member@saveUser');  // 个人资料保存
    Route::get('/member/page', 'Member@page');       // 个人文章
    Route::get('/article/edit/{aid}', 'Member@editArticle');    //  文章修改
    Route::post('/member/save', 'Member@editArticle');     // 文章修改保存
    Route::get('/conllect', 'Member@conllectArticle');   // 收藏文章页面
    // 文章编辑页面路由
    Route::get('/edit', 'Edit@index');             // 文章编辑页面显示
    Route::get('/edit/{aid}', 'Edit@article');     // 显示文章内容
    Route::post('/edit/save', 'Edit@save');        // 保存文章
    Route::get('/edit/post/{aid}', 'Edit@post');         // 文章发表
    Route::get('/edit/delete/{aid}', 'Edit@delete');   // 删除文章
    // 收藏页面
    // Route::get('/conllect', 'Member@conllectArticle');   // 收藏文章页面
    Route::get('/member/conllect/{aid}', 'Member@conllect');     // 收藏或者取消收藏文章
});
