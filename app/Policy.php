<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    //
    protected $guarded = ['id'];

    public function cars()
    {
        return $this->belongsToMany('App\Car');
    }
}
