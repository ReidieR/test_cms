<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Http\Models\Essay;
use cms\Member;
use Faker\Generator as Faker;

$factory->define(Essay::class, function (Faker $faker) {
    return [
        //
        'cate_id' => rand(1, 18),
        'title' => $faker->sentence,
        'cover_img' => 'http://q26mzy47p.bkt.clouddn.com/avator/Q6L4JRgSejLcDPcBbVW3vInMzzH9c5nvJSJVetIF.png',
        'subtitle' => $faker->sentence,
        'keywords' => $faker->word,
        'descs' => $faker->text,
        'author' => factory(Member::class)->create()->username,
        'from_url' => 'https://juejin.im/post/5df9915bf265da33a353081d',
        'created_at' => time()
    ];
});
