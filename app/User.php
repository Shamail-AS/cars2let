<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $reg_attempt
 * @property integer $login_attempt
 * @property string $status
 * @property string $type
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $access_level
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AccountActivation[] $codes
 * @property-read \App\Investor $investor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Payment[] $payments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartDelivery[] $partDeliveries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Delivery[] $deliveries
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarOrder[] $carOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartOrder[] $partOrders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\CarServiceOrder[] $serviceOrders
 * @property-read mixed $is_super_admin
 * @property-read mixed $is_admin
 * @property-read mixed $is_investor
 * @property-read mixed $is_driver
 * @property-read mixed $is_active
 * @property-read mixed $is_disabled
 * @property-read mixed $is_read_only
 * @property-read mixed $is_edit_only
 * @property-read mixed $is_full_access
 * @method static \Illuminate\Database\Query\Builder|\App\User is($type)
 * @method static \Illuminate\Database\Query\Builder|\App\User active()
 * @method static \Illuminate\Database\Query\Builder|\App\User matches($search)
 */
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
        if (is_array($type)) {
            return $query->whereIn('type', $type);
        } else {
            return $query->where('type', $type);
        }
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
