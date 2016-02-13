<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AccountActivation extends Model
{
    //
    protected  $fillable = [
        'email',
        'code'
    ];

    public function sendCodeToEmail($email)
    {

    }

    public function sendCodeToPhone($phone)
    {

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
