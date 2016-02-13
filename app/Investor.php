<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    //
    protected $fillable =['name','email','phone','passport_num','dob'];

    protected $dates = ['dob'];

    public function user()
    {
        return $this->hasOne('App\User','email','email');
    }
}
