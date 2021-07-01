<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class holidays extends Model
{
    protected $fillable = [
        'name', 'date'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
