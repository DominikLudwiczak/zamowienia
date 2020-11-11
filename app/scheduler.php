<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scheduler extends Model
{
    protected $fillable = [
        'start', 'end', 'user_id', 'shop_id', 'who_added'
    ];
}
