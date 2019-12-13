<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Essay as Ess;
use cms\Http\Models\ArticleCategory as Art;
use DB;

class Essay extends Controller
{
    //文章列表
    public function index()
    {
        $essay = Ess::all()->toArray();
        $res = [];
        foreach ($essay as $val) {
            $cate = Art::where('art_cate_id', $val['cate_id'])->first();
            $val['cate_title'] = $cate ->art_cate_title;
            $res[] = $val;
        }
        
        $data['result'] = $res;
        return view('admins.essay.index', $data);
    }

    // 编辑文章
    public function edit(Request $req)
    {
    }
}
