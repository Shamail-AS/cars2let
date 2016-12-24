<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\Delivery;
use App\User;
use App\CarOrder;

use Log;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request,$car_id)
    {
        // Finding if the car id is correct
        $car = Car::findOrFail($car_id);
        // Finding if the user id is correct
        $rec_user = User::findOrFail($request->rec_user_id);
        // find if supplier id is correct
        $order = CarOrder::findOrFail($request->order_id);

        // Creating a delivery
        $delivery = Delivery::create($request->all());
        $car->deliveries()->save($delivery);
        $order->deliveries()->save($delivery);
        $rec_user->deliveries()->save($delivery);
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car]);
        return $delivery;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($car_id,$delivery_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($delivery = $car->deliveries()->where('id', $delivery_id)->first()))
            // Show 404.
            abort(404);
        // sending the delivery info
        $delivery->order = $delivery->order;
        // sending car info
        $delivery->car = $car;
        // return the car object
        return $delivery;
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id,$delivery_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($delivery= $car->tickets()->where('id', $delivery_id)->first()))
            // Show 404.
            abort(404);
        if($request->scheduled_at)
            $delivery->scheduled_at = $request->scheduled_at;
        if($request->delivered_at)
            $delivery->delivered_at = $request->delivered_at;
        if($request->recieved_by)
            $delivery->recieved_by = $request->recieved_by;
        if($request->recieved_by)
            $delivery->recieved_by = $request->recieved_by;
        if($request->rec_user_id) {
            $rec_user = User::findOrFail($request->rec_user_id);
            $rec_user->deliveries()->save($delivery);
        }
        if($request->comments)
            $delivery->comments = $request->comments;
        if($request->type)
            $delivery->type = $request->type;
        if($request->order_id){
            $order = CarOrder::findOrFail($request->order_id);
            $order->deliveries()->save($delivery);
        }
        if($request->condition)
            $delivery->condition = $request->condition;
        if($request->odo_reading)
            $delivery->odo_reading = $request->odo_reading;
        if($request->location)
            $delivery->location = $request->location;
        if($delivery->save())
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
    public function destroy($car_id,$delivery_id)
    {
        //
        $car = Car::findOrFail($car_id);
        if (!($delivery = $car->deliveries()->where('id', $delivery_id)->first()))
            // Show 404.
            abort(404);
        $delivery->delete($delivery_id);
    }
}
