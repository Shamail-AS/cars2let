<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PartOrder
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $item_id
 * @property string $item_type
 * @property integer $item_count
 * @property string $status
 * @property float $cost
 * @property integer $auth_user_id
 * @property string $auth_user
 * @property string $comments
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\PartOrder $item
 * @property-read \App\Supplier $supplier
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\PartDelivery[] $deliveries
 * @property-read \App\User $authorizedBy
 */
class PartOrder extends Model
{
    //
    protected $guarded = ['id'];

    public function item()
    {
        return $this->morphTo();
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

    public function deliveries()
    {
        return $this->hasMany('App\PartDelivery');
    }

    public function authorizedBy()
    {
        return $this->belongsTo('App\User', 'auth_user_id');
    }
}
