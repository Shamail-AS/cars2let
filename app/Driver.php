<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * App\Driver
 *
 * @property integer $id
 * @property string $license_no
 * @property string $pco_license_no
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property \Carbon\Carbon $dob
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property string $address
 * @property string $passport
 * @property string $pass_exp_at
 * @property string $nationality
 * @property string $emerg_person
 * @property string $emerg_num
 * @property integer $years_in_uk
 * @property string $pco_expires_at
 * @property string $licence_exp_at
 * @property string $type
 * @property string $nino
 * @property string $right_to_work
 * @property integer $driving_since
 * @property integer $penalty_points
 * @property string $history
 * @property boolean $can_dbs_check
 * @property boolean $dbs_checked
 * @property integer $bank_account_id
 * @property string $pay_method
 * @property integer $week_pay_day
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Contract[] $contracts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Car[] $cars
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankAccount[] $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarTicket[] $tickets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\DriverConviction[] $convictions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarAccident[] $accidents
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SiteFile[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\ContractHandover[] $handovers
 * @property-read mixed $age
 * @property-read mixed $current_contract
 * @property-read mixed $total_weeks
 * @property-read mixed $total_revenue
 * @property-read mixed $total_paid
 * @property-read mixed $total_revenue_for_current_period
 * @property-read mixed $total_paid_for_current_period
 * @property-read mixed $total_contracts
 * @property-read mixed $current_car
 * @property-read mixed $investor_contracts
 */
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
    public function accidents()
    {
        return $this->hasMany('App\CarAccident');
    }
    public function files()
    {
        return $this->morphMany('App\SiteFile', 'origin');
    }

    public function handovers()
    {
        return $this->hasMany('App\ContractHandover');
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
