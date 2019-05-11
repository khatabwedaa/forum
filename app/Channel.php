<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Relation with Thread
     * 
     * @return hasMany
     */
    public function Threads()
    {
        return $this->hasMany(Thread::class);
    }
}
