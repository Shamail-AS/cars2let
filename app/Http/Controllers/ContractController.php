<?php

namespace App\Http\Controllers;

use App\Contract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    //
    public function all()
    {

        $collection = Auth::user()->investor->contracts()
            ->with('car', 'driver')
            ->orderBy('created_at', 'desc')->get();
        foreach ($collection as $contract) {
            //$contract->revenues = $contract->revenues;
            $contract->revenue = $contract->revenue;
            $contract->rent = $contract->rent;
            $contract->weeksDone = $contract->weeksDone;
            $contract->weeksTotal = $contract->weeksTotal;
            $contract->car_reg = $contract->car->reg_no;
            $contract->driver_name = $contract->driver->name;
            unset($contract->car);
            unset($contract->driver);
            unset($contract->investor);

        }
        return $collection;
    }

    public function show($id)
    {
        //Angular will parse the id in the url
        return view('investor.assets.contract.details');
    }

    public function api_show($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues;
        foreach ($revenues as $rev) {
            $w = $rev->weekPaidOn;
        }


        $driver = $contract->driver;
        $car = $contract->car;
        $investor = $contract->investor;

        return $contract;
    }

    public function filterContractsByCarDriver($search)
    {
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $search)
            ->orWhere('drivers.name', 'LIKE', $search)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function filterContractsByCarAndDriver($search)
    {
        $reg_no = substr($search, 0, strpos($search, 'and'));
        $driver_name = substr($search, strpos($search, 'and') + 3);
        if (strpos($driver_name, '-') > 0) // driver name is reg_no
        {
            //swap
            $temp = $driver_name;
            $driver_name = $reg_no;
            $reg_no = $temp;
        }

        //dd(['1'=>$reg_no,'2'=>$driver_name]);
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $reg_no)
            ->where('drivers.name', 'LIKE', $driver_name)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function filterContractsByCarOrDriver($search)
    {
        $reg_no = substr($search, 0, strpos($search, 'or'));
        $driver_name = substr($search, strpos($search, 'or') + 2);
        if (strpos($driver_name, '-') > 0) // driver name is reg_no
        {
            //swap
            $temp = $driver_name;
            $driver_name = $reg_no;
            $reg_no = $temp;
        }

        //dd(['1'=>$reg_no,'2'=>$driver_name]);
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $reg_no)
            ->orWhere('drivers.name', 'LIKE', $driver_name)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function ContractRevenueSummary($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues;
        $rate = (float)$contract->rate;
        $data = [];
        $max_week = $revenues->max('weekPaidOn');
        if ($max_week === null) return $data;
        //dd($max_week);


        $grouped_revs = $revenues->groupBy('weekPaidOn');
        $summed_revs = $grouped_revs->transform(function ($item, $key) {
            return [
                'week' => $key,
                'revenue' => -1,
                'paid' => $item->reduce(function ($carry, $item) {
                    return $carry + (float)$item->amount_paid;
                }),
                'balance' => -1
            ];
        });
        for ($i = 0; $i <= $max_week; $i++) {
            if (isset($summed_revs[$i])) {
                $data[$i] = $summed_revs[$i];
                $data[$i]['revenue'] = $rate;
                $data[$i]['balance'] = 0;
            } else {
                $data[$i] = [
                    'week' => $i,
                    'revenue' => $rate,
                    'paid' => 0,
                    'balance' => 0
                ];
            }

        }


        return $data;
    }

    public function  ContractRevenueDetail($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues->groupBy('weekPaidOn');
        $revenues->transform(function ($item, $key) {
            return $item->transform(function ($item, $key) {
                return [
                    'week' => $item->weekPaidOn,
                    'date' => $item->paid_on->toFormattedDateString(),
                    'amount' => $item->amount_paid
                ];
            });
        });
        return ($revenues);

    }
}
