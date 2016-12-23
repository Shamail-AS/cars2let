<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    //
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->hasOne('App\Supplier');
    }
}
