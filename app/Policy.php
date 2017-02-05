<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Policy
 *
 * @property integer $id
 * @property string $policy_num
 * @property string $insurance_comp
 * @property string $policy_start
 * @property string $policy_end
 * @property float $excess
 * @property float $annual_insurance
 * @property string $contactA
 * @property string $contactB
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Car[] $cars
 */
class Policy extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function cars()
    {
        return $this->belongsToMany('App\Car');
    }
    public function supplier()
    {
        return $this->belongsTo('App\Supplier','insurance_comp');
    }
}
