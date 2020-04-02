<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{   
    protected $fillable = [
        'order_id', 'supplier', 'user_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function users()
    {
        return $this->belongsTo('App\users');
    }

    public function order_id()
    {
        return $this->hasMany('App\orderDetails');
    }
}
