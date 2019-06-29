<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Thread;

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
    public function new_user_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = create('App\User' , ['email_verified_at' => null]);

        $this->signIn($user);

        $this->get('/threads/create')->assertRedirect('/email/verify');

        $thread = make('App\Thread');
    
        $this->post(route('threads.store') , $thread->toArray())
            ->assertRedirect('/email/verify');
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

    /** @test */
    public function a_thread_requires_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread' , ['title' => 'Foo title']);

        $this->assertEquals($thread->fresh()->slug, 'foo-title');

        $thread = $this->postJson(route('threads.store') , $thread->toArray())->json();

        $this->assertEquals("foo-title-{$thread['id']}" , $thread['slug']);
    }

    /** @test */
    public function a_thread_with__a_title_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread' , ['title' => 'some title 24']);

        $thread = $this->postJson(route('threads.store') , $thread->toArray())->json();

        $this->assertEquals("some-title-24-{$thread['id']}" , $thread['slug']);
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread' , ['user_id' => auth()->id()]);
        $reply = create('App\Reply' , ['thread_id' => $thread->id]);

        $responce = $this->json('DELETE' , $thread->path());

        $responce->assertStatus(204);

        $this->assertDatabaseMissing('threads' , ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies' , ['id' => $reply->id]);

        $this->assertDatabaseMissing('activities' , [
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread)
        ]);

        $this->assertDatabaseMissing('activities' , [
            'subject_id' => $reply->id,
            'subject_type' => get_class($reply)
        ]);
    }

    protected function PublishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread' , $overrides);
    
        return $this->post(route('threads.store') , $thread->toArray());
    }
}
