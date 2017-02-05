<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PartDelivery
 *
 * @property integer $id
 * @property integer $part_order_id
 * @property string $scheduled_at
 * @property string $delivered_at
 * @property integer $rec_user_id
 * @property string $received_by
 * @property string $comments
 * @property string $location
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\PartOrder $order
 * @property-read \App\User $receiver
 */
class PartDelivery extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo('App\PartOrder');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'rec_user_id');
    }
}
