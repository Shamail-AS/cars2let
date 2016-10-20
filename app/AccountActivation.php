<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class AccountActivation extends Model
{
    //
    protected  $fillable = [
        'code',
        'destination',
        'source',
        'delivered_to',
        'active'
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
        $this->code = $this->generate();
        $this->save();
    }

    public function sendCodeToEmail()
    {
        $code = $this->code;
        $email = $this->delivered_to;
        $admin = $this->source == 'admin';
        Mail::send('emails.authCode', ['code' => $code], function ($m) use ($email) {
            $m->from('registration@cars2let.com', 'Cars2Let Investor Registration');

            $m->to($email, $email)->subject('Your Authentication Code');
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
        return $query->where('created_at', '>', Carbon::now()->addMinutes(-30))
            ->where('active', true);
    }

    public function scopeFor($query, $email)
    {
        return $query->where('delivered_to', $email);
    }

    public function user(){
        return $this->belongsTo('App\User','email','email');
    }

    public function deactivate()
    {
        $this->active = false;
        $this->save();
    }

    public function generate()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }


}
