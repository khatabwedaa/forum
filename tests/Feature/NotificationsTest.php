<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_notification_is_prepared_when_a_subsribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0 , auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Lorem reply here..'
        ]);

        $this->assertCount(0 , auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Lorem reply here..'
        ]);

        $this->assertCount(1 , auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Lorem reply here..'
        ]);

        $user =auth()->user();

        $respnse = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1 , $respnse);
    }

    /** @test */
    public function a_user_can_mark_notification_as_read()
    {
        $this->signIn();

        $thread = create('App\Thread')->subscribe();

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Lorem reply here..'
        ]);

        $user = auth()->user();

        $this->assertCount(1 , $user->fresh()->unreadNotifications);
        
        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0 , $user->fresh()->unreadNotifications);
    }
}
