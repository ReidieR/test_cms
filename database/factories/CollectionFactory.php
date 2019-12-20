<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Http\Models\Conllection;
use Faker\Generator as Faker;
use cms\Http\Models\Essay;

$factory->define(Conllection::class, function (Faker $faker) {
    $collect = [rand(70, 200),rand(200, 600),rand(600, 1000)];
    return [
        //
        'conllect_article' => json_encode($collect),
        'user_id' => rand(10000, 99999),
        'created_at' => time()

    ];
});
