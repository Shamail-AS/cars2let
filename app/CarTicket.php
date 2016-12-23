<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarTicket extends Model
{
    //
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function convictions()
    {
        return $this->hasMany('App\DriverConviction');
    }

}
