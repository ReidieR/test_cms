<?php

namespace cms\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Link extends Model
{
    use Notifiable;
    protected $table = 'final_links';
    public $timestamps = false;
    protected $guarded = [];
}
