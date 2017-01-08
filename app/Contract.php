<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed end_date
 */
class Contract extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['start_date', 'act_start_dt', 'act_end_dt', '', 'end_date', 'deleted_at'];

    protected $fillable = [
        'status',
        'car_id',
        'driver_id',
        'start_date',
        'end_date',
        'rate',
    ];

    public function car()
    {
        return $this->belongsTo('App\Car');
    }
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
    public function histories()
    {
        return $this->morphMany('App\CarHistory', 'historable');
    }
    public function handovers()
    {
        return $this->hasMany('App\ContractHandover');
    }
    public function getInvestorAttribute()
    {
        $car = $this->car;
        $investor = $car->investor;
        return $investor;
    }

    public function revenues()
    {
        return $this->hasMany('App\Revenue');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }


    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }
    public function scopeOngoing($query)
    {
        return $query->where('status',1);
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
    public function getRentAttribute()
    {
        $revenues = $this->revenues;
        $rent = 0;
        foreach ($revenues as $revenue) {
            $rent += $revenue->amount_paid;
        }
        return $rent;

    }
    public function getRentForCurrentPeriodAttribute(){
        $revenues = $this->revenues;
        $rent = 0;
        $acc_periods = $this->investor->getAccountingPeriods();

        foreach ($revenues as $revenue) {
            if ($revenue->inPeriod($acc_periods[0], $acc_periods[1]))
            $rent += $revenue->amount_paid;
        }
        return $rent;
    }

    public function getRevenueAttribute()
    {
        $duration = $this->weeksDone;
        if($duration<0) dd($this);
        return $duration*$this->rate;
    }
    public function getRevenueForCurrentPeriodAttribute(){
        $duration = $this->weeksDoneForCurrentPeriod;
        if($duration<0) dd($this);
        return $duration*$this->rate;
    }

    public function getWeeksDoneForCurrentPeriodAttribute()
    {
        $acc_periods = $this->investor->getAccountingPeriods();
        $date_from = $acc_periods[0]->max($this->start_date);
        $date_to = $acc_periods[1]->min($this->end_date)->min(Carbon::now());
        if ($date_from->gte(Carbon::now())) return 0;
        else return $date_to->diffInWeeks($date_from);
    }
    public function getWeeksDoneAttribute()
    {
        $w_done = $this->start_date->diffInWeeks(Carbon::now());
        return min($w_done,$this->weeksTotal);
    }
    public function getWeeksTotalAttribute()
    {
        return $this->end_date->diffInWeeks($this->start_date,true);
    }

    public function getRentAllocationsCountAttribute()
    {
        return ceil($this->start_date->diffInDays($this->end_date) / 7);
    }

    public function getRentForNextPeriodAttribute()
    {
        $revenues = $this->revenues;
        $rent = 0;
        $acc_periods = $this->investor->getAccountingPeriods(1);

        foreach ($revenues as $revenue) {
            if ($revenue->inPeriod($acc_periods[0], $acc_periods[1]))
                $rent += $revenue->amount_paid;
        }
        return $rent;
    }

    public function getRevenueForNextPeriodAttribute()
    {
        $duration = $this->weeksDoneForNextPeriod;
        if ($duration < 0) dd($this);
        return $duration * $this->rate;
    }

    public function getWeeksDoneForNextPeriodAttribute()
    {
        $acc_periods = $this->investor->getAccountingPeriods(1);
        $date_from = $acc_periods[0]->max($this->start_date);
        $date_to = $acc_periods[1]->min($this->end_date)->min(Carbon::now());
        if ($date_from->gte(Carbon::now())) return 0;
        else return $date_to->diffInWeeks($date_from);
    }

    public function isDateDuringContract($date)
    {
        return $date->between($this->start_date, $this->end_date);
    }

    public function getHasOutHandoverAttribute()
    {
        return $this->handovers()->type('outgoing')->count() > 0;
    }

    public function getHasInHandoverAttribute()
    {
        return $this->handovers()->type('incoming')->count() > 0;
    }

    public function getHasAllHandoversAttribute()
    {
        return $this->handovers()->count() >= 2;
    }

    public function start()
    {
        if ($this->status != 2) return; //only start from suspended
        $this->act_start_dt = Carbon::now();
        $this->status = 1; //ongoing

        $history = new CarHistory;
        $history->car_id = $this->car_id;
        $history->comments = 'car contract started';
        $this->histories()->save($history);

        for ($i = 0; $i < $this->rentAllocationsCount; $i++) {
            $rev = Revenue::create([
                'week' => $i + 1,
                'amount_paid' => 0
            ]);
            $this->revenues()->save($rev);
        }

        $this->save();
    }

    public function end()
    {

        if ($this->status >= 3) return; //only end from ongoing or suspended
        $this->act_end_dt = Carbon::now();
        if ($this->act_end_dt->eq($this->end_date)) {
            $this->status = 4; //completed
        } else {
            $this->status = 3; //terminated
        }

        $history = new CarHistory;
        $history->car_id = $this->car_id;
        $history->comments = $this->status == 4 ? 'car contract completed' : 'car contract terminated';
        $this->histories()->save($history);
        $this->save();

    }


}
