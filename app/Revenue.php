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
    public function scopeCurrentPeriod($query){
        //ASSUMPTION period = month starting from Fridays

        $period_start = new Carbon('first friday of this month');
        $period_end = new Carbon('last Friday'); //previous or most recent Friday
        $period_end->addDays(1)->addSecond(-1); //this includes all data on the Friday
        return $query->where('created_at', '>=', $period_start)
            ->where('created_at', '<=', $period_end);
    }

    public function getWeekPaidOnAttribute()
    {
        $contract_start = $this->contract->start_date;
        return $contract_start->diffInWeeks($this->created_at, false);

    }


}
