<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class vacations extends Model
{
    protected $fillable = [
        'start', 'end', 'user_id', 'who_added'
    ];
}
