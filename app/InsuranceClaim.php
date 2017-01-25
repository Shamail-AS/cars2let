<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InsuranceClaim
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarServiceOrder[] $serviceOrders
 */
class InsuranceClaim extends Model
{
    //
    protected $guarded = ['id'];

    public function serviceOrders()
    {
        return $this->hasMany('App\CarServiceOrder');
    }
}
