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

    $ingredients = $faker->numberBetween(4, 15);
    $method = $faker->numberBetween(1, 8);

    $ingredient_list = [];
    $method_list = [];

    for ($i = 0; $i < $ingredients; $i++) {
        $ingredient_list[] =  [
            'amount' => $faker->numberBetween(25, 150),
            'type'  => $faker->word
        ];
    }

    for ($i = 0; $i < $method; $i++) {
        $method_list[] = $faker->paragraph();
    }
    
    return [
        'id' => 1,
        'name' => $faker->sentence,
        'description' => $faker->text(400),
        'cook_time' => $faker->numberBetween(5, 180),
        'prep_time' => $faker->numberBetween(5, 180),
        'ingredients' => $ingredient_list,
        'method'    => $method_list
    ];
});
