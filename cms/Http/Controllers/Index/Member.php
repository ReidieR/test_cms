<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Member as Mem;
use Auth;

class Member extends Controller
{
    //用户个人中心页面
    public function index()
    {
        $user_id = Auth::guard('member')->user()->user_id;
        
        return view('index.member.index');
    }
}
