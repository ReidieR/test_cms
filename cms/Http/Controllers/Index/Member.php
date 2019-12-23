<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Member as Mem;
use Auth;
use DB;
use cms\Http\Models\Conllection as Con;

class Member extends Controller
{
    //用户个人中心页面
    public function index()
    {
        // session('collection');
        $user_id = Auth::guard('member')->user()->user_id;
        dd(session('conllection'));
        return view('index.member.index');
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
                'collect_article' => $aid,
                'created_at' => time()
            ];
            $res = Con::insert($data);
        }
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'操作成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'操作失败']);
        }
    }
}
