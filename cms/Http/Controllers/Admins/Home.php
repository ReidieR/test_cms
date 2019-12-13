<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use DB;
use Auth;

class Home extends Controller
{
    // 后台首页
    public function index(Request $req)
    {
        // 设置菜单缓存
        $data['username'] = $req->admin->username;
        $filename = $data['username'].'abc';
        // dd(file_exists($filename));
        if (!file_exists($filename)) {  // 判断文件是否存在
            fopen($filename, "w");   // 创建一个可以写入的缓存文件
        }
        // 读取缓存的内容
        $res = file_get_contents($filename);
        if ($res == "") {    // 判断文件是否为空
            $menu = $this->getMenus($req);  // 文件为空，查询数据库
            file_put_contents($filename, json_encode($menu));  //将菜单写入数据库
        } else {
            $menu = json_decode($res, true);    // 有文件则直接读取
        }
        // dd($menu);
        // 将菜单转化成无限级菜单
        $menus = [];
        foreach ($menu as $val) {
            // dd($val);
            if (isset($menu[$val['pid']])) {   // 判断当前菜单是否存在父级菜单
                // 存在父级菜单,给对应的父级菜单添加子菜单
                $menu[$val['pid']]['children'][] = &$menu[$val['mid']];
            } else {
                // 不存在父级菜单,直接将该菜单添加到$menus空数组中
                $menus[] = &$menu[$val['mid']];
            }
        }
        $data['menus'] = $menus;
        return view('admins.home.index', $data);
    }
    // 根据用户获取菜单权限
    public function getMenus($req)
    {
        // 根据用户权限分配菜单
        // 获取用户信息
        $admin = $req -> admin;
        
        // 判断是否为超级管理员身份
        if ($admin->group_id==1) {     // 超级管理员直接拥有所有可显示的菜单
            return $menu = DB::table('final_admin_menus')->where('is_hidden', 1)->cates('mid');
        } else {
            $rights = $admin -> rights;   // 用户权限
            // dd($rights);
            // 根据用户权限读取菜单
            return $menu = DB::table('final_admin_menus')->where('is_hidden', 1)->whereIn('mid', $rights)->cates('mid');
        }
    }
    // iframe 欢迎页面
    public function welcome()
    {
        return view('admins.home.welcome');
    }

    // 退出登录
    public function logout()
    {
        Auth::logout();
        return \redirect('/admins/account/login');
    }

    // 用户资料视图
    public function adminInfo(Request $req)
    {
        $data['admin'] = Auth::user();
        return view('admins.home.admininfo', $data);
    }

    // 修改用户信息
    public function changeInfo(Request $req)
    {
        // 手机正则
        // $pattern = '/0?(13|14|15|17|18|19)[0-9]{9}/';
        // 表单验证
        $rules = [
            'username' => 'bail|required',
            'email' => 'bail|required|email',
            'mobile' => ['required','regex:/0?(13|14|15|17|18|19)[0-9]{9}/']
        ];
        $validated = $req->validate($rules);
        if ($validated) {
            $id = Auth::user()->id;
            DB::table('final_admins')->where('id', $id)->update($validated);
        }
        return redirect('/admins/home/admininfo');
    }

    // 修改密码视图
    public function changepwd()
    {
        echo 123;
    }

    // 保存密码修改
    public function savepwd()
    {
    }
}
