<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContractHandover extends Model
{
    public function contract() {
    	return $this->belongsTo('App\Contract');
    }

    public function car() {
    	return $this->belongsTo('App\Car');
    }

   	public function driver() {
    	return $this->belongsTo('App\Driver');
    }
}
