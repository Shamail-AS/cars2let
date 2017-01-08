<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $guarded = ['id'];

    public function bank()
    {
        return $this->belongsTo('App\BankAccount');
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }
}
