<?php

namespace App\Http\Controllers;

use App\CarServiceOrder;
use App\Contract;
use App\ContractHandover;
use App\Exceptions\Handler;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;
use App\Car;
use App\Delivery;
use App\User;
use App\CarOrder;
use App\SiteFile;
use Storage;
use Image;
use PDF;
use Zipper;
use File;

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

    public function imagesView($delivery_id){
        $delivery = Delivery::findOrFail($delivery_id);
        return view('admin.deliveries.show', compact('delivery'));
    }

    public function attach($delivery_id, Request $request){
        $ext = ['jpg','jpeg','png','JPG','gif'];
        $delivery = Delivery::findOrFail($delivery_id);
        if($request->file('file')){
            foreach($request->file('file') as $file){
                if ($file->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    if(in_array($extension, $ext)){
                       $stored_file = Storage::disk('s3')->put('deliveries/'.$fileName, file_get_contents($file));
                    }
                    else {
                        continue;
                    }
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/deliveries/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $delivery->files()->save($site_file);
                }
                else return response("Invalid file", 404);
            }
            return back();
        }
        return response("Attachment not found", 404);
    }

    public function deleteFile($delivery_id,$file_id){
        SiteFile::destroy($file_id);
        return back();
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
