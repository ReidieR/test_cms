<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Essay extends Model
{
    protected $table = 'final_article';
    public $timestamps = false;
    protected $guarded = [];
}
