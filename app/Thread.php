<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use RecordsActivity;
    
    protected $guarded = [];

    protected $with = ['creator' , 'channel'];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
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
        return $this->replies()->create($reply);
    }

    public function scopeFilter($query , $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id()
        ]);
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ? : auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id' , auth()->id())
            ->exists();
    }
}
