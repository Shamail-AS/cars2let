<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarServiceOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function authorizedBy()
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
    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function scopeMot($query)
    {
        return $query->where('type', 'mot');
    }

    public function scopePco($query)
    {
        return $query->where('type', 'pco');
    }

    public function scopeRegular($query)
    {
        return $query->where('type', 'regular');
    }

    public function scopeRepair($query)
    {
        return $query->where('type', 'repair');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
