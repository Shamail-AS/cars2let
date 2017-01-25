<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Payment
 *
 * @property integer $id
 * @property string $type
 * @property integer $bank_account_id
 * @property string $from
 * @property string $to
 * @property integer $auth_user_id
 * @property string $auth_user
 * @property string $comments
 * @property string $value_dt
 * @property float $amount
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property integer $contract_id
 * @property-read \App\BankAccount $bank
 * @property-read \App\Contract $contract
 * @property-read \App\User $authorizedBy
 */
class Payment extends Model
{
    //
    protected $guarded = ['id'];

    public function bank()
    {
        return $this->belongsTo('App\BankAccount');
    }

    public function contract()
    {
        return $this->belongsTo('App\Contract');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }
}
