<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDriverRequest;
use App\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Log;
use Storage;
use PDF;
use App\SiteFile;
class DriverController extends Controller
{
    // API METHODS

    public function api_all()
    {
        return Driver::all();
        $drivers = Driver::with('cars','contracts')->get();
        $drivers->each(function ($car) {
            //$car->overview = $car->overview();
            $driver->notis = $driver->notifications;
        });
        return $drivers;
    }

    public function api_get($id)
    {
        return Driver::find($id);
    }

    public function api_update(Request $request)
    {
        $driver = Driver::find($request->input('id'));
        $driver->email = $request->input('email');
        $driver->name = $request->input('name');
        $driver->license_no = $request->input('license_no');
        $driver->pco_license_no = $request->input('pco_license_no');
        $driver->dob = $request->input('dob');
        $driver->type = $request->input('type');
        $driver->nino = $request->input('nino');
        $driver->right_to_work = $request->input('right_to_work');
        $driver->driving_licence_start_date = $request->input('driving_licence_start_date');
        $driver->driving_mini_cab_from = $request->input('driving_mini_cab_from');
        $driver->uber_rating = $request->input('uber_rating');
        $driver->bank_account_id = $request->input('bank_account_id');
        $driver->pay_method = $request->input('pay_method');
        $driver->address = $request->input('address');
        $driver->alt_address = $request->input('alt_address');
        $driver->passport = $request->input('passport');
        $driver->pass_exp_at = $request->input('pass_exp_at');
        $driver->nationality = $request->input('nationality');
        $driver->emerg_person = $request->input('emerg_person');
        $driver->emerg_num = $request->input('emerg_num');
        $driver->years_in_uk = $request->input('years_in_uk');
        $driver->pco_expires_at  = $request->input('pco_expires_at');
        $driver->licence_exp_at = $request->input('licence_exp_at');

        $driver->save();

        return response("Update success");

    }


    public function home() {
        $driver = Auth::user()->driver;
        
        return view('driver.home', compact('driver'));
    }

    public function editInfo(){
        $driver = Auth::user()->driver;
        return view('driver.edit',compact('driver'));
    }

    public function updateInfo(Request $request){
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:255',
            'dob'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email' =>'required|email|max:255',
            'driving_licence_start_date' => 'required',
            'nino' =>'required',
        ]);
        // $validator->sometimes('crb_file[]', 'required', function ($input) {
        //     //dd($input);
        //     return $input->dbs_radio == 'yes';
        // });

        // If validation fails.
        // Validation fails
        if ($validator->fails()) {
           return redirect('/driver/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        $driver = Auth::user()->driver;
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->license_no = $request->license_no;
        $driver->pco_license_no = $request->pco_license_no;
        $driver->phone = $request->phone;
        $driver->dob = $request->dob;
        $driver->address = $request->address;
        $driver->alt_address = $request->alt_address;
        $driver->passport = $request->passport;
        $driver->pass_exp_at = $request->pass_exp_at;
        $driver->nationality = $request->nationality;
        $driver->emerg_person = $request->emerg_person;
        $driver->emerg_num  = $request->emerg_num;
        $driver->years_in_uk = $request->years_in_uk;
        $driver->pco_expires_at = $request->pco_expires_at;
        $driver->licence_exp_at = $request->licence_expires_at;
        $driver->type = $request->type;
        $driver->nino = $request->nino;
        $driver->right_to_work = $request->right_to_work;
        $driver->driving_licence_start_date = $request->driving_licence_start_date;
        $driver->driving_mini_cab_from = $request->driving_mini_cab_from;
        $driver->uber_rating = $request->uber_rating;
        $driver->penalty_points = $request->penelty_points;
        $driver->save();
        return back();
    }

    public function listAllCars(){
        $cars = \App\Car::all();
        return view ('admin.car.cars-list',['cars'=> $cars]);
    }

    public function createContract(Request $request){
        $car = \App\Car::where('reg_no',$request->car_reg_no)->first();

        return view('driver.new_contract',['car' => $car]);
    }

    public function storeContract(Request $request){
        $validator = Validator::make($request->all(), [
            'start_date' =>'required',
            'end_date' =>'required'

        ]);
        // $validator->sometimes('crb_file[]', 'required', function ($input) {
        //     //dd($input);
        //     return $input->dbs_radio == 'yes';
        // });

        // If validation fails.
        // Validation fails
        if ($validator->fails()) {
           return redirect('driver/contract/create/?car_reg_no='.$request->car_reg_no)
                        ->withErrors($validator)
                        ->withInput();
        }
        $car = \App\Car::where('reg_no',$request->car_reg_no)->first();
        $contract = new \App\Contract;
        $contract->car_id = $car->id;
        $contract->driver_id = \Auth::user()->driver->id;
        $contract->status = 2;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        if($car->rate)
            $contract->rate = $car->rate;
        else
            $contract->rate = 10;
        $contract->currency = 'GPB';
        $contract->save();
        return redirect('driver');

    }

    public function approvedContracts() {
        $driver = \Auth::user()->driver;
        return view('driver.contracts',compact('driver'));
    }


    public function view($id, $page)
    {
        $driver = Driver::findOrFail($id);
        //$data = ['car'=>$car, 'page'=>$page];
        return view('admin.driver.show', compact('driver', 'page'));
    }

    public function admin_show($id)
    {
        return $this->view($id, 'overview');
    }

    public function ticketsShow($id){
        return $this->view($id,'tickets');
    }

    public function convictionsShow($id){
        return $this->view($id,'convictions');
    }

    public function convictionsStore(Request $request,$id){
        $driver = Driver::findOrFail($id);
        $conviction = new \App\DriverConviction;
        $conviction->driver_id = $driver->id;
        $conviction->details = $request->details;
        $conviction->penalty_points = $request->penalty_points;
        $conviction->convicted_at = $request->convicted_at;
        $conviction->place = $request->place;
        $driver->convictions()->save($conviction);
        return back();
    }

    public function convictionsDelete($driver_id,$conviction_id){
        \App\DriverConviction::destroy($conviction_id);
        return back();   
    }

    public function viewFiles($id=null){
        if(\Auth::user()->isDriver)
            $driver = \Auth::user()->driver;
        else
            $driver = Driver::findOrFail($id);
        return view('admin.driver.views.uploadfile', compact('driver'));
    }
    public function api_new(Request $request)
    {
        $driver = Driver::create($request->all());

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Driver', $driver);

        return $driver;
    }

    public function api_delete($id)
    {
        Driver::destroy($id);
        return response("Deleted");
    }

    //---------------
    public function index()
    {
        $driverList = Driver::all();
        return view('admin.driver.index',compact('driverList'));
    }
    public function create()
    {
        return view('admin.driver.create');
    }
    public function show($id)
    {
        $driver = Driver::find($id);
        return view('investor.assets.driver.detail',compact('driver'));
    }

    public function store(RegisterDriverRequest $request)
    {
        Driver::create($request->all());
        return redirect(url('admin/driver/all'));
    }
    public function all()
    {
        $driverList = \Auth::user()->investor->drivers;

        $driverList->each(function($driver){
           $driver->birth_date = Carbon::parse($driver->dob)->toFormattedDateString();
            $driver->tel = substr($driver->phone,0,12);
            $driver->reg_since = Carbon::parse($driver->created_at)->toFormattedDateString();
            //$driver->current_contract = ($driver->currentContract == null) ? 'No active contract' : $driver->currentContract->id;
            $driver->active_contract = ($driver->currentContract == null) ? 'No active contract' : $driver->currentContract->id;
            $driver->totalRevenue = $driver->totalRevenue;
            $driver->totalPaid = $driver->totalPaid;
            $driver->totalContracts = $driver->totalContracts;
        });
        return $driverList;
    }

    public function attachmentUpload(Request $request,$id){
        $driver = Driver::findOrFail($id);
        if($request->file('attachment')){
            if ($request->file('attachment')->isValid()) {
                $site_file = new SiteFile;
                $extension = $request->file('attachment')->getClientOriginalExtension();
                $fileName = Str::random(8).'.'.$extension;
                $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($request->file('attachment')));
                $site_file->name = $fileName;
                $site_file->full_url='https://laravel-tgyv.objects.frb.io/driver/'.$driver->id.'/'.$fileName;
                $site_file->save();
                $driver->files()->save($site_file);
                return $site_file->full_url;
            }
            return response("Invalid Attachment", 404);
        }
        return response("Attachment not found", 404);
    }

     public function downloadFullPDF($id){
        $driver = Driver::findOrFail($id);
        return \App\SiteFile::viewToPDF('sample',['driver'=>$driver]);

    }

    public function viewDriverRegistrationForm(Request $request) {
        $car = \App\Car::where('reg_no',$request->car_reg_no)->first();

        return view('admin.driver.driver_registration',['car' => $car]);
    }


    public function storeDriver(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:255',
            'dob'=>'required',
            'passport'=>'required',
            'password'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email' =>'required|email|max:255',
            'driving_licence_start_date' => 'required',
            'nino' =>'required',
            'driving_licence' => 'required',
            'start_date' =>'required',
            'end_date' =>'required'

        ]);
        // $validator->sometimes('crb_file[]', 'required', function ($input) {
        //     //dd($input);
        //     return $input->dbs_radio == 'yes';
        // });

        // If validation fails.
        // Validation fails
        if ($validator->fails()) {
           return redirect('/drivers/new?car_reg_no='.$request->car_reg_no)
                        ->withErrors($validator)
                        ->withInput();
        }
        $ext = ['jpg','jpeg','png','JPG','gif'];

        $driver = new Driver;
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->dob = $request->dob;
        $driver->phone = $request->phone;
        $driver->address = $request->address;
        $driver->alt_address = $request->alt_address;
        $driver->driving_licence_start_date = $request->driving_licence_start_date;
        $driver->driving_mini_cab_from = $request->driving_mini_cab_from;
        $driver->uber_rating = $request->uber_rating;
        $driver->comments = $request->comments;
        $driver->nino = $request->nino;
        $driver->right_to_work = 'yes';
        $driver->save();
        $car = \App\Car::where('reg_no',$request->car_reg_no)->first();
        $contract = new \App\Contract;
        $contract->car_id = $car->id;
        $contract->driver_id = $driver->id;
        $contract->status = 2;
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        if($car->rate)
            $contract->rate = $car->rate;
        else
            $contract->rate = 10;
        $contract->currency = 'GPB';
        $contract->save();

        if($request->file('passport')) {
                if ($request->file('passport')->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $request->file('passport')->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($request->file('passport')));
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/driver/".$driver->id."/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $driver->files()->save($site_file);
                }
                else return response("Invalid file", 404);
        }
        if($request->file('proof')) {
                if ($request->file('proof')->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $request->file('proof')->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($request->file('proof')));
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/driver/".$driver->id."/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $driver->files()->save($site_file);
                }
                else return response("Invalid file", 404);
        }
        if($request->file('driving_licence')) {
                if ($request->file('driving_licence')->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $request->file('driving_licence')->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($request->file('driving_licence')));
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/driver/".$driver->id."/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $driver->files()->save($site_file);
                }
                else return response("Invalid file", 404);
        }
        if($request->file('pco_licence')) {
                if ($request->file('pco_licence')->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $request->file('pco_licence')->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($request->file('pco_licence')));
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/driver/".$driver->id."/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $driver->files()->save($site_file);
                }
                else return response("Invalid file", 404);
        }
        // Creating a new User
        $user = new \App\User;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 'active';
        $user->type = 'driver';
        $user->save();

        return redirect('/cars/list');
    }
    public function uploadDriverFiles(Request $request,$id=null) {
        $ext = ['jpg','jpeg','png','JPG','gif'];
        if(\Auth::user()->isDriver)
            $driver = Auth::user()->driver;
        else
            $driver = Driver::findOrFail($id);
        if($request->file('file')){
            foreach($request->file('file') as $file){
                if ($file->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('s3')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
                    $site_file->name = $fileName;
                    $site_file->full_url = "https://laravel-tgyv.objects.frb.io/driver/".$driver->id."/".$fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $driver->files()->save($site_file);
                }
                else return response("Invalid file", 404);
            }
            return back();
        }
        return response("Attachment not found", 404);
    }
    public function deleteFile($driver_id,$file_id){
        SiteFile::destroy($file_id);
        return back();
    }

    public function deleteFiles($file_id){
        SiteFile::destroy($file_id);
        return back();
    }
    public function api_overview($id)
    {
       
        $driver = Driver::findOrFail($id);

        $alerts = $driver->overview();
        $histories = $driver->histories;

        return [
            'histories' => $histories,
            'alerts' => $alerts
        ];
    }
    public function carInfo($id) {
        $car = \App\Car::findOrFail($id);
        return view('driver.car-details',compact('car'));
    }
}
