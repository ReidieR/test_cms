<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use Auth;
use cms\Http\Models\Essay as Ess;
use cms\Http\Models\ArticleContent as Con;
use DB;

class Edit extends Controller
{
    // 文章编辑页面
    public function index()
    {
        // 获取用户id
        $username = Auth::guard('member')->user()->username;
        // 获取文章分类
        $data['cate'] = DB::table('final_article_category')->where('art_cate_pid', '>', '0')->lists();
        // dd($data);
        // 获取用户写的文章
        $data['article'] = Ess::where('author', $username)->limit(10)
        ->orderBy('created_at', 'desc')->get()->toArray();
        return view('index.edit.index', $data);
    }

    // 显示文章内容
    public function article(Request $req)
    {
        $aid = (int)$req->aid;
        $article = Ess::find($aid);
        $title= $article -> title;
        $cate_id = $article -> cate_id;
        $content = Con::where('aid', $aid)->first('content');
        if (isset($content)) {
            $con = $content->content;
            if (!$con) {
                $con = '';
            }
            return response()->json(['code'=>0,'msg'=>'获取数据成功','data'=>['content'=>$con,'title'=>$title,'cate_id'=>$cate_id]]);
        } else {
            return response()->json(['code'=>1,'msg'=>'获取数据失败']);
        }
    }

    // 保存文章
    public function save(Request $req)
    {
        $aid = (int)$req->aid;      // 获取文章id
        $art = Ess::find($aid);     // 获取文章信息
        $data = [
            'title'=>trim($req->title),
            'descs' => (string)$req->descs,
            'cate_id' => (int)$req->cate_id,
            'author' => Auth::guard('member')->user()->username
        ];
        // dd($data);
        $content = [
            'content'=>$req->content
        ];
        $data['updated_at']=$content['updated_at'] = time();
        if ($art) {  // 编辑文章
            $data['updated_at'] = time();
            Ess::where('aid', $aid)->update($data);
            
            $res = Con::where('aid', $aid)->update($content);
        // dd($res);
        } else {  // 新增文章
            $data['created_at'] =$content['created_at'] = time();
            $aid = Ess::where('aid', $aid)->insertGetId($data);
            $content['aid']=$aid;
            $res = Con::where('aid', $aid)->insert($content);
        }
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'保存成功','data'=>$aid]);
        } else {
            return response()->json(['code'=>1,'msg'=>'保存失败']);
        }
    }

    // 文章发表
    public function post(Request $req)
    {
        $aid = (int)$req->aid;  // 获取文章id
        $username = Auth::guard('member')->user()->username;  // 获取当前用户
        $article = Ess::find($aid);     // 获取文章信息
        if (!$article) {    // 判断文章是否存在
            return response()->json(['code'=>1,'msg'=>'请先保存文章']);
        }
        $author=$article->author;     // 获取文章作者
        if ($username != $author) {     // 判断文章作者和用户的关系
            return response()->json(['code'=>1,'msg'=>'你没有权限操作']);
        }
        if ($article->is_hidden == 1) {  // 判断是发表操作还是收回操作
            return response()->json(['code'=>0,'msg'=>'已发表']);   // 修改发表状态
        } else {
            $res = Ess::where('aid', $aid)->update(['is_hidden'=>1]);   // 修改发表状态
            if ($res) {
                return response()->json(['code'=>0,'msg'=>'已发表']);
            } else {
                return response()->json(['code'=>1,'msg'=>'操作失败']);
            }
        }
    }

    // 文章删除
    public function delete(Request $req)
    {
        $aid = (int)$req->aid;  // 获取文章id
        $username = Auth::guard('member')->user()->username;  // 获取当前用户
        $article = Ess::find($aid);     // 获取文章信息
        if (!$article) {    // 判断文章是否存在
            return response()->json(['code'=>1,'msg'=>'请先保存文章']);
        }
        $author=$article->author;     // 获取文章作者
        if ($username != $author) {     // 判断文章作者和用户的关系
            return response()->json(['code'=>1,'msg'=>'你没有权限操作']);
        }
        // 删除文章
        $res = Ess::where('aid', $aid)->delete();
        if ($res) {
            $err = Con::where('aid', $aid)->delete();
        } else {
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
        if ($err) {
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }
}
