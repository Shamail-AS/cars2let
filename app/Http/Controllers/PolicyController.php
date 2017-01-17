<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Policy;
use App\Supplier;
class PolicyController extends Controller
{
    // API METHODS

    public function api_all()
    {
        return Policy::with('supplier')->get();
    }

    public function api_get($id)
    {
        return Policy::find($id);
    }

    public function api_update(Request $request)
    {
        
        $policy = Policy::find($request->input('id'));

        $policy->policy_num = $request->input('policy_num');
        $policy->insurance_comp = $request->input('insurance_comp');
        $policy->policy_start = $request->input('policy_start');
        $policy->policy_end = $request->input('policy_end');

        $policy->excess = $request->input('excess');
        $policy->annual_insurance = $request->input('annual_insurance');

        $policy->save();

        return response($policy->supplier);

    }

    public function api_new(Request $request)
    {
        $policy = Policy::create($request->all());

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Policy', $policy);

        return $driver;
    }

    public function api_delete($id)
    {
        Policy::destroy($id);
        return response("Deleted");
    }

    //---------------
    public function index()
    {
        $policyList = Policy::all();
        $suppliers = Supplier::all();
        return view('admin.policy.index',compact('policyList','suppliers'));
    }
    public function create()
    {
        return view('admin.policy.create');
    }
    public function show($id)
    {
        $policy = Policy::find($id);
        return view('investor.assets.Policy.detail',compact('Policy'));
    }

    public function store(Request $request)
    {
        Policy::create($request->all());
        return redirect(url('admin/insurance/all'));
    }

    // public function all()
    // {
    //     $driverList = \Auth::user()->investor->drivers;

    //     $driverList->each(function($driver){
    //        $driver->birth_date = Carbon::parse($driver->dob)->toFormattedDateString();
    //         $driver->tel = substr($driver->phone,0,12);
    //         $driver->reg_since = Carbon::parse($driver->created_at)->toFormattedDateString();
    //         //$driver->current_contract = ($driver->currentContract == null) ? 'No active contract' : $driver->currentContract->id;
    //         $driver->active_contract = ($driver->currentContract == null) ? 'No active contract' : $driver->currentContract->id;
    //         $driver->totalRevenue = $driver->totalRevenue;
    //         $driver->totalPaid = $driver->totalPaid;
    //         $driver->totalContracts = $driver->totalContracts;
    //     });
    //     return $driverList;
    // }



}
