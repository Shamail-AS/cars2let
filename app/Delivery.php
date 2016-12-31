<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->morphTo();
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'rec_user_id');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function scopeUndelivered($query)
    {
        return $query->where('delivered_at', null);
    }
}
