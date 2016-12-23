<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarServiceOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function authorisedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }

    public function claim()
    {
        return $this->belongsTo('App\InsuranceClaim');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }
}
