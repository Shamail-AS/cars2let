<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\ContractHandover;
use App\Contract;
use App\Driver;
use App\SiteFile;
use Carbon\Carbon;
use App\CarTicket;
use Log;
use Storage;
use Image;
use PDF;
use Zipper;
use File;
use Illuminate\Support\Str;

class ContractHandoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($contract_id = null)
    {
        if($contract_id)
            $contract = Contract::findOrFail($contract_id);
        return view('admin.car.handover.handover_create',['contract_id'=>$contract_id]);
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
        return view('admin.car.handover.handover_create',['contract_id'=>$contract_id]);
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
        $driver = Driver::findOrFail($contract->driver->id);
        $handover = new ContractHandover;
        $handover->handover_date = $request->handover_date;
        $handover->type = $request->type;
        $handover->status = $request->status;
        $handover->comments = $request->comments;
        $handover->odo_meter_reading = $request->odo_meter_reading;
        $handover->save();
        $car->handovers()->save($handover);
        $contract->handovers()->save($handover);
        $driver->handovers()->save($handover);
        
        return redirect(url('/api/admin/contracts' . $contract->id.'/handovers/create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contract_id,$handover_id)
    {
        $contract = Contract::findOrFail($contract_id);
        $handover = ContractHandover::findOrFail($handover_id);
        return view('admin.car.handover.handover_show',['handover'=>$handover]);
    }

    public function attachmentUpload(Request $request,$contract_id,$handover_id){
        $ext = ['jpg','jpeg','png','JPG','gif'];
        $car = Car::findOrFail($contract_id);
        $handover = ContractHandover::findOrFail($handover_id);
        if($request->file('file')){
            foreach($request->file('file') as $file){
                if ($file->isValid()) {
                    $site_file = new SiteFile;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = Str::random(8).'.'.$extension;
                    $stored_file = Storage::disk('local')->put('handovers/'.$fileName, file_get_contents($file));
                    $site_file->name = $fileName;
                    $site_file->full_url = "images/app/handovers/" . $fileName;
                    if(in_array($extension,$ext)){
                        $site_file->type = "image";
                    }
                    else {
                        $site_file->type = "file";
                    }

                    $site_file->save();
                    $handover->files()->save($site_file);
                }
                else return response("Invalid file", 404);
            }
            return redirect('api/admin/contracts/'.$contract_id.'/handovers/'.$handover_id);
        }
        return response("Attachment not found", 404);
    }


    public function downloadTicketPdf($contract_id,$handover_id) {
        $contract = Contract::findOrFail($contract_id);
        $handover = ContractHandover::findOrFail($handover_id);
        $driver = Driver::findOrFail($handover->driver->id);
        //return view('contract',['contract'=>$contract,'handover'=>$handover]);
        $driver_fileName = array();
        $pdf = PDF::loadView('contract',['contract'=>$contract,'handover'=>$handover]);
        File::delete('pdf/handover/'.$contract_id.'/handover_contract.pdf');
        $pdf->save('pdf/handover/'.$contract_id.'/handover_contract.pdf');
        $zip_file_path = 'pdf/handover/'.$contract_id.'/'.Str::random(8).'_handover.zip';
        $zip_file = Zipper::make($zip_file_path)->add('pdf/handover/'.$contract_id.'/handover_contract.pdf');
        foreach ($handover->files as $file) {
            $full_url = url($file->full_url); 
            $zip_file->addString($file->name,file_get_contents($full_url));
        }
        
        //$files = 
        $headers = array(
                    'Content-Type' => 'application/octet-stream',
                );

        return redirect(url($zip_file_path));
        //return $pdf->download('pdf');
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
