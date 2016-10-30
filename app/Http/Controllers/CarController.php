<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCarRequest;
use App\Investor;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Car;
use Illuminate\Support\Facades\Auth;
use Log;

class CarController extends Controller
{
    // API METHODS

    public function api_all()
    {
        return Car::with('investor')->get();
    }

    public function api_get($id)
    {
        return Car::find($id);
    }

    public function api_update(Request $request)
    {
        $investor_id = $request->input('investor')['id'];
        //$investor = Investor::find($investor_id);

        $car = Car::find($request->input('id'));
        $car->reg_no = $request->input('reg_no');
        $car->make = $request->input('make');
        $car->available_since = $request->input('available_since');
        $car->investor_id = $investor_id;

        $car->save();
        //$investor->cars()->save($car);

        if ($car->investor_id == $investor_id)
            return response("Update successful");
        else
            return response("Update failed", 500);
    }

    public function api_new(Request $request)
    {
        $car = Car::create($request->all());
        $car->investor_id = $request->input('investor_id');
        $car->save();

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car]);

        return $car;
    }

    public function api_delete($id)
    {
        Car::destroy($id);
        return response("Deleted");
    }

    //---------------//
    public function index()
    {
        $carList = Car::orderBy('available_since')->get();
        return view('admin.car.index',compact('carList'));
    }
    public function create()
    {
        return view('admin.car.create');
    }

    public function store(RegisterCarRequest $request)
    {
        $c = Car::create($request->all());
        return redirect(url('/admin/car/all'));
    }
    public function all()
    {
        $carList = \Auth::user()->investor->cars()
            ->orderBy('created_at','desc')
            ->get();
        $carList->each(function($car){
           $car->available = Carbon::parse($car->available_since)->toFormattedDateString();
            $car->currentContract = $car->currentContract;
            $car->totalContracts=$car->totalContracts;
            $car->totalRevenue=$car->totalRevenue;
            $car->totalRent=$car->totalRent;

        });
        return $carList;
    }
    public function show($id)
    {
        $car = Car::findOrFail($id);

        return view('investor.assets.car.details', compact('car'));
    }

    public function update(Request $request)
    {


        $car = Car::find($request->input('id'));
        $car->reg_no = $request->input('reg_no');
        $car->make = $request->input('make');
        $dt_avail = new Carbon($request->input('available_since'));
        $car->available_since = $dt_avail->format("d-m-Y");
        $car->comments = $request->input('comments');
        $car->save();
        return redirect(url('/investor/cars/' . $car->id));


    }
}
