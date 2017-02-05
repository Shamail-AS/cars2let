<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Tracker
 *
 * @property integer $id
 * @property string $imei
 * @property string $model
 * @property integer $supplier_id
 * @property integer $car_id
 * @property string $installed_at
 * @property string $status
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Supplier $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartOrder[] $orders
 * @property-read \App\Car $car
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Sim[] $sims
 */
class Tracker extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function sims()
    {
        return $this->hasMany('App\Sim');
    }
}
