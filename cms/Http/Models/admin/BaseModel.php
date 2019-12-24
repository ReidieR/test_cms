<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    //
    protected $table = 'final_admins';

    public function lists()
    {
        $res = $this->get()->toArray();
        
        return $res;
    }
    public function cates($index)
    {
        $res = $this->lists();
        $group=[];
        foreach ($res as $value) {
            $group[$value[$index]] = (array)$value;
        }
        return $group;
    }
    public static function list()
    {
        $res = self::lists();
        return $res;
    }
}
