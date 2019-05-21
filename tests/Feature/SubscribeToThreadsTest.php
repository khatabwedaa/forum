<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use RefreshDatabase;

   /** @test */
   public function a_user_can_subscribe_to_threads()
   {
       $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Lorem reply here..'
        ]);

        // $this->assertCount(1 , auth()->id()->notifications);
   }        

    /** @test */
    public function a_user_can_unsubscribe_from_threads()
    {
        $this->signIn();
 
        $thread = create('App\Thread');

        $thread->subscribe();
 
        $this->delete($thread->path() . '/subscriptions');

        $this->assertEquals(0 , $thread->isSubscribedTo);
    }  
}
