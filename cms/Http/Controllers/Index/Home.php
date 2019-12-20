<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use DB;

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
        // dd($data);
        return view('index.home.index', $data);
    }

    // 将一维数组转化为多维数组
    public function getTreeAraay($items)
    {
        $res = [];
        foreach ($items as $item) {
            if ($itemp['pid']);
        }
    }
}
