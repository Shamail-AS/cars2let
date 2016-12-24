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
}
