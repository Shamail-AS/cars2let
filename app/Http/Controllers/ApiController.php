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

    public function testGuzzlePost(Request $request)
    {
        $d = $request->all();
        return count($d);
    }

    private function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
}
