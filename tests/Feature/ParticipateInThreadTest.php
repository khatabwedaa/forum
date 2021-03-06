<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInThreadTest extends TestCase
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
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply');

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->assertDatabaseHas('replies' , ['body' => $reply->body]);
        $this->assertEquals(1 , $thread->fresh()->replies_count);
    }

    /** @test */
    public function reply_requires_body()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply' , ['body' => null]);
    
        $this->json('post' , $thread->path() . '/replies' , $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function unauthorized_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("/replies/{$reply->id}")
                ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply' , ['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies' , ['id' => $reply->id]);
        $this->assertEquals(0 , $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthorized_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
                ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_upsate_replies()
    {
        $this->signIn();

        $reply = create('App\Reply' , ['user_id' => auth()->id()]);

        $this->patch("/replies/{$reply->id}" , ['body' => 'You have been changed it.']);

        $this->assertDatabaseHas('replies' , ['id' => $reply->id , 'body' => 'You have been changed it.']);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'hello oneee!'
        ]);

        $this->json('post' , $thread->path().'/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function users_may_only_reply_a_maximum_of_once_pre_minute()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => 'add some reply..'
        ]);

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() .'/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
