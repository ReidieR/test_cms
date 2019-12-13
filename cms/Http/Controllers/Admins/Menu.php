<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Menu as Menus;
use DB;

class Menu extends Controller
{
    //菜单列表视图
    public function index(Request $req)
    {
        $pid = (int)$req->pid;
        // 获取菜单
        $menus = DB::table('final_admin_menus')->where('pid', $pid)->cates('mid');
        $data['menu'] = $menus;
        $data['pid'] = $pid;
        return view('admins.menu.index', $data);
    }

    // 添加菜单和修改菜单视图
    public function edit(Request $req)
    {
        $mid = (int)$req->mid;  // 获取菜单id
        $pid = (int)$req->pid;  // 获取父级菜单id
        // 获取菜单信息
        $data['menu'] = DB::table('final_admin_menus')->where('mid', $mid)->item();
        $data['mid'] = $mid;
        // 获取父级菜单信息
        $pmenu = DB::table('final_admin_menus')->where('mid', $pid)->item();
        $data['pmenu'] = $pmenu['title'];   // 获取父级菜单标题
        $data['pid'] = $pid;
        return view('admins.menu.edit', $data);
    }

    // 保存菜单
    public function save(Request $req)
    {
        // 获取输入内容
        $data['title'] = (string)$req->title;
        $data['action'] = (string)$req->action;
        $data['controller'] = (string)$req->controller;
        $data['pid'] = (int)$req->pid;
        $data['status'] = (int)$req->status;
        $data['is_hidden'] = (int)$req->is_hidden;
        $mid = (int) $req->mid;
        $data['edited_at'] = time();
        $title = Menus::where('title', $data['title'])->first();
        if ($mid) { // 修改菜单
            if ($title && $title['mid'] != $mid) {
                return response()->json(array('code'=>1,'msg'=>'该菜单名称已存在'));
            }
    
            Menus::where('mid', $mid)->update($data);
        } else {  // 添加菜单
            if ($title) {
                return response()->json(array('code'=>1,'msg'=>'该菜单名称已存在'));
            }
            Menus::insert($data);
        }
        return response()->json(array('code'=>0,'msg'=>'保存成功'));
    }

    // 删除菜单
    public function delete(Request $req)
    {
        // 对菜单实行软删除：隐藏并禁用菜单
        $mid = (int)$req->mid;
        Menus::where('mid', $mid)->update(['status'=>2,'is_hidden'=>2]);
        return response()->json(array('code'=>0,'msg'=>'删除成功'));
    }
}
