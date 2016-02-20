<?php

namespace App\Http\Controllers;


use Illuminate\Foundation\Auth\User;
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

    public function setActive($id, $value)
    {
        $user = User::find($id);
        $user->status = $value;
        return $user;
    }
}
