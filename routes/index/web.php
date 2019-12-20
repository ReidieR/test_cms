<?php
// 前台路由


Route::namespace('Index')->group(function () {
    Route::get('/', 'Home@index');    // 前台主页
    Route::get('/login', 'Account@login');   // 前台登录页
    Route::post('/dologin', 'Account@dologin');  // 登录表单提交验证
    Route::get('/register', 'Account@register');   // 前台注册页面
    Route::post('/doregister', 'Account@doregister');    // 注册
    Route::get('/list/{cate_id}', 'Lists@index');   // 列表頁
    Route::get('/detail/{aid}', 'Detail@index');     // 详情页面
    Route::get('/logout', 'Account@logout');     // 登出
});

Route::group(['namespace'=>'Index','middleware'=>'Member'], function () {
});
