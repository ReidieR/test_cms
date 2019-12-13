<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 后台登录
Route::get('admins/account/login', 'Admins\Account@login')->name('login');     // 登录视图
Route::post('admins/account/dologin', 'Admins\Account@dologin');   // 登录验证

// 后台页面路由
Route::group(['prefix'=>'admins','namespace'=>'Admins','middleware'=>['auth','rights']], function () {
    // 后台首页路由
    Route::get('home/index', 'Home@index');  // 后台首页
    Route::get('home/welcome', 'Home@welcome');    // 后台iframe欢迎页面
    Route::get('home/logout', 'Home@logout');    // 退出登录
    Route::get('home/admininfo', 'Home@adminInfo');     // 用户信息
    Route::post('home/changeinfo', 'Home@changeInfo');     // 修改用户信息
    Route::get('home/changepwd', 'Home@changepwd');     // 密码修改视图
    Route::post('home/savepwd', 'Home@savepwd');     // 密码修改保存

    // 扩展管理路由
    // 菜单管理
    Route::get('menu/index', 'Menu@index');      // 菜单列表
    Route::get('menu/edit', 'Menu@edit');        // 编辑菜单
    Route::post('menu/save', 'Menu@save');       // 保存菜单
    Route::post('menu/delete', 'Menu@delete');    // 删除菜单

    // 管理员管理菜单
    // 管理员管理
    Route::get('admin/index', 'Admin@index');        // 管理员列表
    Route::get('admin/edit', 'Admin@edit');         // 管理员编辑
    Route::post('admin/save', 'Admin@save');        // 管理员保存
    Route::post('admin/delete', 'Admin@delete');     // 管理员删除

    // 角色管理
    Route::get('group/index', 'Group@index');        // 角色列表
    Route::get('group/edit', 'Group@edit');          // 角色编辑
    Route::post('group/save', 'Group@save');         // 角色保存
    Route::post('group/delete', 'Group@delete');     // 角色删除
});
