<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function home()
    {
        return view('admin.home');
    }
    public function index()
    {
        $admins = User::where('type','=','admin')->get();
        return view('admin.index',compact('admins'));
    }
    public function create()
    {
        return  view('admin.create');
    }
    public function store(Request $request)
    {
        $user = User::where('email','=',$request->input('email'))->get();
        if($user == null)
        {
            $user = User::create($request->all());
        }
        $user->status = 'active';
        $user->type = 'admin';
        $user->save();

        return redirect(url('/admin'));
    }
}
