<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_administrators_may_not_lock_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->post(route('locked-threads.store', $thread))->assertStatus(302);

        $this->assertFalse($thread->fresh()->locked);
    }

    /** @test */
    public function administrators_can_lock_threads()
    {
        $this->signIn(create('App\User', ['name' => 'janeDoe']));

        $thread = create('App\Thread');

        $this->post(route('locked-threads.store', $thread));

        $this->assertTrue($thread->fresh()->locked);
    }

    /** @test */
    public function administrators_can_unlock_threads()
    {
        $this->signIn(create('App\User', ['name' => 'janeDoe']));

        $thread = create('App\Thread', ['locked' => true]);

        $this->delete(route('locked-threads.store', $thread));

        $this->assertFalse($thread->fresh()->locked);
    }
    
    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();

        $thread = create('App\Thread', ['locked' => true]);

        $this->post($thread->path() . '/replies', [
            'body' => 'foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }
}
