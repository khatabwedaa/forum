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
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User' , ['name' => 'JoneDoe']));

        $threadByJone = create('App\Thread' , ['user_id' => auth()->user()->id]);

        $threadNotByJone = create('App\Thread');

        $this->get('/threads?by=JoneDoe')
            ->assertSee($threadByJone->title)
                ->assertDontSee($threadNotByJone->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
       $thread = create('App\Thread');
       create('App\Reply' , ['thread_id' => $thread->id]);

       $response = $this->getJson('threads?unanswered=1')->json();

       $this->assertCount(2 , $response);
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
