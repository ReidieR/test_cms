<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use Auth;
use DB;

class Site extends Controller
{
    //网站基本设置
    public function index()
    {
        dd(Auth::user()->username);
    }
}
