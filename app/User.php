<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','type','status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function codes()
    {
        return $this->hasMany('App\AccountActivation','email','email');
    }
    public function investor()
    {
        return $this->belongsTo('App\Investor','email','email');
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->type == 'super-admin';
    }
    public function getIsAdminAttribute()
    {
        return $this->type == 'admin' || $this->type == 'super-admin';
    }
}
