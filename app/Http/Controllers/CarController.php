<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Car;

class CarController extends Controller
{
    //
    public function index()
    {
        $carList = Car::all();
        return view('admin.car.index',compact('carList'));
    }
    public function create()
    {
        return view('admin.car.create');
    }
    public function store(Request $request)
    {
        $car = Car::create($request->all());
        return redirect(url('/admin/car'));
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
}
