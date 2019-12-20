<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Http\Models\Comments;
use cms\Http\Models\Essay;
use cms\Member;
use Faker\Generator as Faker;

$factory->define(Comments::class, function (Faker $faker) {
    return [
        'comments'=> $faker->sentence,
        'user_id' => rand(78, 660),
        'article_id' => rand(1, 1000),
        'created_at' => time()
    ];
});
