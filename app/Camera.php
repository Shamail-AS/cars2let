<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camera extends Model
{
    //
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

}
