<?php

use Faker\Generator as Faker;

$factory->define(App\Models\RecipeIngredient::class, function (Faker $faker) {
    $title = $faker->word;
    return [
        'quantity' => $faker->numberBetween(1, 500),
        'measurement' => $faker->randomElement(['g','ml','l','tbsp','tsp','']),
        'title'  => ucwords($title),
        'slug'  => strtolower($title)
    ];
});
