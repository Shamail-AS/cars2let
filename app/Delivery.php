<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Delivery
 *
 * @property integer $id
 * @property string $scheduled_at
 * @property string $delivered_at
 * @property integer $rec_user_id
 * @property string $received_by
 * @property string $comments
 * @property string $type
 * @property integer $order_id
 * @property string $order_type
 * @property integer $car_id
 * @property string $condition
 * @property integer $odo_reading
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $status
 * @property-read \App\Delivery $order
 * @property-read \App\User $receiver
 * @property-read \App\Car $car
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SiteFile[] $files
 * @method static \Illuminate\Database\Query\Builder|\App\Delivery undelivered()
 */
class Delivery extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function order()
    {
        return $this->morphTo();
    }

    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }
    public function receiver()
    {
        return $this->belongsTo('App\User', 'rec_user_id');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function scopeUndelivered($query)
    {
        return $query->where('delivered_at', null);
    }
}
