<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use DB;

class Detail extends Controller
{
    public function index(Request $req)
    {
        $aid = (int)$req->aid;
        $err =DB::table('final_article')->where('aid', $aid)->increment('read_num');
        if (!$err) {
            return redirect('/');
        }
        $res =DB::table('final_article')->where('aid', $aid)->item();
        if (!$res) {
            return view('index.public.dsf');
        }
        $data['content'] = DB::table('final_article_content')->where('aid', $aid)->item();
        $data['article'] = $res;
        return view('index.detail.index', $data);
    }
}
