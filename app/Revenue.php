<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array|string amount_paid
 */
class Revenue extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];

    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }

    public function getInvestorAttribute()
    {
        return $this->contract->car->investor;
    }

    public function forCurrentPeriod()
    {
        $investor = $this->investor;
        $dt_start = $investor->acc_period_start;
        $dt_end = $investor->acc_period_end;

        $period_start = Carbon::createFromDate(Carbon::now()->year
            , $dt_start->month
            , $dt_start->day);

        $in_same_year = $dt_end->month > $dt_start;

        $period_end = Carbon::createFromDate(Carbon::now()->addYears($in_same_year ? 0 : 1)->year
            , $dt_end->month
            , $dt_end->day);

        return $this->inPeriod($period_start, $period_end);

    }

    public function forPreviousPeriod($back_shift = 1)
    {
        $investor = $this->investor;
        $dt_start = $investor->acc_period_start;
        $dt_end = $investor->acc_period_end;


        $period_start = Carbon::createFromDate(Carbon::now()->subYear($back_shift)->year
            , $dt_start->month
            , $dt_start->day);

        $in_same_year = $dt_end->month > $dt_start;

        $period_end = Carbon::createFromDate(Carbon::now()->subYear($back_shift)->addYears($in_same_year ? 0 : 1)->year
            , $dt_end->month
            , $dt_end->day);

        return $this->inPeriod($period_start, $period_end);
    }

    public function inPeriod($period_start, $period_end)
    {
        return ($this->created_at >= $period_start && $this->created_at <= $period_end);
    }

    public function getWeekPaidOnAttribute()
    {
        $contract_start = $this->contract->start_date;
        return $contract_start->diffInWeeks($this->created_at, false);

    }


}
