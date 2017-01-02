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
        'name', 'email', 'password', 'type', 'status', 'access_level'
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
        return $this->hasMany('App\AccountActivation', 'email', 'email');
    }

    public function investor()
    {
        return $this->belongsTo('App\Investor', 'email', 'email');
    }

    public function payments()
    {
        return $this->hasMany('App\Payment', 'auth_user_id');
    }

    public function partDeliveries()
    {
        return $this->hasMany('App\PartDelivery', 'rec_user_id');
    }

    public function deliveries()
    {
        return $this->hasMany('App\Delivery', 'rec_user_id');
    }

    public function carOrders()
    {
        return $this->hasMany('App\CarOrder', 'auth_user_id');
    }

    public function partOrders()
    {
        return $this->hasMany('App\PartOrder', 'auth_user_id');
    }

    public function serviceOrders()
    {
        return $this->hasMany('App\CarServiceOrder', 'auth_user_id');
    }

    public function getIsSuperAdminAttribute()
    {
        return $this->type == 'super-admin';
    }

    public function getIsAdminAttribute()
    {
        return $this->type == 'admin' || $this->type == 'super-admin';
    }

    public function getIsInvestorAttribute()
    {
        return $this->type == 'investor';
    }

    public function getIsDriverAttribute()
    {
        return $this->type == 'driver';
    }

    public function getIsActiveAttribute()
    {
        return $this->status == 'active';
    }

    public function getIsDisabledAttribute()
    {
        return $this->status == 'disabled';
    }

    public function getIsReadOnlyAttribute()
    {
        return in_array($this->access_level, ['read', 'edit', 'full']);
    }

    public function getIsEditOnlyAttribute()
    {
        return in_array($this->access_level, ['edit', 'full']);
    }

    public function getIsFullAccessAttribute()
    {
        return in_array($this->access_level, ['full']);
    }


    public function scopeIs($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeMatches($query, $search)
    {
        // match against driver names + investor names to get the user it belongs to
        return $query->where('email', $search);
    }
}
