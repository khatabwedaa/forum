<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User' , ['name' => 'johnDoe']);

        $this->signIn($john);

        $jane = create('App\User' , ['name' => 'janeDoe']);

        $thread = create('App\Thread');

        $reply = create('App\Reply' , [
            'body' => '@janeDoe look at this. @FreankWaill' 
        ]);

        $this->json('post' , $thread->path().'/replies', $reply->toArray());

        $this->assertCount(1 , $jane->notifications);
    }
}
