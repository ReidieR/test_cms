<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //关联表
    protected $table = 'final_image';
    public $timestamps = false;
    protected $guarded = [];
}
