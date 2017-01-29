<?php

namespace App\Http\Controllers;

use App\CarHistory;
use App\Contract;
use App\Revenue;
use App\SiteFile;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use Log;
use PDF;
class ContractController extends Controller
{
    // API METHODS
    public function api_all()
    {
        return Contract::with('driver', 'car', 'handovers', 'payments')->get()->all();
    }

    public function api_get($id)
    {
        return Contract::with('driver', 'car', 'handovers', 'payments')->where('id', $id)->first();
    }

    // ONLY USED IF CONTRACT STATUS is NEW //
    public function api_update(Request $request)
    {

        $contract = Contract::find($request->input('id'));
        if ($request->has('start_date')) $contract->start_date = $request->start_date;
        if ($request->has('end_date')) $contract->end_date = $request->end_date;
        if ($request->has('rate')) $contract->rate = $request->rate;
        if ($request->has('req_deposit')) $contract->req_deposit = $request->req_deposit;
        if ($request->has('rec_deposit')) $contract->rec_deposit = $request->rec_deposit;
        if ($request->has('car.id')) $contract->car_id = $request->input('car.id');
        if ($request->has('driver.id')) $contract->driver_id = $request->input('driver.id');

        $contract->save();
        return $contract;
    }

    public function api_action($id, $action)
    {
        $contract = Contract::findOrFail($id);
        if ($action == 'start') {
            $contract->start();
        } elseif ($action == 'end') {
            $contract->end();
        } else {
            return $action;
        }
        return $contract;
    }

    public function api_new(Request $request)
    {

        $contract = Contract::create($request->all());
        $contract->car_id = $request->input('car.id');
        $contract->driver_id = $request->input('driver.id');
        $contract->status = 2; //suspended
        $contract->req_deposit = 500;

        $history = new CarHistory;
        $history->car_id = $contract->car_id;
        $history->comments = 'car contract created';
        $contract->histories()->save($history);

        if ($request->input('status') == '1') {
            $contract->start();
        }
        $contract->save();

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('Created', [$contract]);

        return $contract;
    }

    public function api_delete($id)
    {
        Contract::destroy($id);
        return response("Deleted");
    }

    //-----------------------//
    public function all()
    {

        $collection = Auth::user()->investor->contracts()
            ->with('car', 'driver', 'handovers')
            ->orderBy('created_at', 'desc')->get();
        foreach ($collection as $contract) {
            //$contract->revenues = $contract->revenues;
            $contract->revenue = $contract->revenue;
            $contract->rent = $contract->rent;
            $contract->weeksDone = $contract->weeksDone;
            $contract->weeksTotal = $contract->weeksTotal;
            $contract->car_reg = $contract->car->reg_no;
            $contract->driver_name = $contract->driver->name;
            unset($contract->car);
            unset($contract->driver);
            unset($contract->investor);

        }
        return $collection;
    }

    public function show($id)
    {
        //Angular will parse the id in the url
        return view('investor.assets.contract.details');
    }

    public function api_show($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues;
        foreach ($revenues as $rev) {
            $w = $rev->weekPaidOn;
        }


        $driver = $contract->driver;
        $car = $contract->car;
        $investor = $contract->investor;
        $handovers = $contract->handovers;

        return $contract;
    }

    public function api_revenues($id)
    {

        $contract = Contract::findOrFail($id);
        $revenues = collect($contract->revenues);
        $data = collect([]);

        foreach ($revenues as $allocation) {
            $start = $contract->start_date->addDays(($allocation->week - 1) * 7);
            $end = $contract->end_date->min($start->copy()->addDays(7));
            $calc_end = $end;

            if ($contract->act_end_dt != null) {
                $calc_end = $end->min($contract->act_end_dt);
            }

            $days = $start->diffInDays($calc_end);
            $rent_due = round($days * ($contract->rate / 7), 2);

            $obj = [
                'id' => $allocation->id,
                'week' => $allocation->week,
                'dates' => [
                    'start' => $start,
                    'end' => $end,
                    'act_end' => ($contract->act_end_dt == null) ? $end : $contract->act_end_dt
                ],
                'amount_due' => $rent_due,
                'amount_received' => floatval($allocation->amount_paid),
                'last_payment' => $allocation->updated_at,
            ];

            $data->push($obj);
        }
        return $data;
    }

    public function filterContractsByCarDriver($search)
    {
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $search)
            ->orWhere('drivers.name', 'LIKE', $search)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function filterContractsByCarAndDriver($search)
    {
        $reg_no = substr($search, 0, strpos($search, 'and'));
        $driver_name = substr($search, strpos($search, 'and') + 3);
        if (strpos($driver_name, '-') > 0) // driver name is reg_no
        {
            //swap
            $temp = $driver_name;
            $driver_name = $reg_no;
            $reg_no = $temp;
        }

        //dd(['1'=>$reg_no,'2'=>$driver_name]);
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $reg_no)
            ->where('drivers.name', 'LIKE', $driver_name)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function filterContractsByCarOrDriver($search)
    {
        $reg_no = substr($search, 0, strpos($search, 'or'));
        $driver_name = substr($search, strpos($search, 'or') + 2);
        if (strpos($driver_name, '-') > 0) // driver name is reg_no
        {
            //swap
            $temp = $driver_name;
            $driver_name = $reg_no;
            $reg_no = $temp;
        }

        //dd(['1'=>$reg_no,'2'=>$driver_name]);
        $collection = Contract::join('cars', 'contracts.car_id', '=', 'cars.id')
            ->join('drivers', 'contracts.driver_id', '=', 'drivers.id')
            ->where('cars.reg_no', 'LIKE', $reg_no)
            ->orWhere('drivers.name', 'LIKE', $driver_name)
            ->select('contracts.*')
            ->get();
        return $collection;
    }

    public function ContractRevenueSummary($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues;
        $rate = (float)$contract->rate;
        $data = [];
        $max_week = $revenues->max('weekPaidOn');
        if ($max_week === null) return $data;
        //dd($max_week);


        $grouped_revs = $revenues->groupBy('weekPaidOn');
        $summed_revs = $grouped_revs->transform(function ($item, $key) {
            return [
                'week' => $key,
                'revenue' => -1,
                'paid' => $item->reduce(function ($carry, $item) {
                    return $carry + (float)$item->amount_paid;
                }),
                'payments' => $item,
                'balance' => -1
            ];
        });
        for ($i = 0; $i <= $max_week; $i++) {
            if (isset($summed_revs[$i])) {
                $data[$i] = $summed_revs[$i];
                $data[$i]['revenue'] = $rate;
                $data[$i]['balance'] = $data[$i]['revenue'] - $data[$i]['paid'];
            } else {
                $data[$i] = [
                    'week' => $i,
                    'revenue' => $rate,
                    'paid' => 0,
                    'payments' => [],
                    'balance' => -$rate
                ];
            }

        }


        return $data;
    }

    public function ContractRevenueDetail($id)
    {
        $contract = Contract::findOrFail($id);
        $revenues = $contract->revenues->groupBy('weekPaidOn');
        $revenues->transform(function ($item, $key) {
            return $item->transform(function ($item, $key) {
                return [
                    'week' => $item->weekPaidOn,
                    'date' => $item->created_at->toFormattedDateString(),
                    'amount' => $item->amount_paid
                ];
            });
        });
        return $revenues;
    }

    public function downloadFullPdf(Request $request,$id) {
        $contract = Contract::findOrFail($id);
        $files_full_url = array();
        if($request->files_id){
            $files = $request->files_id;
            foreach ($files as $file) {
                $file_object = SiteFile::findOrFail($file);
                $files_full_url[] = $file_object->full_url;
            }
        }
        else {
            $files_full_url[] = null;
        }
        
        $pdf = PDF::loadView('contract',['contract'=>$contract,'files'=>$files_full_url]);
        //return view('contract',['contract'=>$contract,'files'=>$files_full_url]);
        return $pdf->download('contractpdf');
    } 

    public function contractApproval(Request $request, $id){
        
        $contract = Contract::findOrFail($id);
        $contract->approved_by = $request->user()->id;
        $contract->save();
        return redirect('/admin');
    }

    public function unapproveMany(Request $request){
        foreach ($request->contracts as $id) {
            $contract = Contract::findOrFail($id);
            $contract->approved_by = -1;
            $contract->save();
        }
        return redirect('/admin');
    }
    public function getAllUnapprovedDrivers() {
        $unapprovedContracts = Contract::where('approved_by',null)->get();

        return view('admin.driver.unapproved-drivers',['unapprovedContracts'=>$unapprovedContracts]);
    }

    public function getUnapprovedDriver($id) {
        $contract = Contract::findOrFail($id);
        $cars = \App\Car::all();
        return view('admin.driver.unapproved-driver-detail',['contract' => $contract,'cars' => $cars]);
    }
    public function downloadUnapprovedDriverPdf($id) {
        $contract = Contract::findOrFail($id);
        return \App\SiteFile::viewToPDF('admin.driver.unapproved-driver-detail-pdf',['contract'=> $contract]);
    }
    // Update the driver and contract of the unapproved contracts
    public function updateContractAndDriver(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' =>'required|max:255',
            'dob'=>'required',
            'address'=>'required',
            'phone'=>'required',
            'email' =>'required|email|max:255',
            'driving_licence_start_date' => 'required',
            'nino' =>'required',
            'start_date' =>'required',
            'end_date' =>'required'

        ]);
        // $validator->sometimes('crb_file[]', 'required', function ($input) {
        //     //dd($input);
        //     return $input->dbs_radio == 'yes';
        // });

        // If validation fails.
        // Validation fails
        if ($validator->fails()) {
           return redirect('admin/unapproved/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $contract = Contract::findOrFail($id);
        $contract->start_date = $request->start_date;
        $contract->end_date = $request->end_date;
        $contract->save();
        $driver = $contract->driver;
        $driver->name = $request->name;
        $driver->email = $request->email;
        $driver->license_no = $request->license_no;
        $driver->pco_license_no = $request->pco_license_no;
        $driver->phone = $request->phone;
        $driver->dob = $request->dob;
        $driver->address = $request->address;
        $driver->alt_address = $request->alt_address;
        $driver->passport = $request->passport;
        $driver->pass_exp_at = $request->pass_exp_at;
        $driver->nationality = $request->nationality;
        $driver->emerg_person = $request->emerg_person;
        $driver->emerg_num  = $request->emerg_num;
        $driver->years_in_uk = $request->years_in_uk;
        $driver->pco_expires_at = $request->pco_expires_at;
        $driver->licence_exp_at = $request->licence_expires_at;
        $driver->type = $request->type;
        $driver->nino = $request->nino;
        $driver->right_to_work = $request->right_to_work;
        $driver->driving_licence_start_date = $request->driving_licence_start_date;
        $driver->driving_mini_cab_from = $request->driving_mini_cab_from;
        $driver->uber_rating = $request->uber_rating;
        $driver->penalty_points = $request->penelty_points;
        $driver->save();
        return back();
    }
    public function updateContractCar(Request $request, $id) {
        $contract = Contract::findOrFail($id);
        $car = \App\Car::findOrFail($request->car_id);
        $contract->car_id = $request->car_id;
        $contract->rate = $car->price;
        $contract->save();
        return back();
    }

}
