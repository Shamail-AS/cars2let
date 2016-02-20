<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirect()
    {
        $user = Auth::user();
       if($user->isAdmin)
           return redirect('/admin');
        elseif($user->isInvestor)
            return redirect('/investor');
        elseif($user->isDriver)
            return redirect('/driver');
        else
            return redirect('/');

    }
}
