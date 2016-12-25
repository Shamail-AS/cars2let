<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Camera;
use App\Supplier;
use App\Car;
use App\Tracker;
use Log;
class TrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id)
    {
        $car = Car::findOrFail($car_id);
        $trackers = $car->trackers;
        $trackers->each(function($tracker){
           $tracker->car = $tracker->car;
        });
        return $trackers;    
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
        $supplier = Supplier::findOrFail($request->supplier_id);
        // Creating a tracker
        $tracker = Tracker::create($request->all());
        $car->trackers()->save($tracker);
        $supplier->trackers()->save($tracker);
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$tracker]);
        return $tracker;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $tracker_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($tracker= $car->tickets()->where('id', $tracker_id)->first()))
            // Show 404.
            return response("This tracker does'nt belong to this car", 404);

        if($request->imei)
            $tracker->imei = $request->imei;
        if($request->model)
            $tracker->model = $request->model;
        if($request->installed_at)
            $tracker->installed_at = $request->installed_at;
        if($request->status)
            $tracker->status = $request->status;
        if($request->comments)
            $tracker->comments = $request->comments;
        if($request->supplier_id) {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $supplier->cameras()->save($tracker);
        }
        if($tracker->save())
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
    public function destroy($car_id, $tracker_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($tracker = $car->cameras()->where('id', $camera_id)->first()))
            // Show 404.
            return response("This tracker does'nt belong to this car", 404);

        $tracker->delete();
    }
}
