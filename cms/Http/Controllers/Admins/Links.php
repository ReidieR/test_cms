<?php

namespace cms\Http\Controllers\Admins;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Link;
use Validator;

class Links extends Controller
{
    // 友情链接
    public function index()
    {
        $data['links'] = Link::get()->toArray();
        return view('admins.link.index', $data);
    }

    // 编辑链接
    public function edit(Request $req)
    {
        $id = (int)$req->id;
        if (!$id) {
            $data['link']=false;
        } else {
            $data['link'] = Link::find($id)->toArray();
        }
        $data['id'] = $id;
        return view('admins.link.edit', $data);
    }

    // 保存链接
    public function save(Request $req)
    {
        // 验证规则
        $rules = [
            'title' => 'required',
            'url' => 'bail|required|url'
        ];
        // 错误提示消息
        $message = [
            'title.required' => '请输入链接名称',
            'url.required' => '请输入链接地址',
            'url.url' => '请输入正确的链接地址'
        ];
        // 验证数据
        $validator = Validator::make($req->all(), $rules, $message);
        if ($validator->fails()) {
            $err = $validator->errors()->all();
            $res = implode(',', $err);
            return response()->json(['code'=>1,'msg'=>$res]);
        }
        $data = $req->only('title', 'url', 'status');
        $id = (int)$req->id;
        $res = Link::where('title', $data['title'])->first();
        if ($id) {   // 修改链接
            if ($res && $id != $res->id) {  //  判断是否重名
                return response()->json(['code'=>1,'msg'=>'该链接名称已存在']);
            }
            $data['updated_at'] = time();
            $err = Link::where('id', $id)->update($data);
        } else {
            if ($res) {
                return response()->json(['code'=>1,'msg'=>'该链接名称已存在']);
            }
            $data['updated_at'] = time();
            $err = Link::where('id', $id)->insert($data);
        }
        if (!$err) {
            return response()->json(['code'=>1,'msg'=>'保存失败']);
        } else {
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        }
    }

    // 删除链接
    public function delete(Request $req)
    {
        $id=(int)$req->id;
        $err = Link::where('id', $id)->delete();
        if ($err) {
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }
}
