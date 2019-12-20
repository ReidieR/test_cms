<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Member as Members;
use DB;

class Member extends Controller
{
    // 用户列表视图
    public function index()
    {
        $res = Members::paginate(10);
        $result = $res->toArray();
        // $data = DB::table('final_users')->lists();
        // dd($data['links']);
        $user = $result['data'];
        foreach ($user as $key => $item) {
            if ($item['gender'] == 1) {
                $user[$key]['gender'] = '男';
            }
            if ($item['gender'] == 2) {
                $user[$key]['gender'] = '女';
            }
            if ($item['gender'] == 3) {
                $user[$key]['gender'] = '保密';
            }
        }
        $data['links'] = $res->links();
        $data['result']= $user;
        // dd($data);
        return view('admins.member.index', $data);
    }

    // 编辑用户视图
    public function edit(Request $req)
    {
        $user_id = (int)$req->user_id;
        if (!$user_id) {
            $data['member'] = false;
        } else {
            $data['member'] = Members::where('user_id', $user_id)->first();
        }
        $data['user_id'] = $user_id;
        return view('admins.member.edit', $data);
    }

    // 保存用户
    public function save(Request $req)
    {
        // 获取表单数据
        $data = $req->all();
        $id = (int)$req->user_id;
        unset($data['user_id']);
        unset($data['_token']);
        unset($data['username']);
        unset($data['mobile']);
        // dd($data);
        // 表单数据验证
        // 定义验证规则
        $rules = [
            'username' => 'bail|required',
            'mobile' => 'bail|required',
            'email' => 'bail|required'
        ];
        if (!$id) {
            $rules['password'] = 'required';
        }
        // 验证
        $validator = \Validator::make($data, $rules);
        // 判断验证结果
        if ($validator->fails()) {  // 验证失败
            $err = $validator->errors()->all();     // 获取验证结果
            $res=implode(',', $err);        // 验证结果的数组转化为字符串
            return response()->json(['code'=>1,'msg'=>$res]);
        }
        $user = Members::where('username', $data['username'])->first();
        // 2、保存表单数据
        $data['updated_at'] = time();
        if ($id) {  // 修改用户
            if ($user && $user->user_id != $id) {
                return reponse()->json(['code'=>1,'msg'=>'该用户已存在']);
            }
            $data['password'] = (string)$data['password'];
            if ($data['password']) {
                $data['password'] = \bcrypt($data['password']);
            }
            $res = Members::where('user_id', $id)->update($data);
        } else {     // 添加用户
            if ($user) {
                return reponse()->json(['code'=>1,'msg'=>'该用户已存在']);
            }
            $data['password'] = \bcrypt($data['password']);
            $data['created_at'] = time();
            $res = Members::insert($data);
        }
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'保存失败']);
        }
    }

    // 删除用户
    public function delete(Request $req)
    {
        $uer_id = (int)$req->user_id;
        // 将用户表中的该用户的删除状态改为已删除
        $res = Members::where('user_id', $user_id)->update(['is_delete'=>'2']);
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'保存失败']);
        }
    }
}
