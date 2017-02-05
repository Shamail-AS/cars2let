<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Camera
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $model
 * @property integer $car_id
 * @property string $installed_at
 * @property string $status
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Supplier $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartOrder[] $orders
 * @property-read \App\Car $car
 */
class Camera extends Model
{
    use SoftDeletes;
    //
    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function orders()
    {
        return $this->morphMany('App\PartOrder', 'item');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

}
