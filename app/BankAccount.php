<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\BankAccount
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $owner_type
 * @property string $bank
 * @property string $acc_num
 * @property string $sort_code
 * @property string $holder_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\BankAccount $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Payment[] $payments
 */
class BankAccount extends Model
{
    //

    protected $guarded = ['id'];

    public function owner()
    {
        return $this->morphTo();
    }

    public function payments()
    {
        return $this->hasMany('App\Payment');
    }
}
