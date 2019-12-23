<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Essay as Ess;
use DB;

class Lists extends Controller
{
    //  列表页视图
    public function index(Request $req)
    {
        // 获取分类id
        $cate_id = (int)$req->cate_id;
       
        // 获取分页内容
        $data = DB::table('final_article')->where('cate_id', $cate_id)->page(10);
        // 获取分类标题
        $data['title']=DB::table('final_article_category')->where('art_cate_id', $cate_id)->item();
        // $res = Ess::where('cate_id', $cate_id)->paginate(10);
        // $data['total']=$res->total();
        // // dd($res);
        // $result= $res->toArray();
        // // dd($result);
        // // 获取文章信息
        // $data['article'] = $result['data'];
        // // 获取底部分页链接
        // $data['links'] = $res->links();
        // dd($data);
        return view('index.list.index', $data);
    }
    // layui分页数据获取
        // public function paginate(Request $req)
        // {
        //     // 获取分类id
        //     $cate_id = (int)$req->cate_id;
        //     // 分类标题
        //     $data['title']=DB::table('final_article_category')->where('art_cate_id', $cate_id)->item();
        //     // 当前页面
        //     $curr_page = (int)$req->curr_page;
        //     // 页面显示数量(默认十条)
        //     $limit = (int)$req->limit;
        //     $offset = ($limit) * ($curr_page-1);
        //     $data = [$cate_id, $curr_page,$limit,$offset];
        //     // dd($data);
        //     $ess = Ess::where('cate_id', $cate_id)->offset($offset)->limit($limit)->get()->toArray();
        //     $data['result'] = $ess;
        //     if ($ess) {
        //         return view('index.list.index', $data);
        //     // return response()->json(['code'=>0,'msg'=>'获取内容成功']);
        //     } else {
        //         return response()->json(['code'=>1,'msg'=>'获取内容失败']);
        //     }
        //     // dd($ess);
        // }
}
