<?php

namespace App\Http\Controllers;

use App\Sim;
use App\Tracker;
use Illuminate\Http\Request;

use App\Http\Requests;

class SimController extends Controller
{
    //
    public function index($car_id = null)
    {

        if ($car_id) {
            $car = Car::findOrFail($car_id);
            $sims = $car->sims;
            $sims->each(function ($sim) {
                $sim->tracker = $sim->tracker;
                $sim->supplier = $sim->supplier;
                $sim->order = $sim->orders()->with('supplier', 'deliveries')->first();
            });
            return $sims;
        } else
            return Sim::with('supplier', 'tracker', 'orders.supplier', 'orders.deliveries')->get();

    }

    public function show($sim_id)
    {
        $sim = Sim::with('supplier', 'tracker')->where('id', $sim_id)->first();
        $sim->order = $sim->orders()->with('supplier', 'deliveries')->first();
        return $sim;
    }

    public function store(Request $request)
    {
        if ($request->has('tracker_id')) {

            $tracker = Tracker::find($request->tracker_id);
            if ($tracker == null) return response("Tracker not found", 404);
            $sim = Sim::create($request->all());
            $tracker->sims()->save($sim);

            return Sim::with('supplier', 'tracker')->where('id', $sim->id)->first();
        } else {
            return response("Missing tracker id", 404);
        }
    }

    public function update(Request $request, $sim_id)
    {
        $sim = Sim::find($sim_id);
        if ($sim == null) return response('Sim not found', 404);
        $sim->number = $request->has('number') ? $request->number : $sim->number;
        $sim->puk = $request->has('puk') ? $request->puk : $sim->puk;
        $sim->passcode = $request->has('passcode') ? $request->passcode : $sim->passcode;
        $sim->supplier_id = $request->has('supplier_id') ? $request->supplier_id : $sim->supplier_id;

        $sim->save();
        $sim->supplier = $sim->supplier;
        $sim->tracker = $sim->tracker;
        return $sim;
    }
}
