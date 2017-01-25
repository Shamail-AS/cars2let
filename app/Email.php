<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Email extends Model
{
    //
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function send($view, $data)
    {

    }
}
