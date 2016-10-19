<?php

namespace App\Http\Controllers;

use App\Car;
use App\Contract;
use App\Contracts;
use App\Driver;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AssetController extends Controller
{
    public function create($item)
    {
        if ($item == 'car')
            return view('investor.assets.car.create');
        else if ($item == 'contract')
            return view('investor.assets.contract.create');
        else if ($item == 'driver')
            return view('investor.assets.driver.create');
        else redirect(url('/investor/cars'));
    }

    public function partialCreate($item)
    {
//        if($item == 'car')
//            return view('investor.assets.car.create');
//        else if($item == 'contract')
//            return view('investor.assets.contract.create');
        if ($item == 'driver')
            return view('partials.driver-create');
        else redirect(url('/investor/cars'));
    }

    public function storeCar(Request $request)
    {

        $car = Car::create($request->all());
        $investor = \Auth::user()->investor;
        $investor->cars()->save($car);
        return redirect('/investor/cars/');
    }

    public function storeContract(Request $request)
    {

        $contract = new Contract();
        $df = new Carbon($request->input('start_date'));
        $dt = new Carbon($request->input('end_date'));
        $contract->start_date = $df;
        $contract->end_date = $dt;
        $contract->rate = (float)$request->input('rate');
        $contract->currency = "GBP";
        $contract->status = $request->input('status');
        $contract->car_id = $request->input('car');
        $contract->driver_id = $request->input('driver');

        $contract->save();
        return redirect('/investor/contracts');
    }

    public function storeDriver(Request $request)
    {
        $driver = Driver::create($request->all());
        $driver->save();
        return redirect('investor/drivers');
    }

}
