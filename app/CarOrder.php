<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->hasOne('App\Supplier');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }

    public function car()
    {
        return $this->hasOne('App\Car');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }

}
