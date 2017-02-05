<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Garage
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property string $name
 * @property string $post_code
 * @property string $address
 * @property string $contact
 * @property string $contact_details
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Supplier $supplier
 */
class Garage extends Model
{
    use SoftDeletes;
    //
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->hasOne('App\Supplier');
    }
}
