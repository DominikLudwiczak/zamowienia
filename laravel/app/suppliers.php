<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class suppliers extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'logo'
    ];

    public function orders()
    {
        return $this->hasMany('App\orders');
    }

    public function products()
    {
        return $this->hasMany('App\products');
    }
}
