<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function item()
    {
        return $this->morphTo();
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function deliveries()
    {
        return $this->hasMany('App\PartDelivery');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }
}
