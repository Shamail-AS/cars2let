<?php

namespace App;

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
}
