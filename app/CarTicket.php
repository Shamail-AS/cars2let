<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\CarTicket
 *
 * @property integer $id
 * @property string $type
 * @property string $ticket_num
 * @property string $cause
 * @property integer $car_id
 * @property integer $driver_id
 * @property string $incident_dt
 * @property string $issue_dt
 * @property float $amount
 * @property string $comments
 * @property string $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SiteFile[] $files
 * @property-read \App\Car $car
 * @property-read \App\Driver $driver
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DriverConviction[] $convictions
 */
class CarTicket extends Model
{
    //
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function convictions()
    {
        return $this->hasMany('App\DriverConviction');
    }

}
