<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\CarTicket;
use App\Driver;
use Log;
class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request,$car_id)
    {
        // Finding if the car id is correct
        $car = Car::findOrFail($car_id);
        // Finding if driver id is incorrect
        if($request->driver_id)
            $driver = Driver::findOrFail($request->driver_id);

        // Creating a car ticket
        $car_ticket = CarTicket::create($request->all());
        $car->tickets()->save($car_ticket);
        if($request->driver)
            $driver->tickets()->save($car_ticket);

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$car_ticket]);
        return $car_ticket;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($car_id,$ticket_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_ticket = $car->tickets()->where('id', $ticket_id)->first()))
            // Show 404.
            abort(404);
        // sending the supplier info
        $car_ticket->driver = $car_ticket->driver;
        // sending car info
        $car_ticket->car = $car;
        // return the car object
        return $car_ticket;
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
    public function update(Request $request, $car_id, $ticket_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_ticket = $car->tickets()->where('id', $ticket_id)->first()))
            // Show 404.
            abort(404);
        if($request->type)
            $car_ticket->type = $request->type;
        if($request->ticket_num)
            $car_ticket->ticket_num = $request->ticket_num;
        if($request->cause)
            $car_ticket->cause = $request->cause;
        if($request->driver_id){
            $driver = Driver::findOrFail($request->driver_id);
            $driver->tickets()->save($car_ticket);
        }
        if($request->incident_dt)
            $car_ticket->incident_dt = $request->incident_dt;
        if($request->issue_dt)
            $car_ticket->issue_dt = $request->issue_dt;
        if($request->amount)
            $car_ticket->amount = $request->amount;
        if($request->paid)
            $car_ticket->paid = $request->paid;
        if($request->comments)
            $car->comments = $request->comments;
        if($request->status)
            $car->status = $request->status;
        if($car_ticket->save())
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
    public function destroy($car_id,$ticket_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_ticket = $car->tickets()->where('id', $ticket_id)->first()))
            // Show 404.
            abort(404);
        $car_ticket->delete($ticket_id);
    }
}
