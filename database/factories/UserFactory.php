<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Proyek::class, function (Faker $faker) {
    return [
        'nama' => $faker->name,
        'nilai_kontrak' => 200000000,
        'tanggal_kontrak' => $faker->date(),
        'tanggal_mulai' => $faker->date(),
        'tanggal_selesai' => $faker->date(),
        'status' => 1,
        'deskripsi' => $faker->text($maxNbChars = 200),
    ];
});
