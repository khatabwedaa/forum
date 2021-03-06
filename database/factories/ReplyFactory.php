<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Reply;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        'thread_id' => factory('App\Thread')->create(),
        'user_id' =>  factory('App\User')->create(),
        'body' => $faker->paragraph
    ];
});
