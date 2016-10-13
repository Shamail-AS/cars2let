<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['dob', 'deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'license_no',
        'phone',
        'dob',
    ];
    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }
    public function cars()
    {
        return $this->belongsToMany('App\Car','contracts');
    }
    public function investors()
    {
        return $this->belongsToMany('App\Investor','contracts');
    }
    public function revenues()
    {
        return $this->hasManyThrough('App\Revenue','App\Contracts');
    }
    public function setDobAttribute($value)
    {
        $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y',$value);
    }

    public function getAgeAttribute()
    {
        return $this->dob->diffInYears(Carbon::now(),true);
    }
    public function getCurrentContractAttribute()
    {
        return $this->contracts()->ongoing()->first();
    }
    public function getTotalWeeksAttribute()
    {
        $av_since = Carbon::parse($this->created_at);

        return Carbon::now()->diffInWeeks($av_since,true);
    }

    //-----------------------

    public function getTotalRevenueAttribute()
    {
        $contracts =  $this->contracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenue;
        }
        return $revenue;

    }
    public function getTotalPaidAttribute()
    {
        $contracts =  $this->contracts;
        $rent = 0;
        foreach ($contracts as $contract){
            $rent += $contract->rent;
        }
        return $rent;

    }

    //---------------------------------

    public function getTotalRevenueForCurrentPeriodAttribute()
    {
        $contracts =  $this->contracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenueForCurrentPeriod;
        }
        return $revenue;

    }
    public function getTotalPaidForCurrentPeriodAttribute()
    {
        $contracts =  $this->contracts;
        $rent = 0;
        foreach ($contracts as $contract){
            $rent += $contract->rentForCurrentPeriod;
        }
        return $rent;

    }

    //-----------------------

    public function getTotalContractsAttribute()
    {
        return ($this->contracts()->count());
    }
    public function getCurrentCarAttribute()
    {
        return $this->currentContract->car;
    }
}
