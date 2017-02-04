<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Log;
use Mockery\CountValidator\Exception;

/**
 * App\Investor
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property \Carbon\Carbon $dob
 * @property string $passport_num
 * @property string $phone
 * @property \Carbon\Carbon $acc_period_start
 * @property \Carbon\Carbon $acc_period_end
 * @property string $tracking_url
 * @property string $company
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Car[] $cars
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\BankAccount[] $bank
 * @property-read mixed $drivers
 * @property-read mixed $all_revenues
 * @property-read mixed $revenue
 * @property-read mixed $revenue_for_current_period
 * @property-read mixed $revenue_for_next_period
 * @property-read mixed $paid
 * @property-read mixed $paid_for_current_period
 * @property-read mixed $paid_for_next_period
 * @property-read mixed $balance
 * @property-read mixed $balance_for_current_period
 * @property-read mixed $balance_for_next_period
 */
class Investor extends Model
{
    use SoftDeletes;
    //
    protected $fillable = ['name', 'email', 'phone', 'passport_num', 'dob', 'tracking_url', 'acc_period_start', 'acc_period_end'];

    protected $dates = ['dob', 'deleted_at', 'acc_period_start', 'acc_period_end'];

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

    public function bank()
    {
        return $this->morphMany('App\BankAccount', 'owner');
    }

    public function getAccountingPeriods($back_shift = 0)
    {
        $dt_start = $this->acc_period_start;
        $dt_end = $this->acc_period_end;
        $duration = $dt_start->diffInMinutes($dt_end) + 1440;//add an extra day

        $period_start = $this->periodStart()->addMinutes($back_shift * $duration);

        $period_end = $this->periodEnd()->addMinutes($back_shift * $duration);

//        // Get an instance of Monolog
//        $monolog = Log::getMonolog();
//        // Choose FirePHP as the log handler
//        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
//        // Start logging
//        $monolog->debug($back_shift, [$period_start,$period_start->copy()->addMinutes($duration),$period_end,$period_end->copy()->addMinutes($duration)]);

        return [$period_start, $period_end];
    }
    public function getDriversAttribute()
    {
        $contracts = $this->contracts()->approved()->get();
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

    public function getRevenueForNextPeriodAttribute()
    {
        $contracts = $this->contracts;
        $revenue = $contracts->reduce(function ($carry, $contract) {
            return $carry + $contract->revenueForNextPeriod;
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

    public function getPaidForNextPeriodAttribute()
    {
        $contracts = $this->contracts;
        $rent = $contracts->reduce(function ($carry, $contract) {
            return $carry + $contract->rentForNextPeriod;
        });
        return $rent;
    }
    public function getBalanceAttribute()
    {
        return $this->revenue - $this->paid;
    }
    public function getBalanceForCurrentPeriodAttribute()
    {
        return $this->revenueForCurrentPeriod - $this->paidForCurrentPeriod;
    }

    public function getBalanceForNextPeriodAttribute()
    {
        return $this->revenueForNextPeriod - $this->paidForNextPeriod;
    }

    public function setDobAttribute($value)
    {
        try {
            $this->attributes['dob'] = Carbon::createFromFormat('d-m-Y', $value);
        } catch (\InvalidArgumentException $e) {
            $this->attributes['dob'] = Carbon::createFromFormat('Y-m-d', $value);
        }

    }

    public function periodStart()
    {
        $dt = $this->acc_period_start;
        return Carbon::createFromDate(Carbon::now()->year
            , $dt->month
            , $dt->day);
    }

    public function periodEnd()
    {
        $dt_end = $this->acc_period_end;
        $dt_start = $this->acc_period_start;
        $in_same_year = $dt_end->month > $dt_start->month;
        return Carbon::createFromDate(Carbon::now()->addYears($in_same_year ? 0 : 1)->year
            , $dt_end->month
            , $dt_end->day);
    }

    public function setAccPeriodStartAttribute($value)
    {
        if (is_integer($value)) {
            $this->attributes['acc_period_start'] = Carbon::createFromTimestamp(strval($value));
        }
    }

    public function setAccPeriodEndAttribute($value)
    {
        if (is_integer($value)) {
            $this->attributes['acc_period_end'] = Carbon::createFromTimestamp(strval($value));
        }

    }

}
