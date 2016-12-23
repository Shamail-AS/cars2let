<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceClaim extends Model
{
    //
    protected $guarded = ['id'];

    public function serviceOrders()
    {
        return $this->hasMany('App\ServiceOrder');
    }
}
