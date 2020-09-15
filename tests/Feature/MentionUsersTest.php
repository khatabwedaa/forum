<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create('App\User', ['name' => 'johnDoe']);

        $this->signIn($john);

        $jane = create('App\User', ['name' => 'janeDoe']);

        $thread = create('App\Thread');

        $reply = create('App\Reply', [
            'body' => '@janeDoe look at this. @FreankWaill'
        ]);

        $this->json('post', $thread->path().'/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create('App\User', ['name' => 'john Doe']);
        create('App\User', ['name' => 'john Doe2']);
        create('App\User', ['name' => 'jane Doe']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
