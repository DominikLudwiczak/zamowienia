<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    protected $fillable = [
        'order_id', 'product_id', 'ammount'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany('App\products');
    }

    public function order_id()
    {
        return $this->belongsTo('App\orders');
    }
}
