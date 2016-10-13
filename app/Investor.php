<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Investor extends Model
{
    use SoftDeletes;
    //
    protected $fillable =['name','email','phone','passport_num','dob'];

    protected $dates = ['dob', 'deleted_at'];

    public function user()
    {
        return $this->hasOne('App\User','email','email');
    }
    public function contracts()
    {
        return $this->hasManyThrough('App\Contract','App\Car');
    }
    public function cars()
    {
        return $this->hasMany('App\Car');
    }
    public function getDriversAttribute()
    {
        $contracts = $this->contracts;
        $drivers = collect([]);
        foreach($contracts as $contract)
        {
            $drivers->push($contract->driver);
        }

        return $drivers->unique('id')->flatten();
    }

    public function getAllRevenuesAttribute()
    {
        $contracts = $this->contracts;
        $revenues = collect([]);
        foreach ($contracts as $contract) {
            $revenues->push($contract->revenues);
        }

        return $revenues->flatten();
    }
    public function getRevenueAttribute()
    {
        $contracts = $this->contracts;
        $revenue = $contracts->reduce(function($carry, $contract){
           return  $carry + $contract->revenue;
        });
        return $revenue;

    }
    public function getRevenueForCurrentPeriodAttribute()
    {
        $contracts = $this->contracts;
        $revenue = $contracts->reduce(function($carry, $contract){
            return  $carry + $contract->revenueForCurrentPeriod;
        });
        return $revenue;

    }
    public function getPaidAttribute()
    {
        $contracts = $this->contracts;
        $rent = $contracts->reduce(function($carry, $contract){
            return  $carry + $contract->rent;
        });
        return $rent;
    }
    public function getPaidForCurrentPeriodAttribute()
    {
        $contracts = $this->contracts;
        $rent = $contracts->reduce(function($carry, $contract){
            return  $carry + $contract->rentForCurrentPeriod;
        });
        return $rent;
    }
    public function getBalanceAttribute()
    {
       return 0;
    }
    public function getBalanceForCurrentPeriodAttribute()
    {
       return 0;
    }

}
