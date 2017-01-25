<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CarHistory
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $car_id
 * @property integer $historable_id
 * @property string $historable_type
 * @property string $comments
 * @property-read \App\CarHistory $historable
 */
class CarHistory extends Model
{
    public function historable()
    {
        return $this->morphTo();
    }
}
