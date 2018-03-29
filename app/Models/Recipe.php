<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Recipe extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait;

    public function categories() 
    {
        return $this->hasMany(RecipeCategory::class);
    }

    public function ingredients() 
    {
        return $this->hasMany(RecipeIngredient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getMethodAttribute($value)
    {
        $method = json_decode($value);
        
        foreach ($method as $m) {
            $m->status = '';
        }

        return $method;
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

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
