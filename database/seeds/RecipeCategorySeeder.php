<?php

use Illuminate\Database\Seeder;
use App\Models\RecipeCategory;

class RecipeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipeCategory::create([
            'recipe_id' => 1,
            'category_id' => 1
        ]);

        RecipeCategory::create([
            'recipe_id' => 2,
            'category_id' => 3
        ]);

        RecipeCategory::create([
            'recipe_id' => 4,
            'category_id' => 1
        ]);
        RecipeCategory::create([
            'recipe_id' => 5,
            'category_id' => 1
        ]);

        RecipeCategory::create([
            'recipe_id' => 8,
            'category_id' => 4
        ]);
    }
}
