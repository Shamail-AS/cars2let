<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Policy;
class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Policy::all();
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
    public function store(Request $request)
    {
        
        // Creating a camera
        $policy = Policy::create($request->all());
        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$policy]);
        return $policy;
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $policy = Policy::findOrFail($id);

        if($request->policy_num)
            $policy->policy_num = $request->policy_num;
        if($request->insurance_comp)
            $policy->insurance_comp = $request->insurance_comp;
        if($request->policy_start)
            $policy->policy_start = $request->policy_start;
        if($request->policy_end)
            $policy->policy_end = $request->policy_end;
        if($request->excess)
            $policy->excess = $request->excess;
        if($request->annual_insurance)
            $policy->annual_insurance = $request->annual_insurance;
        if($request->ContactA)
            $policy->ContactA = $request->ContactA;
        if($request->ContactB)
            $policy->ContactB = $request->ContactB;
        if($policy->save())
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
    public function destroy($id)
    {
        $policy = Policy::findOrFail($id);
        $policy->delete();
    }
}
