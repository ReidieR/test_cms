<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //关联表
    protected $table = 'final_admin_groups';
    public $timestamps = false;
}
