<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarAccident extends Model
{
    protected $guarded = ['id'];
    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function car(){
    	return $this->belongsTo('App\Car');
    }

    public function driver(){
    	return $this->belongsTo('App\Driver');
    }
}
