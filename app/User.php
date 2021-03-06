<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email' , 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation with Thread
     *
     * @return hasMany
     */
    public function Threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    public function isAdmin()
    {
        return in_array($this->name, ['janeDoe', 'johnDoe', 'khatabWedaa']);
    }

    /**
     * add new Thread
     */
    public function addThread($thread)
    {
        return $this->Threads()->create($thread);
    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset($avatar ? 'storage/' .  $avatar: 'images/avatars/default.png');
    }

    public function getRouteKeyName()
    {
        return 'name';
    }
    
    public function visitedThreadCacheKey($thread)
    {
        return sprintf("user.%s.visits.%s", $this->id, $thread->id);
    }
}
