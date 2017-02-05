<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\DriverConviction
 *
 * @property integer $id
 * @property integer $driver_id
 * @property integer $car_ticket_id
 * @property string $details
 * @property integer $penalty_points
 * @property string $convicted_at
 * @property string $place
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Driver $driver
 * @property-read \App\CarTicket $ticket
 */
class DriverConviction extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }

    public function ticket()
    {
        return $this->belongsTo('App\CarTicket');
    }
}
