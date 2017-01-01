<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterCarRequest;
use App\Investor;
use App\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Car;
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
        $car->notis = $car->notifications;
        return $car;
    }

    public function api_update(Request $request)
    {
        $investor_id = $request->input('investor')['id'];
        $supplier_id = $request->input('supplier')['id'];
        $car = Car::find($request->input('id'));

        $car->reg_no = $request->input('reg_no');
        $car->make = $request->input('make');
        $car->available_since = $request->input('available_since');
        $car->comments = $request->input('comments');
        $car->custom_id = $request->input('custom_id');
        $car->model = $request->input('model');
        $car->year = $request->input('year');
        $car->colour = $request->input('colour');
        $car->transmission = $request->input('transmission');
        $car->fuel_type = $request->input('fuel_type');
        $car->chassis_num = $request->input('chassis_num');
        $car->engine_size = $request->input('engine_size');
        $car->first_reg_date = $request->input('first_reg_date');
        $car->keeper = $request->input('keeper');
        $car->pco_licence = $request->input('pco_licence');
        $car->pco_expires_at = $request->input('pco_expires_at');
        $car->warranty_exp_at = $request->input('warranty_exp_at');
        $car->road_side_exp_at = $request->input('road_side_exp_at');
        $car->road_tax_exp_at = $request->input('road_tax_exp_at');
        $car->status = $request->input('status');
        $car->curr_odo = $request->input('curr_odo');

        $car->supplier_id = $supplier_id;
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
        $car->save();
        return redirect(url('/investor/cars/' . $car->id));


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
    public function attachmentUpload(Request $request,$id){
        $car = Car::findOrFail($id);
        if($request->file('attachment')){
            if ($request->file('attachment')->isValid()) {
                $site_file = new SiteFile;
                $extension = $request->file('attachment')->getClientOriginalExtension();
                $fileName = Str::random(8).'.'.$extension;
                $stored_file = Storage::disk('local')->put('car/'.$car->id.'/'.$fileName, file_get_contents($request->file('attachment')));
                $site_file->name = $fileName;
                $site_file->full_url="images/app/car/".$car->id."/".$fileName;
                $site_file->save();
                $driver->files()->save($site_file);
                return $site_file->full_url;
            }
            return response("Invalid Attachment", 404);
        }
        return response("Attachment not found", 404);
    }
}
