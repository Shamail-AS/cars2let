<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CarServiceOrder
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $car_id
 * @property integer $auth_user_id
 * @property string $auth_user
 * @property string $status
 * @property string $comments
 * @property integer $cost
 * @property string $type
 * @property string $booked_dt
 * @property string $handover_dt
 * @property string $handover_person
 * @property integer $insurance_claim_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\User $authorizedBy
 * @property-read \App\Supplier $supplier
 * @property-read \App\InsuranceClaim $claim
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $deliveries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarHistory[] $histories
 * @property-read \App\Car $car
 * @method static \Illuminate\Database\Query\Builder|\App\CarServiceOrder mot()
 * @method static \Illuminate\Database\Query\Builder|\App\CarServiceOrder pco()
 * @method static \Illuminate\Database\Query\Builder|\App\CarServiceOrder regular()
 * @method static \Illuminate\Database\Query\Builder|\App\CarServiceOrder repair()
 * @method static \Illuminate\Database\Query\Builder|\App\CarServiceOrder status($status)
 */
class CarServiceOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function claim()
    {
        return $this->belongsTo('App\InsuranceClaim');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }
    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function scopeMot($query)
    {
        return $query->where('type', 'mot');
    }

    public function scopePco($query)
    {
        return $query->where('type', 'pco');
    }

    public function scopeRegular($query)
    {
        return $query->where('type', 'regular');
    }

    public function scopeRepair($query)
    {
        return $query->where('type', 'repair');
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
