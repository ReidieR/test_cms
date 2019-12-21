<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;

class Edit extends Controller
{
    // 文章编辑页面
    public function index()
    {
        return view('index.edit.index');
    }
}
