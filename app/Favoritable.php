<?php

namespace App;

trait Favoritable 
{
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

    public function isFavorite()
    {
        return !! $this->favorites->where('user_id' , auth()->id())->count(); 
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}