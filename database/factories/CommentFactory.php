<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User'),
        'post_id' => factory('App\Post'),
        'body' => $faker->sentence,
    ];
});
