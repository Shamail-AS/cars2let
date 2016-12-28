<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;
    //
    protected $guarded = ['id', 'investor_id', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['deleted_at', 'first_reg_date', 'pco_expires_at', 'warranty_exp_at', 'road_side_exp_at', 'road_tax_exp_at'];

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

    public function order()
    {
        return $this->hasOne('App\CarOrder');
    }

    public function tickets()
    {
        return $this->hasMany('App\CarTicket');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Delivery');
    }

    public function policies()
    {
        return $this->belongsToMany('App\Policy');
    }

    public function supplier()
    {
        return $this->hasOne('App\Supplier');
    }

    public function cameras()
    {
        return $this->hasMany('App\Camera');
    }

    public function trackers()
    {
        return $this->hasMany('App\Tracker');
    }

    //==========================================================================//
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
        try {
            $this->attributes['available_since'] = Carbon::createFromFormat('d-m-Y', $value);
        } catch (\InvalidArgumentException $e) {
            $this->attributes['available_since'] = Carbon::createFromFormat('Y-m-d', $value);

        }
    }

    public function setRegNoAttribute($value)
    {
        $this->attributes['reg_no'] = strtoupper($value);
    }


}

