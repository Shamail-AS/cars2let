<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\CarOrder
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $car_id
 * @property integer $auth_user_id
 * @property string $auth_user
 * @property string $status
 * @property string $comments
 * @property float $cost
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Supplier $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $deliveries
 * @property-read \App\Car $car
 * @property-read \App\User $authorizedBy
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarHistory[] $histories
 * @method static \Illuminate\Database\Query\Builder|\App\CarOrder status($status)
 */
class CarOrder extends Model
{
    //
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }

    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

}
