<?php

use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Models\Recipe', 10)->make();

        factory('App\Models\Recipe', 50)->create();
    }
}
