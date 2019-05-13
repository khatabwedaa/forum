<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    protected function subject()
    {
        return $this->morphTo();
    }
}
