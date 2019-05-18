<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }
    
    /** @test */
    public function user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function user_can_view_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->body);   
    }

    /** @test */
    public function user_can_filter_channels_according_to_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread' , ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
                ->assertDontSee($threadNotInChannel->title);

    }

    /** @test */
    public function user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User' , ['name' => 'JoneDoe']));

        $threadByJone = create('App\Thread' , ['user_id' => auth()->user()->id]);

        $threadNotByJone = create('App\Thread');

        $this->get('/threads?by=JoneDoe')
            ->assertSee($threadByJone->title)
                ->assertDontSee($threadNotByJone->title);
    }

    /** @test */
    // public function a_user_can_filter_threads_by_popularity()
    // {
    //     $threadWithTwoReplies = create('App\Thread');
    //     create('App\Reply' , ['thread_id' => $threadWithTwoReplies->id] , 2);

    //     $threadWithThreeReplies = create('App\Thread');
    //     create('App\Reply' , ['thread_id' => $threadWithThreeReplies->id] , 3);

    //     $threadWithNotRepies = $this->thread;

    //     $response = $this->getJson('threads?popular=1')->json();

    //     // dd($response);
    //     $this->assertEquals([3 , 2 , 0] , array_column($response , 'replies_count'));
    // }

    /** @test */
    public function a_user_can_read_thread_replies()
    {
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);   
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply' , ['thread_id' => $thread->id] , 3);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(3 , $response['data']);
        $this->assertEquals(3 , $response['total']);
    }
}
