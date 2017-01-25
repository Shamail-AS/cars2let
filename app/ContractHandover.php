<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ContractHandover
 *
 * @property integer $id
 * @property integer $car_id
 * @property integer $driver_id
 * @property integer $contract_id
 * @property string $handover_date
 * @property string $type
 * @property string $status
 * @property string $odo_meter_reading
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Contract $contract
 * @property-read \App\Car $car
 * @property-read \App\Driver $driver
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SiteFile[] $files
 * @method static \Illuminate\Database\Query\Builder|\App\ContractHandover type($type)
 */
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
    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function deliveries()
    {
        return $this->morphMany('App\Delivery', 'order');
    }

    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function handover()
    {
        $this->status = 'completed';

        $car = $this->car;
        $driver = $this->driver;
        $user = \Auth::user();

        $history = new CarHistory();
        $history->comments = "car handed over";
        $history->car_id = $car->id;
        $this->histories()->save($history);

        $delivery = new Delivery();
        $delivery->scheduled_at = $this->handover_date;
        $delivery->delivered_at = $this->handover_date;
        $delivery->received_by = $this->type == 'outgoing' ? $driver->name : $user->email;
        $delivery->rec_user_id = $user->id;
        $delivery->comments = $this->comments;
        $delivery->type = 'contract-handover';
        $delivery->condition = $this->comments;
        $delivery->odo_reading = $this->odo_meter_reading;
        $delivery->location = "car park";
        $delivery->status = 'received';
        $this->deliveries()->save($delivery);
        $car->deliveries()->save($delivery);

        $history = new CarHistory();
        $history->comments = "car delivered";
        $history->car_id = $car->id;
        $delivery->histories()->save($history);
    }
}
