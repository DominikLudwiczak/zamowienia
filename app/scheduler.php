<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class scheduler extends Model
{
    protected $fillable = [
        'supplier_id', 'name'
    ];
}
