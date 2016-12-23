<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteFile extends Model
{
    //
    protected $guarded = ['id'];


    public function origin()
    {
        return $this->morphTo();
    }
}
