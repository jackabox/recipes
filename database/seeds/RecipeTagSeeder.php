<?php

use Illuminate\Database\Seeder;
use App\Models\RecipeTag;

class RecipeTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipeTag::create([
            'recipe_id' => 1,
            'tag_id' => 1
        ]);

        RecipeTag::create([
            'recipe_id' => 2,
            'tag_id' => 3
        ]);

        RecipeTag::create([
            'recipe_id' => 4,
            'tag_id' => 1
        ]);
        RecipeTag::create([
            'recipe_id' => 5,
            'tag_id' => 1
        ]);

        RecipeTag::create([
            'recipe_id' => 8,
            'tag_id' => 4
        ]);
    }
}
