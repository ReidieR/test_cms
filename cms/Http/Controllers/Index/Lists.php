<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Essay as Ess;
use DB;

class Lists extends Controller
{
    //
    public function index(Request $req)
    {
        // 获取分类id
        $cate_id = (int)$req->cate_id;
        // 获取分类标题
        $data['title']=DB::table('final_article_category')->where('art_cate_id', $cate_id)->item();
        // 获取分页内容
        $res = Ess::where('cate_id', $cate_id)->paginate(10);
        $result= $res->toArray();
        // 获取文章信息
        $data['article'] = $result['data'];
        // 获取底部分页链接
        $data['links'] = $res->links();
        // dd($data);
        return view('index.list.index', $data);
    }
}
