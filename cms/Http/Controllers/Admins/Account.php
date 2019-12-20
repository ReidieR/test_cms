<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use Auth;
use DB;

class Account extends Controller
{
    // 登录页视图
    public function login()
    {
        return view('admins.account.login');
    }

    // 登录验证
    public function dologin(Request $req)
    {
    
        // 对表单输入行为进行验证
        $data = $req->all();
        unset($data['_token']);
        if (!$data['username']) {    // 用户名输入验证
            return response()->json(array('code'=>1,'msg'=>'用户不能为空'));
        }
        if (!$data['password']) {    // 密码输入验证
            return response()->json(array('code'=>1,'msg'=>'密码不能为空'));
        }
        // 验证码验证
        $rules = ['captcha' => 'required|captcha'];
        $validator = validator()->make(['captcha'=>$req->captcha], $rules);
        if ($validator->fails()) {
            return response()->json(array('code'=>1,'msg'=>'验证码错误'));
        }
        // 表单验证
        // $rules = [
        //     'username' => 'required',
        //     'password' => 'required',
        //     'verify_code' => 'required|captcha'
        // ];
        // $validator = validator()->make($data, $rules);
        // if ($validator->fails()) {
        //     $errors = validator()->withErrors($validator);
        //     dd($errors);
        //     return response()->json(array('code'=>1,'msg'=>'验证码错误'));
        // }
        // 使用中间件对用户的输入信息进行验证
        $res = Auth::attempt(['username'=>$data['username'],'password'=>$data['password'],'status'=>1]);
        if (!$res) {
            return response()->json(array('code'=>1,'msg'=>'用户名或密码错误'));
        }
        $user = Auth::user();
        return response()->json(array('code'=>0,'msg'=>'登录成功'));
    }
}
