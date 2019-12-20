<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use cms\Member;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    return [
            'username' => $faker->username,
            'email' => $faker->unique()->safeEmail,
            'mobile'=> $faker->unique()->phoneNumber,
            'password' => bcrypt('123456'), // password
            'status' => rand(1, 2),
            'gender' => rand(1, 3),
            'created_at' => time(),
            'remember_token' => Str::random(40),
        ];
});
