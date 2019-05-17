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

    public function unfavorite()
    {
        $attruibutes = ['user_id' => auth()->id()];
    
        $this->favorites()->where($attruibutes)->delete();
    }

    public function isFavorited()
    {
        return !! $this->favorites->where('user_id' , auth()->id())->count(); 
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}