<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RecipeIngredient::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween(1, 500),
        'measurement' => $faker->randomElement(['g','ml','l','tbsp','tsp','']),
        'title'  => $faker->word
    ];
});