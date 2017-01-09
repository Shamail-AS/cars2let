<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\Driver;
use App\CarAccident;
use App\CarHistory;
use App\SiteFile;
use Log;
use Storage;
use Image;
use PDF;
use Zipper;
use File;
use Illuminate\Support\Str;

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
        return CarAccident::with('car', 'driver')->where('id', $car_accident->id)->get()->first();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($car_id,$accident_id)
    {
        $car = Car::findOrFail($car_id);
        $accident = CarAccident::findOrFail($accident_id);
        return view('admin.car.accident_show',['accident'=>$accident]);
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

        if ($request->driver_id)
            $accident->driver_id = $request->driver_id;
        if ($request->incident_at)
            $accident->incident_at = $request->incident_at;
        if ($request->type)
            $accident->type = $request->type;
        if ($request->status)
            $accident->status = $request->status;
        if ($request->location)
            $accident->location = $request->location;
        if ($request->weather_cond)
            $accident->weather_cond = $request->weather_cond;
        if ($request->road_cond)
            $accident->road_cond = $request->road_cond;
        if ($request->police_details)
            $accident->police_details = $request->police_details;
        if ($request->comments)
            $accident->comments = $request->comments;
        if ($request->x_car_reg)
            $accident->x_car_reg = $request->x_car_reg;
        if ($request->x_car_details)
            $accident->x_car_details = $request->x_car_details;
        if ($request->x_driver_name)
            $accident->x_driver_name = $request->x_driver_name;
        if ($request->x_driver_licence)
            $accident->x_driver_licence = $request->x_driver_licence;
        if ($request->x_insured_name)
            $accident->x_insured_name = $request->x_insured_name;
        if ($request->x_insured_comp)
            $accident->x_insured_comp = $request->x_insured_comp;
        if ($request->x_insured_policy)
            $accident->x_insured_policy = $request->x_insured_policy;
        
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

    public function attachmentUpload(Request $request,$car_id,$accident_id){
        $ext = ['jpg','jpeg','png','JPG','gif'];
        $car = Car::findOrFail($car_id);
        $accident = CarAccident::findOrFail($accident_id);
        if($request->file('file')){
            foreach($request->file('file') as $file){
                if ($file->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('local')->put('accident/'.$fileName, file_get_contents($file));
                    $site_file->name = $fileName;
                    $site_file->full_url = "images/app/accidents/" . $fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $accident->files()->save($site_file);
                }
                else return response("Invalid file", 404);
            }
            return redirect('api/admin/cars/'.$car_id.'/accidents/'.$accident_id);
        }
        return response("Attachment not found", 404);
    }
    
    public function downloadAccidentPdf($car_id=null,$accident_id) {
        
        //return view('contract',['contract'=>$contract,'handover'=>$handover]);
        $accident = CarAccident::findOrFail($accident_id);
        $pdf = PDF::loadView('accident',['accident'=>$accident]);
        File::delete('pdf/accident/'.$accident_id.'/accident.pdf');
        $pdf->save('pdf/accident/'.$accident_id.'/accident.pdf');
        $filename = 'car' . $car_id . '_accident-' . $accident_id . '.zip';
        $zip_file_path = 'pdf/accident/' . $accident_id . '/' . $filename;
        $zip_file = Zipper::make($zip_file_path)->add('pdf/accident/'.$accident_id.'/accident.pdf');
        foreach ($accident->files as $file) {
            $full_url = url($file->full_url); 
            $zip_file->addString($file->name,file_get_contents($full_url));
        }
        
        //$files = 
        $headers = array(
                    'Content-Type' => 'application/octet-stream',
                );

        return redirect(url($zip_file_path));
    }
}
