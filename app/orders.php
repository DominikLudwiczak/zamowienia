<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $fillable = [
        'supplier_id', 'product_id', 'user_id', 'ammount'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function suppliers()
    {
        return $this->belongsTo('App\suppliers');
    }

    public function products()
    {
        return $this->hasMany('App\products');
    }

    public function users()
    {
        return $this->belongsTo('App\users');
    }
}
