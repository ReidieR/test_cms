<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    
    //
    protected $table = 'final_article_content';
    public $timestamps = false;
    protected $guarded =[];

    public function aid()
    {
        $res = \cms\Member::get()->id;
        dd($res);
    }
}
