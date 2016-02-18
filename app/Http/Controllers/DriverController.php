<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        $driver = Driver::create($request->all());
        return redirect(url('admin/driver'));
    }
}
