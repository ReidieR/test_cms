<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    protected $table = 'final_article_category';
    public $timestamps = false;
    protected $guarded= [] ;
}
