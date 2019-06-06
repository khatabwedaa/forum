<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User' , $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new \App\Reply([
            'body' => '@janeDoe want talk with @johnDoe'
        ]);

        $this->assertEquals(['janeDoe' , 'johnDoe'] , $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new \App\Reply([
            'body' => 'Hello @janeDoe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/janeDoe">@janeDoe</a>.' , 
            $reply->body
        );
    }
}
