<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Essay as Ess;
use DB;

class Essay extends Controller
{
    //文章列表
    public function index()
    {
        $ess = Ess::paginate(10);
        $essa = $ess->toArray();
        $essay = $essa['data'];
        $res = [];
        foreach ($essay as $val) {
            $cate = DB::table('final_article_category')->where('art_cate_id', $val['cate_id'])->first();
            $val['cate_title'] = $cate ->art_cate_title;
            $res[] = $val;
        }
        $data['links'] = $ess->links();
        $data['result'] = $res;
        return view('admins.essay.index', $data);
    }

    // 编辑文章
    public function edit(Request $req)
    {
        $aid = (int)$req->aid;
        // 获取文章信息
        $data['essay'] = DB::table('final_article')->where('aid', $aid)->item();
        // 获取文章内容
        $data['content'] = DB::table('final_article_content')->where('aid', $aid)->item();
        // 获取文章分类
        $category= DB::table('final_article_category')->cates('art_cate_id');
        $cate = $this->getTreeCate($category);
        foreach ($cate as $val) {
            $val['chd'] = isset($val['chd']) ? $this->fomateCate($val['chd']) : false;
        }
        $data['cate'] = $cate;
        $data['aid'] = $aid;
        return view('admins.essay.edit', $data);
    }

    // 保存文章
    public function save(Request $req)
    {
        $data = $req->except(['_token','uri','method','ip']);
        // dd($data);
        $aid = $data['aid'];
        $data['cover_img'] = (string)$data['cover_img'];
        $content = $data['content'];
        unset($data['content']);
        unset($data['aid']);
        $data['updated_at'] = time();
        $res = Ess::where('title', $data['title'])->first();
        if ($aid) { // 修改文章
            if ($res && $res->aid != $aid) {
                return response()->json(array('code'=>1,'msg'=>'保存失败'));
            }
            DB::beginTransaction();
            try {
                // 1、将文章信息保存到文章表中
                DB::table('final_article')->where('aid', $aid)->update($data);
                // 2、将文章内容保存到文章内容表中
                DB::table('final_article_content')->where('aid', $aid)->update(['content'=>$content]);

                DB::commit();
            } catch (QueryException $ex) {
                DB::rollback();
                return response()->json(array('code'=>1,'msg'=>'保存失败'));
            }
        } else {    // 新增文章
            $data['created_at']=time();
            if ($res) {
                return response()->json(array('code'=>1,'msg'=>'该文章已存在'));
            }
            try {
                // 1、将文章信息保存到文章表中
                $id= DB::table('final_article')->insertGetId($data);
                // 2、将文章内容保存到文章内容表中
                DB::table('final_article_content')->insert(['aid'=>$id,'content'=>$content]);
                DB::commit();
            } catch (QueryException $ex) {
                DB::rollback();
                return response()->json(array('code'=>1,'msg'=>'保存失败'));
            }
        }
        return response()->json(['code'=>0,'msg'=>'保存成功']);
    }

    // 删除文章
    public function delete(Request $req)
    {
        $aid = $req->aid;
        try {
            DB::beginTransaction();
            DB::table('final_article')->where('aid', $aid)->delete();
            DB::table('final_article_content')->where('aid', $aid)->delete();
            DB::commit();
            return response()->json(array('code'=>0,'msg'=>'删除成功'));
        } catch (QueryException $ex) {
            DB::rollback();
            return response()->json(array('code'=>1,'msg'=>'删除失败'));
        }
    }

    // 将文章分类转为无限级
    public function getTreeCate($item)
    {
        $res=[];
        foreach ($item as $val) {
            if ($val['art_cate_pid']) {    // 判断是否存在上一级分类
                $item[$val['art_cate_pid']]['chd'][]=&$item[$val['art_cate_id']];
            } else {
                // 没有上级菜单的直接把值给$res数组
                $res[] = &$item[$val['art_cate_id']];
            }
        }
        return $res;
    }

    // 将多维数组转为一维数组
    public function fomateCate($item, &$res=[])
    {
        foreach ($item as $val) {
            if (!isset($val['chd'])) {   // 判断是否存在子数组
                $res[] = $val;
            } else { // 存在子数组
                $temp = $val['chd'];
                $this->fomateCate($temp);
                unset($val['chd']);
                $res[] = $val;
            }
        }
        return $res;
    }
}
