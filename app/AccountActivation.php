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
        'code',
        'destination'
    ];

    public function send()
    {
        if ($this->destination == 'email')
            $this->sendCodeToEmail();
        else
            $this->sendCodeToPhone();
    }

    public function renew()
    {
        $this->code = random_int(1000, 9999);
        $this->save();
    }

    public function sendCodeToEmail()
    {
        $code = $this->code;
        Mail::send('emails.authCode', ['code' => $code], function ($m) use ($code) {
            $m->from('registration@cars2let.com', 'Cars2Let Investor Registration');

            $m->to('asdfghjkl_-@live.com', 'Shamail')->subject('Your Authentication Code');
        });
    }

    public function sendCodeToPhone()
    {
        $this->sendCodeToEmail();
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at','desc')->first();
    }
    public function scopeValid($query)
    {
        return $query->where('created_at', '>', Carbon::now()->addMinutes(-10))
            ->where('active', true);
    }

    public function scopeFor($query, $email)
    {
        return $query->where('email', $email);
    }

    public function user(){
        return $this->belongsTo('App\User','email','email');
    }

    public function deactivate()
    {
        $this->active = false;
        $this->save();
    }


}
