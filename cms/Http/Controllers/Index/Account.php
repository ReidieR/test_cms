<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use Validator;
use Auth;
use DB;
use cms\Member;

class Account extends Controller
{
    
    // 登錄頁面
    public function login()
    {
        return view('index.account.login');
    }
    // 登录验证
    public function dologin(Request $req)
    {
        // 判断表单提交方式
        if ($req->ajax()) {
            return redirect('/login');      // 如果是ajax提交直接返回登录页
        }
        $data = $req->except('_token');
        // 表单验证规则
        $rules = [
            'username' => 'required',
            'password' => 'required',
            'captcha' => 'required|captcha'
        ];
        $message = [
            'captcha.captcha' => '验证码错误'
        ];
        // 表单验证并重定向
        $validator = Validator::make($data, $rules, $message)->validate();
        // 用户信息验证
        // 用户名验证
        $res = Auth::guard('member')->attempt(['username'=>$data['username'],'password'=>$data['password'],'status'=>1]);
        if (!$res) {
            // 邮箱验证
            $res = Auth::guard('member')->attempt(['email'=>$data['username'],'password'=>$data['password'],'status'=>1]);
            if (!$res) {
                // 手机验证
                $res =  Auth::guard('member')->attempt(['mobile'=>$data['username'],'password'=>$data['password'],'status'=>1]);
                if (!$res) {
                    return redirect('/login')->withErrors('账号或者密码错误');
                }
            }
        }
        $user_id = Auth::guard('member')->user()->user_id;
        return redirect()->intended('/');
    }

    // 註冊頁面
    public function register()
    {
        return view('index.account.register');
    }

    // 注册验证
    public function doregister(Request $req)
    {
        // 判断表单提交方式
        if ($req->ajax()) {
            return redirect('/register');
        }
        // 验证表单数据
        $data=$req->except('_token');
        $rules = [  // 验证规则
            'username' => 'required|unique:final_users,username',
            'password' => 'required|confirmed',
        ];
        $validator = Validator::make($data, $rules)->validate();
        // 保存用户信息
        $validator['password'] = bcrypt($validator['password']);
        $res = Member::insert($validator);
        if (!$res) {
            return redirect('/resgiter')->withErrors('注册失败');
        } else {
            return redirect('login');
        }
    }

    // 退出登录
    public function logout()
    {
        Auth::guard('member')->logout();
        return redirect('/login');
    }
}
