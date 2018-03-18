<?php

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Breakfast',
            'Lunch',
            'Dinner',
            'Dessert',
            'Light Bite',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'title' => $tag
            ]);
        }
    }
}
