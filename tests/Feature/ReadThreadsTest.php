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
    // public function user_can_read_thread_replies()
    // {
    //     $reply = factory('App\Reply')
    //         ->create(['thread_id' => $this->thread->id]);

    //     $this->get($this->thread->path())
    //         ->assertSee($reply->body);   
    // }
}
