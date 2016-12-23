<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    //

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->morphTo();
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
