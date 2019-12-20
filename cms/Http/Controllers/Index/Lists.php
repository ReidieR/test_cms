<?php

namespace cms\Http\Controllers\Index;

use Illuminate\Http\Request;
use cms\Http\Controllers\Controller;
use cms\Http\Models\Essay as Ess;

class Lists extends Controller
{
    //
    public function index(Request $req)
    {
        $cate_id = (int)$req->cate_id;
        $res = Ess::where('cate_id', $cate_id)->paginate(10);
        $result= $res->toArray();
        // dd($result);
        $data['article'] = $result['data'];
        $data['links'] = $res->links();
        return view('index.list.index', $data);
    }
}
