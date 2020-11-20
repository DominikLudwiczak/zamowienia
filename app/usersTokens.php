<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class usersTokens extends Model
{
    protected $fillable = [
        'email', 'token', 'expired_at'
    ];

    public $timestamps = false;
}
