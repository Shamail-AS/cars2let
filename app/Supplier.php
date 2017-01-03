<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $guarded = ['id'];

    public function bank()
    {
        return $this->morphMany('App\BankAccount', 'owner');
    }
    public function order() {
        return $this->hasOne('App\CarOrder');
    }

    public function cameras() {
    	return $this->hasMany('App\Camera');
    }
    public function serviceOrders() {
        return $this->hasMany('App\CarServiceOrder');
    }

    public function trackers() {
    	return $this->hasMany('App\Tracker');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
