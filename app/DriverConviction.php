<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverConviction extends Model
{
    //
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function ticket()
    {
        return $this->belongsTo('App\CarTicket');
    }
}
