<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Car;
use App\Supplier;
use Illuminate\Support\Facades\Auth;
use Log;

class SupplierController extends Controller
{

    public function api_all()
    {
        $suppliers = Supplier::all();
        return $suppliers;
    }

    public function api_list($type)
    {
        return Supplier::type($type)->get();
    }


    public function index($car_id)
    {
        if($car_id){
            $car = Car::findorFail($car_id);
            if($car->supplier) {
                $car_supplier = $car->supplier;
                $car_supplier->car = $car;
                return $car;
            }
            else
                return response("No Supplier of this car", 404);
        }
        else {
            return Supplier::with('car')->get();
        }
	}

    public function api_get($id)
    {
        return Supplier::find($id);
    }

    public function api_update(Request $request)
    {
        
        $supplier = Supplier::find($request->input('id'));

        $supplier->name = $request->input('name');
        $supplier->contact_name = $request->input('contact_name');
        $supplier->contact_details = $request->input('contact_details');
        $supplier->type = $request->input('type');


        $supplier->save();

        return response("Update success");

    }

    public function api_new(Request $request)
    {
        $supplier = Supplier::create($request->all());

        // Get an instance of Monolog
        $monolog = Log::getMonolog();
        // Choose FirePHP as the log handler
        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
        // Start logging
        $monolog->debug('supplier', $supplier);

        return $driver;
    }

    public function api_delete($id)
    {
        Supplier::destroy($id);
        return response("Deleted");
    }

    //---------------
    public function main()
    {
        $supplierList = Supplier::all();
        return view('admin.supplier.index',compact('supplierList'));
    }
    public function create()
    {
        return view('admin.supplier.create');
    }
    public function show($id)
    {
        $supplier = Supplier::find($id);
        return view('investor.assets.Supplier.detail',compact('Supplier'));
    }

    public function store(Request $request)
    {
        Supplier::create($request->all());
        return redirect(url('admin/supplier/all'));
    }

	// public function store(Request $request,$car_id)
 //    {
 //        // Finding if the car id is correct
 //        $car = Car::findOrFail($car_id);

 //        // Finding if the user id is correct
 //        if($request->auth_user_id)
 //            $auth_user = User::findOrFail($request->auth_user_id);

 //        // Creating a car order
 //        $car_order = CarOrder::create($request->all());
 //        $car->order()->save($car_order);
 //        $supplier->order()->save($car_order);
 //        if($request->auth_user_id)
 //            $auth_user->carOrders()->save($car_order);
 //        // Get an instance of Monolog
 //        $monolog = Log::getMonolog();
 //        // Choose FirePHP as the log handler
 //        $monolog->pushHandler(new \Monolog\Handler\FirePHPHandler());
 //        // Start logging
 //        $monolog->debug('Created', [$car]);
 //        return $car_order;
 //    }
}
