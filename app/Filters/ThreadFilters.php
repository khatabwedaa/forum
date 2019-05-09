<?php

namespace App\Filters;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];
    
    /**
     * Filter the query by given username
     * 
     * @param string $username
     * @return @mixed  
     */
    public function by($username)
    {
        $user = \App\User::where('name' , $username)->firstOrFail();
        
        return $this->builder->where('user_id' , $user->id);
    }
}