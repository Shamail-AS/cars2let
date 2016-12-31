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

    public function serviceOrders()
    {
        return $this->hasMany('App\CarServiceOrder');
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
    public function histories (){
        return $this->hasMany('App\CarHistory');
    }
    public function accidents (){
        return $this->hasMany('App\CarAccident');
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

    public function getNotificationsAttribute()
    {
        $notis = [
            'danger' => collect([]),
            'warning' => collect([]),
            'info' => collect([]),
            'other' => collect([])
        ];

        $alerts = $this->overview()['regular'];
        $now = Carbon::now();

        $date = $alerts['pco_exp'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('pco', $date)
            ]);
        }
        $date = $alerts['contract_finish'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('contract', $date)
            ]);
        }
        $date = $alerts['mot_due'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('mot', $date)
            ]);
        }
        $date = $alerts['mot_due'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('warranty', $date)
            ]);
        }
        $date = $alerts['roadside_exp'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('roadside', $date)
            ]);
        }

        $date = $alerts['road_tax_due'];
        $class = $this->getNotiClass($date, 31);
        if ($class != 'other') {
            $notis[$class]->push([
                'date' => $date,
                'message' => $this->getNotiMessage('tax', $date)
            ]);
        }

        return $notis;

    }

    private function getNotiMessage($type, $date)
    {
        $dateString = $date->toFormattedDateString();
        $lookup = [
            'pco' => [
                'title' => 'PCO Expiry : ' . $dateString,
                'text' => $date->diffForHumans()
            ],
            'contract' => [
                'title' => 'Contract Expiry : ' . $dateString,
                'text' => $date->diffForHumans()
            ],
            'mot' => [
                'title' => 'MOT due in: ' . $dateString,
                'text' => $date->diffForHumans()
            ],
            'warranty' => [
                'title' => 'Warranty Expiry: ' . $dateString,
                'text' => $date->diffForHumans()
            ],
            'roadside' => [
                'title' => 'Road side expiry: ' . $dateString,
                'text' => $date->diffForHumans()
            ],
            'tax' => [
                'title' => 'Road tax due: ' . $dateString,
                'text' => $date->diffForHumans()
            ]
        ];

        return $lookup[$type];
    }

    private function getNotiClass($date, $threshold)
    {

        $class = 'other';
        if ($date == null) return $class; // temp patch to workaround null date columns

        $now = Carbon::now();
        $days_left = $now->diffInDays($date, false);
        if ($days_left < -999) return $class; // temp patch to workaround null date columns

        if ($days_left < $threshold / 4)
            $class = 'danger';
        else if ($days_left < $threshold / 2)
            $class = 'warning';
        else if ($days_left < $threshold)
            $class = 'info';
        else
            $class = 'other';
        return $class;
    }

    public function overview()
    {

        $car = $this;
        $deliveries = $car->deliveries()->undelivered()->get();
        $current_contract = $car->currentContract;
        $orders = $car->order()->status('open')->first();
        $mot = $car->serviceOrders()->mot()->status('open')->first();

        $alerts = [
            'regular' => [
                'pco_exp' => $car->pco_expires_at,
                'contract_finish' => $current_contract != null ? $current_contract->end_date : null,
                'mot_due' => $mot != null ? $mot->booked_dt : null,
                'warranty_exp' => $car->warranty_exp_at,
                'roadside_exp' => $car->road_side_exp_at,
                'road_tax_due' => $car->road_tax_exp_at,
            ],
            'deliveries' => $deliveries,
            'orders' => $orders
        ];

        return collect($alerts);
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

