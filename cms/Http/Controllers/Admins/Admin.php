<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Admin as Admins;
use DB;

class Admin extends Controller
{
    // 管理员列表
    public function index()
    {
        $admin = Admins::where('is_deleted', 1)->get()->toArray();
        foreach ($admin as $key => $val) {
            $group= DB::table('final_admin_groups')->where('gid', $val['group_id'])->item();
            // dd($group);
            $admin[$key]['group_title'] = $group['title'];
        }
        $data['admin'] = $admin;
        return view('admins.admin.index', $data);
    }

    // 编辑管理员视图
    public function edit(Request $req)
    {
        $id = (int)$req->id;
        $data['admin'] = DB::table('final_admins')->where('id', $id)->item();
        $data['group'] = DB::table('final_admin_groups')->lists();
        $data['id'] = $id;
        // dd($data);
        return view('admins.admin.edit', $data);
    }

    // 保存管理员
    public function save(Request $req)
    {
        // 获取用户输入的数据
        $data = $req->except(['uri','ip','_token','method']);
        $id = $data['id'];
        unset($data['id']);
        $data['updated_at'] = time();
        // 对用户输入的数据进行验证
        if ($id=="") {
            return response()->json(array('code'=>1,'msg'=>'请输入用户名'));
        }
        $res = Admins::where('username', $data['username'])->first();
        if ($id > 0) {   // 修改管理员
            if ($res && $id != $res->id) {
                return response()->json(array('code=>1','msg'=>'用户已存在'));
            }
            $data['password'] = (string)$data['password'];
            if ($data['password']) {    // 判断密码是否有值
                $data['password'] = \bcrypt($data['password']);
            }
            // dd($data);
            Admins::where('id', $id)->update($data);
        } else {    // 添加管理员
            if ($res) {
                return response()->json(array('code=>1','msg'=>'用户已存在'));
            }
            if (!$data['password']) {
                return response()->json(array('code'=>1,'msg'=>'请输入密码'));
            }
            $data['created_at']=time();
            $data['password'] = \bcrypt($data['password']);
            // dd($data);
            Admins::insert($data);
        }
        return response()->json(array('code'=>0,'msg'=>'保存成功'));
        dd($data);
    }

    // 删除管理员
    public function delete(Request $req)
    {
        // 软删除，将管理员禁用并隐藏
        $id = (int)$req->id;
        Admins::where('id', $id)->update(['is_deleted'=>2]);
        return response()->json(array('code'=>0,'msg'=>'删除成功'));
    }
}
