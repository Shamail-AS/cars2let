<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Http\Requests;
use App\Car;
use App\SiteFile;
use App\CarTicket;
use App\Driver;
use Log;
use Storage;
use Image;
use PDF;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($car_id = null)
    {
        if($car_id){
            $car = Car::findOrFail($car_id);
            if ($car->tickets) {
                $tickets = $car->tickets;
                $tickets->each(function ($ticket) {
                    $ticket->car = $ticket->car;
                    $ticket->driver = $ticket->driver;
                    $ticket->files = $ticket->files;
                });
                return $tickets;
            }
            else
                return response("No Ticket of this car", 404);
        }
        else{
            return CarTicket::with('car', 'driver', 'files')->get()->all();
        }

    }

    public function show($id)
    {

        $ticket = CarTicket::with('car', 'driver')->where('id', $id)->first();
        return view('admin.tickets.show', compact('ticket'));
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
    public function store(Request $request,$car_id=null)
    {

        // Finding if the car id is correct
        if($car_id)
            $car = Car::findOrFail($car_id);
        else
            $car = Car::findOrFail($request->car_id);
        // Finding if driver id is incorrect
        if ($request->driver)
            $driver = Driver::findOrFail($request->driver['id']);

        // Creating a car ticket
        $car_ticket = new CarTicket();
        $car_ticket->ticket_num = $request->ticket_num;
        $car_ticket->cause = $request->cause;
        $car_ticket->incident_dt = $request->incident_dt;
        $car_ticket->issue_dt = $request->issue_dt;
        $car_ticket->amount = $request->amount;
        $car_ticket->comments = $request->comments;
        $car_ticket->status = $request->status;
        $car_ticket->save();

        $car->tickets()->save($car_ticket);
        if($request->driver)
            $driver->tickets()->save($car_ticket);


        $car_ticket->car = $car_ticket->car;
        $car_ticket->driver = $car->driver;
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
    public function api_get($car_id, $ticket_id)
    {
        $car = Car::findOrFail($car_id);
        if (!($car_ticket = $car->tickets()->where('id', $ticket_id)->with('car', 'driver', 'files')->first()))
            // Show 404.
            return response("This ticket doesn't belong to this car", 404);
        // sending the driver info
        //$car_ticket->driver = $car_ticket->driver;
        // sending car info
        //$car_ticket->car = $car;

        //return CarTicket::with('car','driver')->where('id',$ticket_id)->first();
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
            return response("This ticket does'nt belong to this car", 404);
        if($request->type)
            $car_ticket->type = $request->type;
        if($request->ticket_num)
            $car_ticket->ticket_num = $request->ticket_num;
        if($request->cause)
            $car_ticket->cause = $request->cause;
        if($request->driver_id){
            $car_ticket->driver_id = $request->driver_id;
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
            return response("This ticket does'nt belong to this car", 404);
        $car_ticket->delete();
        return $car_ticket->trashed();
    }

    public function attach(Request $request)
    {

    }

    public function attachmentUpload(Request $request,$car_id,$ticket_id){

        $car = Car::findOrFail($car_id);
        if (!($car_ticket = $car->tickets()->where('id', $ticket_id)->first()))
            // Show 404.
            return response("This ticket doesn't belong to this car", 404);

        if($request->file('file')){
            if ($request->file('file')->isValid()) {
                $site_file = new SiteFile;
                $extension = $request->file('file')->getClientOriginalExtension();
                $fileName = Str::random(8).'.'.$extension;
                $stored_file = Storage::disk('local')->put('tickets/'.$fileName, file_get_contents($request->file('file')));
                $site_file->name = $fileName;
                $site_file->full_url = "images/app/tickets/" . $fileName;
                $site_file->save();
                $car_ticket->files()->save($site_file);
                return response(Storage::url('tickets/'.$fileName));
            }
            return response("Invalid file", 404);
        }
        return response("Attachment not found", 404);
    }

    public function inferDriver($car_id, $unix_time)
    {


        $incident_dt = Carbon::createFromTimeStamp($unix_time);
        $contracts = Car::find($car_id)->contracts()->ongoing()->get();

        $foundContract = null;

        foreach ($contracts as $contract) {
            if ($contract->isDateDuringContract($incident_dt)) {
                $foundContract = $contract;
                break;
            }
        }

        return $foundContract->driver;
    }

    // public function downloadTicketPdf($car_id,$ticket_id) {
    //     $driver = Driver::findOrFail(1);
    //     $pdf = PDF::loadView('pdf',['driver'=>$driver]);
    //     return view('pdf',['driver'=>$driver]);
    //     //return $pdf->download('pdf');
    // }
}
