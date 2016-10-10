<?php

namespace App\Http\Controllers;


use App\Investor;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

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
    public function sendMail()
    {
        $user = User::find(2);
        $investor = Investor::find(10);

        Mail::send('emails.reminder', ['user' => $user, 'investor'=>$investor], function ($m) use ($user) {
            $m->from('reports@cars2let.com', 'Cars2Let Investor Reporting');

            $m->to('asdfghjkl_-@live.com', $user->name)->subject('Your Reminder!');
        });
    }

    public function testCodeEmail()
    {
        return view('emails.authCode');
    }
}
