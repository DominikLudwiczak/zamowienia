<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    protected $fillable = [
        'order_id', 'name', 'ammount'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function order_id()
    {
        return $this->belongsTo('App\orders');
    }
}
