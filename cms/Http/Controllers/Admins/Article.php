<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\ArticleCategory as Art;
use DB;

class Article extends Controller
{
    // 文章分类列表
    public function index(Request $req)
    {
        $cate_pid  = (int)$req->cate_pid;
        $data['result']=Art::where('art_cate_pid', $cate_pid)->get()->toArray();
        $data['cate_pid'] = $cate_pid;
        return view('admins.article.index', $data);
    }

    // 编辑文章分类
    public function edit(Request $req)
    {
        $id = (int)$req->art_cate_id;
        $cate_pid = (int)$req->cate_pid;
        if ($cate_pid) {
            $parent_cate = Art::where('art_cate_id', $cate_pid)->first();   // 获取父级分类的信息
            // dd($parent_cate);
            $data['pcate_title'] = $parent_cate['art_cate_title'];  // 获取父级分类的名称
        }
        if (!$id) {
            $data['art_cate'] = false;
        } else {
            $data['art_cate'] = Art::where('art_cate_id', $id)->first()->toArray();
        }
        $data['id'] =$id;
        $data['cate_pid'] = $cate_pid;
        // dd($data);
        return view('admins.article.edit', $data);
    }

    // 保存分类
    public function save(Request $req)
    {
        $data = $req->except('_token');
        $id = $data['art_cate_id'];     // 分类id
        unset($data['art_cate_id']);
        $data['updated_at'] = time();
        $res = Art::where('art_cate_title', $data['art_cate_title'])->first();
        if ($id) {  // 修改分类
            if ($res && $res['art_cate_id'] != $id) {
                return response()->json(array('code'=>1,'msg'=>'该分类已存在'));
            }
            Art::where('art_cate_id', $id)->update($data);
        } else {    // 新增分类
            if ($res) {
                return response()->json(array('code'=>1,'msg'=>'该分类已存在'));
            }
            Art::insert($data);
        }
        return response()->json(array('code'=>0,'msg'=>'保存成功'));
    }
    // 删除分类
    public function delete(Request $req)
    {
        // 软删除将数据表中的is_delete字段的值改为2
        $id = $req->id;
        dd($id);
        Art::where('art_cate_id', $id)->update(['is_deleted'=>2]);
        return response()->json(array('code'=>0,'msg'=>'删除成功'));
    }
}
