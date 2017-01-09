<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Camera;
use App\Supplier;
use App\Car;
use Log;
class CameraController extends Controller
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
            $cameras = $car->cameras;
            $cameras->each(function($camera){
               $camera->car = $camera->car;
                $camera->supplier = $camera->supplier;
                $camera->order = $camera->orders()->with('supplier', 'deliveries')->first();
            });
            return collect($cameras)->first();
        }
        else {
            return Camera::with('car', 'supplier', 'orders.supplier', 'orders.deliveries')->first();
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
            $car = $car = Car::findOrFail($request->car_id); 
        $supplier = Supplier::findOrFail($request->supplier_id);
        // Creating a camera
        $camera = Camera::create($request->all());
        $car->cameras()->save($camera);
        $supplier->cameras()->save($camera);
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$camera]);
        return Camera::with('supplier')->where('id', $camera->id)->first();
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
    public function update(Request $request, $car_id, $camera_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($camera = $car->cameras()->where('id', $camera_id)->first()))
            // Show 404.
            return response("This camera doesn't belong to this car", 404);

        if($request->model)
            $camera->model = $request->model;
        if($request->installed_at)
            $camera->installed_at = $request->installed_at;
        if($request->status)
            $camera->status = $request->status;
        if($request->comments)
            $camera->comments = $request->comments;
        if($request->supplier_id) {
            $supplier = Supplier::findOrFail($request->supplier_id);
            $supplier->cameras()->save($camera);
        }
        if($camera->save())
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
    public function destroy($car_id, $camera_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($camera = $car->cameras()->where('id', $camera_id)->first()))
            // Show 404.
            return response("This camera does'nt belong to this car", 404);

        $camera->delete();
    }
}
