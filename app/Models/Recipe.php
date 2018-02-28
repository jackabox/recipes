<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Recipe extends Model
{
    use Sluggable;

    public function getIngredientsAttribute($value)
    {
        return json_decode($value);
    }

    public function getMethodAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
