<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    //
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
    public function store(Request $request)
    {
        $driver = Driver::create($request->all());
        return redirect(url('admin/driver'));
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
