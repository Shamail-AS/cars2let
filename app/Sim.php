<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sim extends Model
{
    //
    protected $guarded = ['id'];

    public function tracker()
    {
        return $this->belongsTo('App\Tracker');
    }

}
