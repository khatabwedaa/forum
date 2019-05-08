<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function thread_can_make_string_path()
    {
        $thread = create('App\Thread');

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}" , $thread->path()
        );
    }

    /** @test */
    public function thread_has_creator()
    {
        $this->assertInstanceOf('App\User' , $this->thread->creator);
    }

    /** @test */
    public function thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $this->thread->replies);
    }

    /** @test */
    public function thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]); 

        $this->assertCount(1 , $this->thread->replies);
    }

    /** @test */
    public function thread_belongs_to_a_channel()
    {
        $thread = make('App\Thread');

        $this->assertInstanceOf('App\Channel' , $thread->channel);
    }

     
}
