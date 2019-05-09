<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForum extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function  unauthenticated_user_may_not_add_replies()
    {
        $thread = create('App\Thread');

        $this->withExceptionHandling()
            ->post($thread->path() . '/replies' , $thread->toArray())
                ->assertRedirect('/login');

    }

    /** @test */
    public function authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);

    }

    /** @test */
    public function reply_requires_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply' , ['body' => null]);
    
        $this->post($thread->path() . '/replies' , $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
