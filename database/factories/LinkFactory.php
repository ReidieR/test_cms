<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Http\Models\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->name,
        'url' => 'www.php.cn',
        'created_at' => time()
    ];
});
