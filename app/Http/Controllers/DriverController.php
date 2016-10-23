<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDriverRequest;
use App\Revenue;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Log;

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
}
