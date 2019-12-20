<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Http\Models\ArticleContent;
use cms\Http\Models\Essay;
use Faker\Generator as Faker;

$factory->define(ArticleContent::class, function (Faker $faker) {
    return [
        //
        // 'user_id' => factory(Essay::class)->create()->id,
        'content' => $faker->text,
        'created_at' => time()
    ];
});
