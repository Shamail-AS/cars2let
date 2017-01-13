<?php

namespace App\Http\Controllers;

use App\CarServiceOrder;
use App\Contract;
use App\ContractHandover;
use App\Exceptions\Handler;
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
    public function index($car_id = null)
    {
        if($car_id){
            $deliveries = Delivery::where('car_id', $car_id)->with('order', 'car', 'receiver')->get();
            return $deliveries;
        }
        else 
            return Delivery::with('car')->get();
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
        $delivery = Delivery::create($request->all());
        // Finding if the user id is correct
        if ($request->rec_user_id) {
            $rec_user = User::findOrFail($request->rec_user_id);
            $rec_user->deliveries()->save($delivery);
        }
        // find if supplier id is correct
        if ($request->order_id) {
            try {
                $order = CarOrder::findOrFail($request->order_id);
                $order->deliveries()->save($delivery);
            } catch (\Exception $ex) {
                return response($ex->getMessage(), $ex->getCode());
            }
        }

        // Creating a delivery
        //dd($request->all());

        $car->deliveries()->save($delivery);

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
            return response("This delivery does'nt belong to this car", 404);

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
        if (!($delivery = $car->deliveries()->where('id', $delivery_id)->first()))
            // Show 404.
            return response("This delivery doesn't belong to this car", 404);

        if($request->scheduled_at)
            $delivery->scheduled_at = $request->scheduled_at;
        if($request->delivered_at)
            $delivery->delivered_at = $request->delivered_at;
        if($request->recieved_by)
            $delivery->recieved_by = $request->recieved_by;
        if ($request->received_by)
            $delivery->received_by = $request->received_by;
        if($request->rec_user_id) {
            $rec_user = User::findOrFail($request->rec_user_id);
            $rec_user->deliveries()->save($delivery);
        }
        if($request->comments)
            $delivery->comments = $request->comments;
        if($request->type)
            $delivery->type = $request->type;
        if($request->order_id){
            $order = null;
            try {
                if ($delivery->type == 'contract-handover') {
                    $order = ContractHandover::findOrFail($request->order_id);
                } else if ($delivery->type == 'car-order') {
                    $order = CarOrder::findOrFail($request->order_id);
                } else if ($delivery->type == 'service-order') {
                    $order = CarServiceOrder::findOrFail($request->order_id);
                }
                $order->deliveries()->save($delivery);
            } catch (\Exception $ex) {

                return response($ex->getMessage(), 404);
            }
        }
        if($request->condition)
            $delivery->condition = $request->condition;
        if($request->odo_reading)
            $delivery->odo_reading = $request->odo_reading;
        if($request->location)
            $delivery->location = $request->location;
        if ($request->status)
            $delivery->status = $request->status;
        if ($delivery->save()) {
            $delivery = $delivery->fresh();
            return $delivery;
        }
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
            return response("This delivery does'nt belong to this car", 404);

        $delivery->delete();
    }
}
