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
    protected $dates = ['start_date', 'end_date', 'deleted_at'];

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
    public function getInvestorAttribute()
    {
        return $this->car->investor;
    }

    public function scopeStatus($query,$status)
    {
        return $query->where('status',$status);
    }
    public function scopeOngoing($query)
    {
        return $query->where('status',1);
    }
    public function revenues()
    {
        return $this->hasMany('App\Revenue');
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('paid_on','desc');
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
        $revenues = $this->revenues()->currentPeriod()->get();
        $rent = 0;
        foreach ($revenues as $revenue) {
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
        //ASSUMPTION period is month from fridays
        //TODO: MAKE USE OF ACC_PERIOD_DAYS

        $date_from = new Carbon('first friday of this month');
        $date_to = new Carbon('last friday');
        $diff_month = $date_to->diffInWeeks($date_from);
        return min($diff_month,$this->weeksDone);
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


}
