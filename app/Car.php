<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['reg_no','make','available_since','comments'];

    protected $dates = ['deleted_at'];

    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }

    public function drivers()
    {
        return $this->belongsToMany('App\Driver','contracts');
    }

    public function investor()
    {
        return $this->belongsTo('App\Investor');
    }

    public function revenues()
    {
        return $this->hasManyThrough('App\Revenue','App\Contract');
    }

    public function getCurrentContractAttribute()
    {
        return $this->contracts()->ongoing()->first();
    }
    public function getTotalRevenueAttribute()
    {
        $contracts =  $this->contracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenue;
        }
        return $revenue;

    }
    public function getTotalRentAttribute()
    {
        $contracts =  $this->contracts;
        $rent = 0;
        foreach ($contracts as $contract){
            $rent += $contract->rent;
        }
        return $rent;

    }
    public function getTotalRevenueForCurrentPeriodAttribute()
    {
        $contracts =  $this->contracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenueForCurrentPeriod;
        }
        return $revenue;

    }
    public function getTotalRentForCurrentPeriodAttribute()
    {
        $contracts =  $this->contracts;
        $rent = 0;
        foreach ($contracts as $contract){
            $rent += $contract->rentForCurrentPeriod;
        }
        return $rent;

    }
    public function getTotalWeeksAttribute()
    {
        $av_since = Carbon::parse($this->available_since);

        return Carbon::now()->diffInWeeks($av_since,true);
    }
    public function getTotalContractsAttribute()
    {
        return ($this->contracts()->count());
    }
    public function getCurrentDriverAttribute()
    {
        return $this->currentContract->driver;
    }
    public function setAvailableSinceAttribute($value)
    {
        $this->attributes['available_since'] = Carbon::createFromFormat('d-m-Y',$value);
    }
    public function setRegNoAttribute($value)
    {
        $this->attributes['reg_no'] = strtoupper($value);
    }


}

