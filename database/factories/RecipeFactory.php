<?php

use Faker\Generator as FakerGen;

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

$factory->define(App\Models\Recipe::class, function (FakerGen $faker) {
    $faker->addProvider(new Faker\Provider\Lorem($faker));

    $method = $faker->numberBetween(1, 8);

    $method_list = [];

    for ($i = 0; $i < $method; $i++) {
        $method_list[$i] = $faker->paragraph();
    }
    
    return [
        'title'          => $faker->sentence,
        'user_id'       => 1,
        'description'   => $faker->text(400),
        'serves'        => $faker->numberBetween(1, 6),
        'cook_time'     => $faker->numberBetween(5, 180),
        'prep_time'     => $faker->numberBetween(5, 180),
        'method'        => json_encode($method_list)
    ];
});
