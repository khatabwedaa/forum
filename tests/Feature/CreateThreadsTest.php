<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')    
            ->assertRedirect('/login');

        $this->post(route('threads.store'))
                ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn(); 

       $thread = make('App\Thread');

       $responce = $this->post(route('threads.store') , $thread->toArray());

        $this->get($responce->headers->get('Location'))
            ->assertSee($thread->title)
                ->assertSee($thread->body);
    }

    /** @test */
    public function thread_requires_title()
    {
        $this->PublishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function thread_requires_body()
    {
        $this->PublishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function thread_requires_valid_channel()
    {
        factory('App\Channel' , 2)->create();

        $this->PublishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->PublishThread(['channel_id' => 666])
            ->assertSessionHasErrors('channel_id');
    }

    public function PublishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread' , $overrides);
    
        return $this->post(route('threads.store') , $thread->toArray());
    }
}
