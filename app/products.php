<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'supplier_id', 'name'
    ];

    public function suppliers()
    {
        return $this->belongsTo('App\suppliers');
    }

    public function orders()
    {
        return $this->belongsTo('App\orders');
    }
}
