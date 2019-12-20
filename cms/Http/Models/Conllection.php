<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Conllection extends Model
{
    use Notifiable;
    protected $table = 'final_conllections';
    protected $guarded = [];
    public $timestamps = false;
}
