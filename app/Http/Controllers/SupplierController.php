<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\Supplier;
use Illuminate\Support\Facades\Auth;
use Log;

class SupplierController extends Controller
{

    public function api_all()
    {
        $suppliers = Supplier::all();
        return $suppliers;
    }


    public function index($car_id)
    {
        if($car_id){
            $car = Car::findorFail($car_id);
            if($car->supplier) {
                $car_supplier = $car->supplier;
                $car_supplier->car = $car;
                return $car;
            }
            else
                return response("No Supplier of this car", 404);
        }
        else {
            return Supplier::with('car')->get();
        }
	}


	// public function store(Request $request,$car_id)
 //    {
 //        // Finding if the car id is correct
 //        $car = Car::findOrFail($car_id);

 //        // Finding if the user id is correct
 //        if($request->auth_user_id)
 //            $auth_user = User::findOrFail($request->auth_user_id);

 //        // Creating a car order
 //        $car_order = CarOrder::create($request->all());
 //        $car->order()->save($car_order);
 //        $supplier->order()->save($car_order);
 //        if($request->auth_user_id)
 //            $auth_user->carOrders()->save($car_order);
 //        // Get an instance of Monolog
 //        $monolog = Log::getMonolog();
 //        // Choose FirePHP as the log handler
 //        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
 //        // Start logging
 //        $monolog->debug('Created', [$car]);
 //        return $car_order;
 //    }
}
