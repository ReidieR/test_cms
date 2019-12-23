<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use DB;
use Auth;

class Home extends Controller
{
    // 首页
    public function index()
    {
        // 获取文章分类
        $cate = DB::table('final_article_category')->where('art_cate_pid', '>', '0')->lists();
        $res = [];
        foreach ($cate as $val) {
            $article['cate_id'] = $val['art_cate_id'];
            $article['cate_title'] = $val['art_cate_title'];
            $article['chd']=DB::table('final_article')->where('cate_id', $val['art_cate_id'])
            ->orderBy('created_at', 'desc')->limit(6)->lists();
            $res[] = $article;
        }
        $data['result'] = $res;
        if (Auth::guard('member')->user()) {
            // 获取用户id
            $user_id = Auth::guard('member')->user()->user_id;
            // 获取用户收藏文章信息
            $res = DB::table('final_conllections')->where('user_id', $user_id)->item();
            if ($res) {
                $data['conllection']= json_decode($res['conllect_article'], true);
            }
        }
        return view('index.home.index', $data);
    }
}
