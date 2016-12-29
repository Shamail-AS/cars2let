<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarHistory extends Model
{
    public function historable()
    {
        return $this->morphTo();
    }
}
