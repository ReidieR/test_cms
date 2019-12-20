<?php

namespace cms\Http\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use Notifiable;
    protected $table = 'final_comments';
    public $timestamps = false;
}
