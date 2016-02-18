<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Car;

class CarController extends Controller
{
    //
    public function index()
    {
        $carList = Car::all();
        return view('admin.car.index',compact('carList'));
    }
    public function create()
    {
        return view('admin.car.create');
    }
    public function store(Request $request)
    {
        $car = Car::create($request->all());
        return redirect(url('/admin/car'));
    }
}
