<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $guarded = [];

    protected $with = ['creator' , 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount' , function ($builder)
        {
            $builder->withCount('replies');
        });
    }
    /**
     * Fetch a path to the current thread.
     * 
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    /**
     * Relation with Reply
     * 
     * @return hasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Relation with User
     * 
     * @return belongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    /**
     * Relation with Channel
     * 
     * @return belongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * add new reply to the thread
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    public function scopeFilter($query , $filters)
    {
        return $filters->apply($query);
    }
}
