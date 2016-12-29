<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\Driver;
use App\CarAccident;
use App\CarHistory;
use Log;
class AccidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id = null)
    {
        if($car_id){
            $car = Car::findOrFail($car_id);
            $accidents = $car->accidents;
            $accidents->each(function($accident){
               $accident->car = $accident->car;
               $accident->driver = $accident->driver;
            });
            return $accidents;
        }
        else {
            return CarAccident::with('car','driver')->get();
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
    public function store(Request $request, $car_id = null)
    {
        if($car_id)
            $car = Car::findOrFail($car_id);
        else 
            $car = Car::findOrFail($request->car_id);
        $driver = Driver::findOrFail($request->driver_id);
        $car_accident = CarAccident::create($request->all());
        $car->accidents()->save($car_accident);
        $driver->accidents()->save($car_accident);
        $history = new CarHistory;
        $history->car_id = $car->id;
        $history->comments = "car had accident";
        $car_accident->histories()->save($history);
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car_accident]);
        return $car_accident;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $car_id, $accident_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($accident= $car->accidents()->where('id', $accident_id)->first()))
            // Show 404.
            return response("This accident does'nt belong to this car", 404);

        if($request->driver_id){
            $driver = Driver::findOrFail($driver_id);
            $accident->driver_id = $request->driver_id;
        }
        if($request->time_of_accident)
            $accident->time_of_accident = $request->time_of_accident;
        if($request->type_of_accident)
            $accident->type_of_accident = $request->type_of_accident;
        
        if($accident->save())
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
    public function destroy($car_id,$accident_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($accident = $car->accidents()->where('id', $accident_id)->first()))
            // Show 404.
            return response("This accident does'nt belong to this car", 404);

        $accident->delete();
    }
}
