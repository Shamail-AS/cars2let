<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    //
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }
    public function tracker()
    {
        return $this->belongsTo('App\Tracker');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

}
