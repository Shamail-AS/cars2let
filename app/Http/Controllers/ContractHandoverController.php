<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\CarHandover;
use App\Driver;
class ContractHandoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id = null,$contract_id = null)
    {
        if($car_id)
            $car = Car::findorFail($car_id);
        if($contract_id)
            $contract = Contract::findOrFail($contract_id);
        if($car_id && $contract_id)
            $handover = CarHandover::with('car','contract')->where('car_id',$car->id)->where('contract_id',$contract->id);
        else
            $handover = CarHandover::with('car','contract');
        return view('admin.car.handover',['handover'=>$handover]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($contract_id = null)
    {
        
        if($contract_id)
            $contract = Contract::findOrFail($contract_id);
        $drivers = Driver::all();
        return view('admin.car.handover.handover_create',['drivers'=>$drivers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request ,$contract_id = null)
    {
        
        if($contract_id)
            $contract = Contract::findOrFail($contract_id);
        $car = Car::findOrFail($contract->car->id);
        $driver = Driver::findOrFail($request->driver);
        $handover = new CarHandover;
        $handover->handover_date = $request->handover_date;
        $handover->type = $request->type;
        $handover->status = $request->status;
        $handover->comment = $request->comment;
        $handover->odo_meter_reading = $request->odo_meter_reading;
        $handover->save();
        $car->handovers()->save($handover);
        $contract->handovers()->save($handover);
        $driver->handover()->save($handover);
        
        return redirect(url('/api/admin/' . $contract->id.'/handovers'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
