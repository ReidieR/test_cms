<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Image as Img;
use Storage;
use cms\Http\Controllers\Admins\Qiniu;
use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\BucketManager;
use DB;

class Image extends Controller
{
    // 图片上传
    public function upload(Request $req)
    {
        // 1 将图片上传到本地服务器存储
        // 获取文件数据
        $file = $req->file('file');
        // 判断文件上传是否成功
        if (!$file->isValid()) {
            return response()->json(['code'=>1,'msg'=>'无效的上传文件']);
        }
        $path = $file->store('public/avator');
        $url = Storage::url($path);
        $response = array('code'=>0,'msg'=>'上传成功','src'=>$url);
        return json_encode($response);


        // 2 将图片上传到七牛云存储
        // $file = $req->file('file');
        // // 判断文件上传是否成功
        // if (!$file->isValid()) {
        //     return response()->json(['code'=>1,'msg'=>'无效的上传文件']);
        // }
        // // 生成文件存储路径和名称
        // $path = $file->store('avator');

        // // 初始化七牛云
        // $disk = Storage::disk('qiniu');
        // // 上传文件到七牛云
        // $res = $disk->put($path, file_get_contents($file->getRealPath()));
        // // 判断文件上传是否成功
        // if (!$res) {
        //     return response()->json(['code'=>1,'msg'=>'上传文件失败']);
        // }
        // // 获取文件访问地址
        // $url = $disk->getUrl($path);
        // $response = array('code'=>0,'msg'=>'上传成功','data'=>['src'=>$url]);
        // return response()->json($response);
    }

    // 图片列表
    public function index()
    {
        $data['result'] = Img::get()->toArray();
        return view('admins.image.index', $data);
    }

    // 图片编辑
    public function edit(Request $req)
    {
        $img_id = (int)$req->img_id;
        $data['image'] = DB::table('final_image')->where('img_id', $img_id)->item();
        $data['img_id'] = $img_id;
        return view('admins.image.edit', $data);
    }

    // 保存图片
    public function save(Request $req)
    {
        $data = $req->except('url', '_token', 'method', 'ip');
        $id = (int)$req->img_id;
        $img = Img::where('title', $data['title'])->first();
        unset($data['img_id']);
        $data['updated_at']=time();
        if (!$id) {           // 添加图片
            if ($img) {
                return response()->json(['code'=>1,'msg'=>'该图片名称已存在']);
            }
            $data['created_at']=time();
            // dd($data);
            $res = Img::insert($data);
        } else {            // 修改图片
            if ($img && $img['img_id'] != $id) {
                return response()->json(['code'=>1,'msg'=>'该图片名称已存在']);
            }
            $res = Img::where('img_id', $id)->update($data);
        }
        if ($res) {
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        } else {
            return response()->json(['code'=>1,'msg'=>'保存失败']);
        }
    }

    // 图片删除
    public function delete(Request $req)
    {
       
        // 获取图片要删除的图片id
        $img_id = (int)$req->img_id;
        // 获取图片存储的目录（路径 + 名称）
        $res = Img::where('img_id', $img_id)->first();
        if (!$res) {
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
        $img_url = $res->img_url;
        $http = getenv('QINIU_DOMAIN');
        $file = explode($http, $img_url);
        // 1 从数据库中删除该条记录
        $err = Img::where('img_id', $img_id)->delete();
        if (!$err) {
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        } else {
            // 2 把图片从七牛云端删除
            // 获取要删除的文件名称
            $key = $file[1];
            // 初始化七牛空间管理对象
            $accessKey = getenv('QINIU_ACCESS_KEY');
            $secretKey = getenv('QINIU_SECRET_KEY');
            $bucket = getenv('QINIU_BUCKET');
            $config = new \Qiniu\Config();
            $auth = new QiniuAuth($accessKey, $secretKey);
            $bucketMgr = new BucketManager($auth, $config);

            // 删除文件
            $err = $bucketMgr ->delete($bucket, $key);
            if ($err) {
                return response()->json(['code'=>1,'msg'=>'删除失败']);
            } else {
                return response()->json(['code'=>0,'msg'=>'删除成功']);
            }
        }
    }
}
