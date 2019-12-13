<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Group as Groups;
use cms\Http\Models\Menu as Menus;
use DB;

class Group extends Controller
{
    // 角色列表
    public function index()
    {
        $data['group'] = Groups::all()->toArray();
        return view('admins.group.index', $data);
    }

    // 编辑角色
    public function edit(Request $req)
    {
        // 获取菜单并处理
        $menus = DB::table('final_admin_menus')->cates('mid');
        $menus = $this->getTreeMenu($menus);    // 获取树形菜单
        $result = [];
        // 将树形菜单转变为二级菜单
        foreach ($menus as $val) {
            // $children节点里的数组转为一维数组
            $val['children'] = isset($val['children']) ? $this->formatMenu($val['children']) : false;
            $result[] = $val;
        }
        $data['menu'] = $result;
        // 根据角色id获取角色权限
        $gid = (int) $req->gid;
        $rights = [];
        if ($gid) { // 修改角色权限
            // 获取角色权限
            $role = DB::table('final_admin_groups')->where('gid', $gid)->item();
            $data['title'] = $role['title'];
            $data['status'] = $role['status'];
            if ($gid != 1) {
                $rights = json_decode($role['rights'], true);
            } else {
                $rights = 'all';
            }
        }
        $data['gid'] =$gid;
        $data['rights'] = $rights;
        // dd($data);
        return view('admins.group.edit', $data);
    }

    // 角色保存
    public function save(Request $req)
    {
        $res = $req->all();
        $gid = (int)$req->gid;
        $data['title'] =  $res['title'];
        $data['status'] = $req->status;
        if ($data['title']=="") {
            return response()->json(array('code'=>1,'msg'=>'请输入角色名称'));
        }
        unset($res['status']);
        unset($res['gid']);
        unset($res['_token']);
        unset($res['url']);
        unset($res['method']);
        unset($res['ip']);
        unset($res['title']);
        $rights = array_values($res);   // array_values获取得的数组最后会有一个null值
        array_pop($rights);     // 用array_pop函数将null值移除数组
        $data['rights'] = json_encode($rights);
        $group = Groups::where('title', $data['title'])->first();
        // dd($data);
        if ($gid) {  //  修改权限
            if ($group && $group['gid'] != $gid) {
                return response()->json(array('code'=>1,'msg'=>'该菜单已存在'));
            }
            Groups::where('gid', $gid)->update($data);
        } else {
            if ($group) {
                return response()->json(array('code'=>1,'msg'=>'该菜单已存在'));
            }
            Groups::insert($data);
        }
        return response()->json(array('code'=>0,'msg'=>'保存成功'));
    }

    // 获取所有的菜单并将菜单转换为树形结构
    public function getTreeMenu($menus)
    {
        $menu = [];
        foreach ($menus as $val) {
            if ($val['pid']) {   // 判断菜单是否存在父级菜单
                // 存在的话在该菜单的父级菜单下添加children数组存放该菜单
                $menus[$val['pid']]['children'][] = &$menus[$val['mid']];
            } else {    // 不存在父级菜单将该菜单移动到空数组menu[]下
                $menu[] = &$menus[$val['mid']];
            }
        }
        return $menu;
    }

    // 将多维数组转变为一维数组
    public function formatMenu($menus, &$res = array())
    {
        foreach ($menus as $menu) {
            if (!isset($menu['children'])) {    // 判断是否存在子数组
                $res[] = $menu;     // 不存在直接复制给$res数组
            } else {    // 存在子数组
                $tem = $menu['children'];
                unset($menu['children']);    // 将子数组从该数组中移除
                $res[] = $menu;   // 把去掉字数的数组赋值给$res
                $this->formatMenu($tem, $res);   // 再次循环处理
            }
        }
        return $res;
    }
}
