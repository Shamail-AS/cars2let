<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function matchUser($text)
    {
        return User::where('email','LIKE',"%$text%")->get();
    }
}
