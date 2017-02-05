<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Sim
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $number
 * @property string $puk
 * @property string $passcode
 * @property integer $tracker_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartOrder[] $orders
 * @property-read \App\Tracker $tracker
 * @property-read \App\Supplier $supplier
 */
class Sim extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }
    public function tracker()
    {
        return $this->belongsTo('App\Tracker');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

}
