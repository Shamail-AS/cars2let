<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCarRequest;
use App\Investor;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Car;
use App\SiteFile;
use Storage;
use Illuminate\Support\Facades\Auth;
use Log;

class CarController extends Controller
{
    // API METHODS

    public function api_all()
    {
        $cars = Car::with('investor')->get();
        $cars->each(function ($car) {
            //$car->overview = $car->overview();
            $car->notis = $car->notifications;
        });
        return $cars;
    }

    public function api_get($id)
    {
        $car = Car::find($id);
        $car->supplier = Supplier::where('id', $car->supplier_id)->first();
        $car->investor = $car->investor;
        $car->currentContract = $car->currentContract;
        $car->notis = $car->notifications;
        return $car;
    }

    public function api_update(Request $request)
    {
        
        $investor_id = $request->input('investor')['id'];
        $supplier_id = $request->input('supplier')['id'];
        $car = Car::find($request->input('id'));
        if($request->input('reg_no'))
        $car->reg_no = $request->input('reg_no');
        if($request->input('make'))
        $car->make = $request->input('make');
        if($request->input('available_since'))
        $car->available_since = $request->input('available_since');
        if($request->input('comments'))
        $car->comments = $request->input('comments');
        if($request->input('custom_id'))
        $car->custom_id = $request->input('custom_id');
        if($request->input('model'))
        $car->model = $request->input('model');
        if($request->input('year'))
        $car->year = $request->input('year');
        if($request->input('colour'))
        $car->colour = $request->input('colour');
        if($request->input('transmission'))
        $car->transmission = $request->input('transmission');
        if($request->input('fuel_type'))
        $car->fuel_type = $request->input('fuel_type');
        if($request->input('chassis_num'))
        $car->chassis_num = $request->input('chassis_num');
        if($request->input('engine_size'))
        $car->engine_size = $request->input('engine_size');
        if($request->input('first_reg_date'))
        $car->first_reg_date = $request->input('first_reg_date');
        if($request->input('keeper'))
        $car->keeper = $request->input('keeper');
        if($request->input('pco_licence'))
        $car->pco_licence = $request->input('pco_licence');
        if(!empty($request->input('pco_expires_at')))
        $car->pco_expires_at = $request->input('pco_expires_at');
        if($request->input('warranty_exp_at'))
        $car->warranty_exp_at = $request->input('warranty_exp_at');
        if($request->input('road_side_exp_at'))
        $car->road_side_exp_at = $request->input('road_side_exp_at');
        if($request->input('road_tax_exp_at'))
        $car->road_tax_exp_at = $request->input('road_tax_exp_at');
        if($request->input('status'))
        $car->status = $request->input('status');
        if($request->input('curr_odo'))
        $car->curr_odo = $request->input('curr_odo');
        if($request->input('price'))
        $car->price = $request->input('price');
        if($request->input('investor')['id'])
        $car->supplier_id = $request->input('supplier')['id'];
        if($request->input('supplier')['id'])
        $car->investor_id = $investor_id;
        $last_updated = $car->updated_at;

        $car->save();
        if ($car->updated_at > $last_updated)
            return response("Update successful");
        else
            return response("Update failed", 500);
    }

    public function api_selective_update(Request $request)
    {
        $car_id = $request->input('id');
        $prop = $request->input('prop');
        $value = $request->input('value');

        $car = Car::findOrFail($car_id);
        if ($prop == 'comments')    
            $car->comments = $value;

        $last_updated = $car->updated_at;
        $car->save();
        if ($car->updated_at > $last_updated)
            return response("Update successful");
        else
            return response("Update failed", 500);

    }

    public function api_new(Request $request)
    {
        $car = Car::create($request->all());
        $car->investor_id = $request->input('investor_id');
        $car->save();

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car]);

        return $car;
    }

    public function api_delete($id)
    {
        Car::destroy($id);
        return response("Deleted");
    }

    public function api_overview($id)
    {
        //TODO GET CAR ALERTS AND CAR HISTORIES

        //These will actually be a list of Car history objects
//        $histories = [
//            'car ordered',
//            'car received from order',
//            'car contract started',
//            'car contract terminated',
//            'car contract started',
//            'car had accident',
//            'car sent for repair',
//            'car received from repair',
//            'car contract terminated'
//        ];
        $car = Car::findOrFail($id);
//        $histories = $car->histories()->with('historable')->get();
//        $deliveries = $car->deliveries()->undelivered()->get();
//        $current_contract = $car->currentContract;
//        $orders  = $car->order()->status('open')->first();
//        $mot = $car->serviceOrders()->mot()->status('open')->first();

        $alerts = $car->overview();
        $histories = $car->histories;

        return [
            'histories' => $histories,
            'alerts' => $alerts
        ];

    }

    //---------------//
    public function index()
    {
        $carList = Car::orderBy('available_since')->get();
        return view('admin.car.index',compact('carList'));
    }
    public function create()
    {
        return view('admin.car.create');
    }

    public function store(RegisterCarRequest $request)
    {
        $c = Car::create($request->all());
        return redirect(url('/admin/car/all'));
    }
    public function all()
    {
        $carList = \Auth::user()->investor->cars()
            ->orderBy('created_at','desc')
            ->get();
        $carList->each(function($car){
           $car->available = Carbon::parse($car->available_since)->toFormattedDateString();
            $car->currentContract = $car->currentContract;
            $car->totalContracts=$car->totalContracts;
            $car->totalRevenue=$car->totalRevenue;
            $car->totalRent=$car->totalRent;

        });
        return $carList;
    }
    public function show($id)
    {
        $car = Car::findOrFail($id);

        return view('investor.assets.car.details', compact('car'));
    }

    public function update(Request $request)
    {


        $car = Car::find($request->input('id'));
        $car->reg_no = $request->input('reg_no');
        $car->make = $request->input('make');
        $dt_avail = new Carbon($request->input('available_since'));
        $car->available_since = $dt_avail->format("d-m-Y");
        $car->comments = $request->input('comments');
        $car->model = $request->input('model');
        $car->year = $request->input('year');
        $car->pco_licence = $request->input('pco_licence');
        $car->save();
        return redirect(url('/investor/cars/' . $car->id));


    }

    public function updateCarDetails($id,Request $request){
        $car = Car::findOrFail($id);

        $car->custom_id = $request->input('custom_id');
        
        $car->colour = $request->input('colour');
        $car->transmission = $request->input('transmission');
        $car->fuel_type = $request->input('fuel_type');
        $car->chassis_num = $request->input('chassis_num');
        $car->engine_size = $request->input('engine_size');
        $car->first_reg_date = $request->input('first_reg_date');
        $car->keeper = $request->input('keeper');
        $car->pco_expires_at = $request->input('pco_expires_at');
        $car->warranty_exp_at = $request->input('warranty_exp_at');
        $car->road_side_exp_at = $request->input('road_side_exp_at');
        $car->road_tax_exp_at = $request->input('road_tax_exp_at');
        $car->curr_odo = $request->input('curr_odo');
        $car->price = $request->input('price');
        $car->save();
        return back();

    }

    public function view($id, $page)
    {
        $car = Car::findOrFail($id);
        //$data = ['car'=>$car, 'page'=>$page];
        return view('admin.car.show', compact('car', 'page'));
    }

    public function admin_show($id)
    {
        return $this->view($id, 'overview');
    }

    public function pictureUploadView($id){
        $car = Car::findOrFail($id);
        return view('admin.car.views.pictures',['car' => $car]);
    }
    public function attachmentUpload(Request $request,$id){
        $ext = ['jpg','jpeg','png','JPG','gif'];
        $car = Car::findOrFail($id);
        if($request->file('file')){
            foreach($request->file('file') as $file){
                if ($file->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    if(in_array($extension, $ext)){
                       $stored_file = Storage::disk('s3')->put('cars/'.$fileName, file_get_contents($file));
                    }
                    else {
                        continue;
                    }
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/cars/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $car->files()->save($site_file);
                }
                else return response("Invalid file", 404);
            }
            return redirect('admin/car/'.$id.'/pictures');
        }
        return response("Attachment not found", 404);
    }

    public function listOfCars() {
        $cars = Car::all();
        return view ('admin.car.cars-list',['cars'=> $cars]);
    }
    public function deletePicture($car_id,$file_id){
        SiteFile::destroy($file_id);
        return redirect('admin/car/'.$car_id.'/pictures');
    }
}
