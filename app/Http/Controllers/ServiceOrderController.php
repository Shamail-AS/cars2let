<?php

namespace App\Http\Controllers;

use App\Delivery;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\CarServiceOrder;
use App\Supplier;
use App\InsuranceClaim;
use App\CarHistory;
use App\User;
use Log;
class ServiceOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id = null)
    {
        if($car_id){
            return CarServiceOrder::where('car_id', $car_id)->with('supplier', 'car', 'deliveries')->get();
        }
        else {
            return CarServiceOrder::with('car', 'supplier', 'deliveries')->get();
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
    public function store(Request $request, $car_id=null)
    {
        //TODO: Record a car delivery, the information is present in the request
        //TODO: fix the Grammar::parameterize error its the model::create method

        // Finding if the car id is correct
        if($car_id)
            $car = Car::findOrFail($car_id);
        else
            $car = Car::findOrFail($request->car_id);
        // Finding the supplier
        $supplier = Supplier::findorFail($request->supplier_id);
        $delivery = $request->delivery;
        $data = $request->all();

        unset($data['delivery']);

        // Finding if the user id is correct
        if($request->auth_user_id)
            $auth_user = User::findOrFail($request->auth_user_id);
        // Creating a car ticket
        $car_service_order = CarServiceOrder::create($data);
        $car->serviceOrders()->save($car_service_order);
        $supplier->serviceOrders()->save($car_service_order);
        //$insurance->serviceOrder()->save($car_service_order);
        $history = new CarHistory;
        $history->car_id = $car->id;
        $history->comments = "car ordered";
        $car_service_order->histories()->save($history);

        if (strlen($delivery['scheduled_at']) > 0) {
            $delivery = Delivery::create($delivery);
            $car_service_order->deliveries()->save($delivery);
            $car->deliveries()->save($delivery);
        }

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car_service_order]);

        return CarServiceOrder::with('supplier', 'car', 'deliveries')->find($car_service_order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($car_id,$service_order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_service_order = $car->serviceOrders()->where('id', $service_order_id)
            ->with('supplier', 'car', 'deliveries')
            ->first())
        )
            // Show 404.
            return response("This ticket doesn't belong to this car", 404);

        return $car_service_order;
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
    public function update(Request $request, $car_id,$service_order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_service_order = $car->serviceOrders()->where('id', $service_order_id)->first()))
            // Show 404.
            return response("This Service does'nt belong to this car", 404);
        if($request->supplier_id){
            $supplier = Supplier::findorFail($request->supplier_id);
            $car_service_order->supplier_id = $request->supplier_id;
        }
        if($request->auth_user_id){
            $user = User::findOrFail($request->auth_user_id);
            $car_service_order->auth_user_id = $request->auth_user_id;
        }
        if($request->auth_user){
            $car_service_order->auth_user = $request->auth_user;
        }
        if($request->status) {
            $car_service_order->status = $request->status;
        }
        if($request->comments) {
            $car_service_order->comments = $request->comments;
        }
        if($request->type) {
            $car_service_order->type  = $request->type;
        }
        if($request->handover_date) {
            $car_service_order->handover_date  = $request->handover_date;
        }
        if($request->handover_person) {
            $car_service_order->handover_person  = $request->handover_person;
        }
        if ($request->delivery) {
            $delivery = $request->delivery;
            $old_delivery = Delivery::find($delivery['id']);
            $old_delivery->scheduled_at = $delivery['scheduled_at'];
            $old_delivery->location = $delivery['location'];
            $old_delivery->comments = $delivery['comments'];
            $old_delivery->save();
        }
        // TODO: ADD INSURANCE CLAIMS ONCE FIELDS AND WORKFLOW IS DECIDED
//        if($request->insurance_claim_id){
//            $insurance = InsuranceClaim::findOrFail($request->insurance_claim_id);
//            $car_service_order->insurance_claim_id = $request->insurance_claim_id;
//        }
        if($request->cost) {
            $car_service_order->cost  = $request->cost;
        }
        if($car_service_order->save())
            return CarServiceOrder::with('supplier', 'car', 'deliveries')->find($car_service_order->id);
        else
            return response("Update failed", 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($car_id,$service_order_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_service_order = $car->order()->where('id', $service_order_id)->first()))
            // Show 404.
            return response("This Service does'nt belong to this car", 404);
        $car_service_order->delete();    
    }
}
