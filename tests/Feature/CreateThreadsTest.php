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

        $this->post('/threads')
                ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn(); 

       $thread = create('App\Thread');

       $this->post('/threads' , $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
                ->assertSee($thread->body);
    }
    

}
