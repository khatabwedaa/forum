<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Thread::class, 25)->create()->each(function ($thread) {
            $thread->replies()->save(factory(App\Reply::class)->make());
        });
    }
}
