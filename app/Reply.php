<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    /**
     * a reply has a owner
     */
    public function owner()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    /**
     * Relation with Favorite
     * 
     * @return morphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class , 'favorited');
    }

    /**
     * Create new favorite 
     */
    public function favorite()
    {
        $attruibutes = ['user_id' => auth()->id()];

        if(! $this->favorites()->where($attruibutes)->exists())
        {
            return $this->favorites()->create($attruibutes);  
        }
    }
}
