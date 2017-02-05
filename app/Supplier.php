<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Supplier
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $contact_name
 * @property string $contact_details
 * @property string $type
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankAccount[] $bank
 * @property-read \App\CarOrder $order
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Camera[] $cameras
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarServiceOrder[] $serviceOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Tracker[] $trackers
 * @method static \Illuminate\Database\Query\Builder|\App\Supplier type($type)
 */
class Supplier extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function bank()
    {
        return $this->morphMany('App\BankAccount', 'owner');
    }
    public function order() {
        return $this->hasOne('App\CarOrder');
    }

    public function cameras() {
    	return $this->hasMany('App\Camera');
    }
    public function serviceOrders() {
        return $this->hasMany('App\CarServiceOrder');
    }

    public function trackers() {
    	return $this->hasMany('App\Tracker');
    }
    public function policies() {
        return $this->hasMany('App\Policy');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
