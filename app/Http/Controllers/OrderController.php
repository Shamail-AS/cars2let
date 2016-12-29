<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\CarOrder;
use App\Car;
use App\User;
use App\Supplier;
use App\CarHistory;
use Illuminate\Support\Facades\Auth;
use Log;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id = null)
    {
        if($car_id){
            $car = Car::findorFail($car_id);
            if($car->order) {
                $car_order = $car->order;
                $car_order->supplier = $car_order->supplier;
                $car_order->car = $car;
                return $car_order;
            }
            else
                return response("No Order of this car", 404);
        }
        else {
            return CarOrder::with('car','supplier')->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$car_id = null)
    {
        // Finding if the car id is correct
        if($car_id)
            $car = Car::findOrFail($car_id);
        else 
            $car = Car::findOrFail($request->car_id);
        // Finding if the user id is correct
        if($request->auth_user_id)
            $auth_user = User::findOrFail($request->auth_user_id);

            // find if supplier id is correct
        $supplier = Supplier::findOrFail($request->supplier_id);

        // Creating a car order
        $car_order = CarOrder::create($request->all());
        $car->order()->save($car_order);

        $supplier->order()->save($car_order);
        $history = new CarHistory;
        $history->car_id = $car->id;
        $history->comments = "car ordered";
        $car_order->histories()->save($history);
        if($request->auth_user_id)
            $auth_user->carOrders()->save($car_order);
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car]);
        return $car_order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($car_id,$order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_order = $car->order()->where('id', $order_id)->first()))
            // Show 404.
            return response("This ticket does'nt belong to this car", 404);

        // sending the supplier info
        $car_order->supplier = $car_order->supplier;
        // sending car info
        $car_order->car = $car;
        // return the car object
        return $car_order;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *@param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$car_id,$order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_order = $car->order()->where('id', $order_id)->first()))
            // Show 404.
            return response("This ticket does'nt belong to this car", 404);
        if($request->status)
            $car_order->status  = $request->status;
        if($request->comments)
            $car_order->comments = $request->comments;
        if($request->cost)
            $car_order->cost = $request->cost;
        if($request->supplier_id) {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $supplier->order()->save($car_order);
        }
        if($car_order->save())
            return response("Update successful");
        else
            return response("Update failed", 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id,$order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_order = $car->order()->where('id', $order_id)->first()))
            // Show 404.
            return response("This ticket does'nt belong to this car", 404);
        $car_order->delete();
    }
}
