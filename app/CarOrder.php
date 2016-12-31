<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }

    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

}
