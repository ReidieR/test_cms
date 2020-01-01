<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Member as Mem;
use Auth;
use DB;
use Illuminate\Validation\Rule;
use cms\Http\Models\Essay as Ess;
use cms\Http\Models\Conllection as Con;
use cms\Http\Models\ArticleContent as Art;

class Member extends Controller
{
    //用户个人中心页面
    public function index()
    {
        // 获取用户信息
        $user = Auth::guard('member')->user();
        // 用户id
        $user_id = $user->user_id;
        // 用户名
        $username = $user->username;
        // 获取用户写的文章
        $article = Ess::where('author', $username)->get()->toArray();
        if ($article) {
            $data['article'] = $article;
        }
        // 获取用户收藏的文章
        $conllectArticleIDs = Con::where('user_id', $user_id)->first();
        if ($conllectArticleIDs) {
            $conllectArticleIDs = $conllectArticleIDs->conllect_article;
            $conllectArticleIDs = json_decode($conllectArticleIDs, true);
            $data['con_article'] =  Ess::whereIn('aid', $conllectArticleIDs)->get()->toArray();
        }
        $data['user']=$user->toArray();
        return view('index.member.index', $data);
    }
    // 用户资料
    public function info()
    {
        // 获取用户id
        $user = Auth::guard('member')->user()->toArray();
        $user['created_at'] = date('Y-m-d H:m:s', $user['created_at']);
        return response()->json(['code'=>0,'msg'=>'获取数据成功','data'=>$user]);
    }
    //用户资料修改
    public function saveUser(Request $req)
    {
        $user_id = auth('member')->user()->user_id;
        
        // 设置验证规格
        $rules = [
            'username' => 'required|unique:final_users,username,'.$user_id.',user_id',
            'email' => 'required|unique:final_users,email,'.$user_id.',user_id',
            'mobile' => 'required|unique:final_users,mobile,'.$user_id.',user_id'
        ];
       
        // 表单验证
        $req->validate($rules);
        $data = $req->only('username', 'email', 'mobile', 'avator');
        $data['updated_at'] = time();
        // 更新用户信息
        $err = Mem::where('user_id', $user_id)->update($data);
        session()->flash('success', '保存成功');
        return back();
    }
    // 用户文章数据
    public function page()
    {
        // 获取用户id
        $username = Auth::guard('member')->user()->username;
        $article = Ess::where('author', $username)->orderBy('created_at', 'desc')->get()->toArray();
        if ($article) {
            $data['article'] = $article;
            return response()->json(['code'=>0,'msg'=>'获取数据成功','data'=>$article]);
        } else {
            return response()->json(['code'=>1,'msg'=>'获取数据失败','data'=>[]]);
        }
    }
    // 编辑文章内容获取
    public function editArticle(Request $req)
    {
        $aid = (int)$req->aid;
        $data['cates'] = DB::table('final_article_category')->where('art_cate_pid', '>', '0')
        ->lists();
        $data['title'] = Ess::find($aid)->title;
        $data['cate_id'] = Ess::find($aid)->cate_id;
        $data['content'] = Art::where('aid', $aid)->first()->content;
        // dd($data);
        $data['aid'] = $aid;
        return \response()->json(['code'=>0,'msg'=>'获取数据成功','data'=>$data]);
    }
    // 收藏文章数据
    public function conllectArticle()
    {
        $user_id = Auth::guard('member')->user()->user_id;
        $conllectArticleIDs = Con::where('user_id', $user_id)->first();
        if ($conllectArticleIDs) {
            $conllectArticleIDs = $conllectArticleIDs->conllect_article;
            $conllectArticleIDs = json_decode($conllectArticleIDs, true);
            $con_article =  Ess::whereIn('aid', $conllectArticleIDs)->orderBy('created_at', 'desc')->get()->toArray();
            // 格式化时间
            foreach ($con_article as $key => $val) {
                $con_article[$key]['created_at'] = date('Y-m-d H:m:s', $val['created_at']);
            }
            return response()->json(['code'=>0,'msg'=>'获取数据成功','data'=>$con_article]);
        } else {
            return response()->json(['code'=>1,'msg'=>'获取数据失败']);
        }
    }
    // 收藏或者取消收藏
    public function conllect(Request $req)
    {
        // 获取用户id
        $user_id = Auth::guard('member')->user()->user_id;
        // 获取文章id
        $aid = (int)$req->aid;
        // 查询用户在收藏表中的记录
        $user = Con::where('user_id', $user_id)->first();
        // 判断用户是在收藏表中有记录
        if ($user) {    // 有记录
             // 获取用户收藏文章id集合
            $article = json_decode($user->conllect_article, true);
            // 判断收藏文章是否为空
            if (!isset($article)) {     // 为空
                $con_art = json_encode([$aid]);
                $res = Con::where('user_id', $user_id)->update(['conllect_article'=>$con_art]);
            } else {
                // 判断是收藏还是取消收藏
                if (!in_array($aid, $article)) {  // 收藏
                    array_push($article, $aid);
                    $data = json_encode($article);
                    // 更新收藏表中的字段
                    $res = DB::table('final_conllections')->where('user_id', $user_id)->update(['conllect_article'=>$data]);
                } else {   // 取消收藏
                    $key = array_keys($article, $aid);  // 获取文章id在收藏列表中的位置
                    $key = $key[0];
                    unset($article[$key]);  // 将文章id从列表中删除
                    $data = json_encode($article);
                    // 更新收藏表中的字段
                    $res = DB::table('final_conllections')->where('user_id', $user_id)->update(['conllect_article'=>$data]);
                }
            }
        } else {  // 没有记录
            $data = [
                'user_id' => $user_id,
                'conllect_article' => json_encode([$aid]),
                'created_at' => time()
            ];
            // dd($data);
            $res = Con::insert($data);
        }
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'操作成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'操作失败']);
        }
    }
}
