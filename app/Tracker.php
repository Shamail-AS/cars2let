<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    //
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->hasOne('App\Supplier');
    }

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function sims()
    {
        return $this->hasMany('App\Sim');
    }
}
