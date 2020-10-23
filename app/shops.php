<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class shops extends Model
{
    protected $fillable = [
        'name', 'city', 'street', 'number', 'postal'
    ];
}
