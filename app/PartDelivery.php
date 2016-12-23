<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PartDelivery extends Model
{
    //
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\PartOrder');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'rec_user_id');
    }
}
