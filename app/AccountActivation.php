<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class AccountActivation extends Model
{
    //
    protected  $fillable = [
        'email',
        'code'
    ];

    public function sendCodeToEmail()
    {
        $code = $this->code;
        Mail::send('emails.authCode', ['code' => $code], function ($m) use ($code) {
            $m->from('registration@cars2let.com', 'Cars2Let Investor Registration');

            $m->to('asdfghjkl_-@live.com', 'Shamail')->subject('Your Authentication Code');
        });
    }

    public function sendCodeToPhone($phone)
    {
        $this->sendCodeToEmail();
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at','desc')->first();
    }
    public function scopeValid($query)
    {
        return $query->where('created_at','>',Carbon::now()->addMinutes(-10));
    }

    public function user(){
        return $this->belongsTo('App\User','email','email');
    }
}
