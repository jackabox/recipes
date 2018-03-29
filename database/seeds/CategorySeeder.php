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
            [
                'title' => 'Breakfast',
                'url' => 'https://images.unsplash.com/photo-1517361741572-ae9a9dfe8609?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&h=800&fit=crop&ixid=eyJhcHBfaWQiOjF9&s=1a017260891b664a3203108e61cf0819'
            ],
            [
                'title' => 'Lunch',
                'url' => 'https://images.unsplash.com/photo-1464096338057-a1b7055ef5cb?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&h=800&fit=crop&ixid=eyJhcHBfaWQiOjF9&s=0c0c62c0565c9a7333bc4e04bec4c5e4'
            ],
            [
                'title' => 'Dinner',
                'url' => 'https://images.unsplash.com/photo-1504670813815-f43e2383e08d?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&h=800&fit=crop&ixid=eyJhcHBfaWQiOjF9&s=3dff6b206b3ec9e651b26842fdcfbacc'
            ],
            [
                'title' => 'Dessert',
                'url' => 'https://images.unsplash.com/photo-1508737804141-4c3b688e2546?ixlib=rb-0.3.5&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1200&h=800&fit=crop&ixid=eyJhcHBfaWQiOjF9&s=96f62746045673ad0425aedef929966d'
            ],
        ];

        foreach ($categories as $c) {
            $category = Category::create([
                'title' => $c['title']
            ]);

            $category->addMediaFromUrl($c['url'])->toMediaCollection();
        }
    }
}
