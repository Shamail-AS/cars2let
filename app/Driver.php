<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Driver extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['dob', 'deleted_at'];

    protected $guarded = ['id'];

    public function contracts()
    {
        return $this->hasMany('App\Contract');
    }
    public function cars()
    {
        return $this->belongsToMany('App\Car','contracts');
    }
    public function revenues()
    {
        return $this->hasManyThrough('App\Revenue','App\Contracts');
    }

    public function bank()
    {
        return $this->morphMany('App\BankAccount', 'owner');
    }

    public function tickets()
    {
        return $this->hasMany('App\CarTicket');
    }

    public function convictions()
    {
        return $this->hasMany('App\DriverConviction');
    }

    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }
    public function setDobAttribute($value)
    {
        try {
            $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value);
        } catch (\InvalidArgumentException $e) {
            $this->attributes['dob'] = Carbon::createFromFormat('Y-m-d', $value);

        }
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
        $contracts = $this->investorContracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenue;
        }
        return $revenue;

    }
    public function getTotalPaidAttribute()
    {
        $contracts = $this->investorContracts;
        $rent = 0;
        foreach ($contracts as $contract){
            $rent += $contract->rent;
        }
        return $rent;

    }

    //---------------------------------

    public function getTotalRevenueForCurrentPeriodAttribute()
    {
        $contracts = $this->investorContracts;
        $revenue = 0;
        foreach ($contracts as $contract){
            $revenue += $contract->revenueForCurrentPeriod;
        }
        return $revenue;

    }
    public function getTotalPaidForCurrentPeriodAttribute()
    {
        $contracts = $this->investorContracts;
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

    public function isForInvestor($contract)
    {
        return $contract->investor->id == Auth::user()->investor->id;
    }

    public function getInvestorContractsAttribute()
    {
        //$id = Auth::user()->investor->id;
        $data = collect([]);
        foreach ($this->contracts as $contract) {
            if ($contract->investor->id)
                $data->push($contract);
        }
        return $data;
    }
}
