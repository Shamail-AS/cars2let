<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CarAccident
 *
 * @property integer $id
 * @property integer $car_id
 * @property integer $driver_id
 * @property string $incident_at
 * @property string $location
 * @property string $type
 * @property string $weather_cond
 * @property string $road_cond
 * @property string $police_details
 * @property string $comments
 * @property string $status
 * @property string $x_car_reg
 * @property string $x_car_details
 * @property string $x_driver_name
 * @property string $x_driver_licence
 * @property string $x_insured_name
 * @property string $x_insured_comp
 * @property string $x_insured_policy
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarHistory[] $histories
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SiteFile[] $files
 * @property-read \App\Car $car
 * @property-read \App\Driver $driver
 */
class CarAccident extends Model
{
    protected $guarded = ['id'];
    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function car(){
    	return $this->belongsTo('App\Car');
    }

    public function driver(){
    	return $this->belongsTo('App\Driver');
    }
}
