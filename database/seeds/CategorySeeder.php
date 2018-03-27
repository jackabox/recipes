<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Breakfast',
            'Lunch',
            'Dinner',
            'Dessert',
            'Light Bite'
        ];

        foreach ($categories as $c) {
            Category::create([
                'title' => $c
            ]);
        }
    }
}
