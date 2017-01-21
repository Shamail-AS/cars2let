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

        $driver->save();

        return response("Update success");

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
        $car_reg_no = $request->car_reg_no;
        return view('admin.driver.driver_registration',['car_reg_no' => $car_reg_no]);
    }


    public function storeDriver(Request $request) {
        $validator = Validator::make($request->all(), [
            'first_name' =>'required|max:255',
            'last_name' => 'required|max:255',
            'dob'=>'required',
            'passport'=>'required',
            'pass_exp_at'=>'required',
            'address'=>'required',
            'mobile'=>'required',
            'emergency_person' => 'required',
            'emergency_no' => 'required',
            'email' =>'required|email|max:255',
            'years_in_uk'=>'required|integer',
            'curr_pco_num'=>'required',
            'curr_pco_expiry'=>'required',
            'curr_driving_licence_no'=>'required',
            'no_of_years_driving'=>'required',
            'agree_radio'=>'required',
            'dbs_radio' => 'required',
            'con_start_date' => 'required',
            'con_end_date' => 'required'
            // 'driving_licence_file' => 'mimes:jpeg,png,gif,jpg,pdf',
            // 'pco_licence_file' =>'mimes:jpeg,png,gif,jpg,pdf',
            // 'passport_file' => 'mimes:jpeg,png,gif,jpg,pdf',
            // 'crb_file' =>'mimes:jpeg,png,gif,jpg,pdf',
            // 'address_file' => 'mimes:jpeg,png,gif,jpg,pdf'
        ]);
        $validator->sometimes('penelty_points', 'required|integer', function ($input) {
            //dd($input);
            return $input->penelty_points_radio == 'yes';
        });
        $validator->sometimes('conv_date', 'required', function ($input) {
            //dd($input);
            return $input->criminal_radio == 'yes';
        });
        $validator->sometimes('conv_place', 'required', function ($input) {
            //dd($input);
            return $input->criminal_radio == 'yes';
        });
        $validator->sometimes('detail_of_conviction', 'required', function ($input) {
            //dd($input);
            return $input->criminal_radio == 'yes';
        });
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
        $driver->name = $request->first_name.' '.$request->last_name;
        $driver->email = $request->email;
        $driver->dob = $request->dob;
        $driver->passport = $request->passport;
        $driver->phone = $request->mobile;
        $driver->address = $request->address;
        $driver->pass_exp_at = $request->pass_exp_at;
        $driver->nationality = $request->nationality;
        $driver->emerg_person = $request->emergency_person;
        $driver->emerg_num = $request->emergency_no;
        $driver->years_in_uk = $request->years_in_uk;
        $driver->pco_expires_at = $request->curr_pco_expiry;
        $driver->pco_license_no = $request->curr_pco_num;
        $driver->license_no = $request->curr_driving_licence_no;
        $driver->licence_exp_at = $request->curr_driving_expiry;
        $driver->nino = 'yes';
        $driver->right_to_work = 'yes';
        $driver->driving_since = $request->no_of_years_driving;
        if($request->dbs_radio == 'yes')
            $driver->can_dbs_check = 1;
        else
            $driver->can_dbs_check = 0;
        $driver->save();
        if($request->penelty_points_radio == 'yes'){
            $conviction  = new \App\DriverConviction;
            $conviction->details = $request->detail_of_conviction;
            $conviction->convicted_at = $request->conv_date;
            $conviction->place = $request->conv_place;
            $conviction->penalty_points = $request->penelty_points;
            $driver->convictions()->save($conviction);
            $driver->penalty_points = $request->penelty_points;
            $driver->save();
        }
        $car = \App\Car::where('reg_no',$request->car_reg_no)->first();
        $contract = new \App\Contract;
        $contract->car_id = $car->id;
        $contract->driver_id = $driver->id;
        $contract->status = 'suspended';
        $contract->start_date = $request->con_start_date;
        $contract->end_date = $request->con_end_date;
        $contract->status = 'suspended';
        if($car->rate)
            $contract->rate = $car->rate;
        else
            $contract->rate = 10;
        $contract->currency = 'GPB';
        $contract->save();
        
        // if($request->file('driving_licence_file')) {
        //     foreach($request->file('driving_licence_file') as $file){
        //         if ($file->isValid()) {
        //             $site_file = new SiteFile;
        //             $extension = $file->getClientOriginalExtension();
        //             $fileName = Str::random(8).'.'.$extension;
        //             $stored_file = Storage::disk('local')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
        //             $site_file->name = $fileName;
        //             $site_file->full_url = "images/app/driver/".$driver->id."/".$fileName;
        //             if(in_array($extension,$ext)){
        //                 $site_file->type = "image";
        //             }
        //             else {
        //                 $site_file->type = "file";
        //             }

        //             $site_file->save();
        //             $driver->files()->save($site_file);
        //         }
        //         else return response("Invalid file", 404);
        //     }
        // }
        // if($request->file('pco_licence_file')) {
        //     foreach($request->file('pco_licence_file') as $file){
        //         if ($file->isValid()) {
        //             $site_file = new SiteFile;
        //             $extension = $file->getClientOriginalExtension();
        //             $fileName = Str::random(8).'.'.$extension;
        //             $stored_file = Storage::disk('local')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
        //             $site_file->name = $fileName;
        //             $site_file->full_url = "images/app/driver/".$driver->id."/".$fileName;
        //             if(in_array($extension,$ext)){
        //                 $site_file->type = "image";
        //             }
        //             else {
        //                 $site_file->type = "file";
        //             }

        //             $site_file->save();
        //             $driver->files()->save($site_file);
        //         }
        //         else return response("Invalid file", 404);
        //     }
        // }

        // if($request->file('passport_file')){
        //     foreach($request->file('passport_file') as $file){
        //         if ($file->isValid()) {
        //             $site_file = new SiteFile;
        //             $extension = $file->getClientOriginalExtension();
        //             $fileName = Str::random(8).'.'.$extension;
        //             $stored_file = Storage::disk('local')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
        //             $site_file->name = $fileName;
        //             $site_file->full_url = "images/app/driver/".$driver->id."/".$fileName;
        //             if(in_array($extension,$ext)){
        //                 $site_file->type = "image";
        //             }
        //             else {
        //                 $site_file->type = "file";
        //             }

        //             $site_file->save();
        //             $driver->files()->save($site_file);
        //         }
        //         else return response("Invalid file", 404);
        //     }
        // }

        // if($request->file('crb_file')){
        //     foreach($request->file('crb_file') as $file){
        //         if ($file->isValid()) {
        //             $site_file = new SiteFile;
        //             $extension = $file->getClientOriginalExtension();
        //             $fileName = Str::random(8).'.'.$extension;
        //             $stored_file = Storage::disk('local')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
        //             $site_file->name = $fileName;
        //             $site_file->full_url = "images/app/driver/".$driver->id."/".$fileName;
        //             if(in_array($extension,$ext)){
        //                 $site_file->type = "image";
        //             }
        //             else {
        //                 $site_file->type = "file";
        //             }

        //             $site_file->save();
        //             $driver->files()->save($site_file);
        //         }
        //         else return response("Invalid file", 404);
        //     }
        // }
        // if($request->file('address_file')){
        //     foreach($request->file('address_file') as $file){
        //         if ($file->isValid()) {
        //             $site_file = new SiteFile;
        //             $extension = $file->getClientOriginalExtension();
        //             $fileName = Str::random(8).'.'.$extension;
        //             $stored_file = Storage::disk('local')->put('driver/'.$driver->id.'/'.$fileName, file_get_contents($file));
        //             $site_file->name = $fileName;
        //             $site_file->full_url = "images/app/driver/".$driver->id."/".$fileName;
        //             if(in_array($extension,$ext)){
        //                 $site_file->type = "image";
        //             }
        //             else {
        //                 $site_file->type = "file";
        //             }

        //             $site_file->save();
        //             $driver->files()->save($site_file);
        //         }
        //         else return response("Invalid file", 404);
        //     }
        // }

        return redirect('/cars/list');
    }

}
