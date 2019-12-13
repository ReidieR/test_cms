<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //关联表名
    protected $table = 'final_admins';
    // 时间戳管理
    public $timestamps = false;
    // 批量插入管理
    protected $guarded = [];

    // 关联管理员角色Group模型
    // public function group()
    // {
    //     return $this->hasOne('cms\Http\Models\Group');
    // }
}
