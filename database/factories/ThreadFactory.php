<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Thread;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create()->id,
        'channel_id' => factory('App\Channel')->create()->id,
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
