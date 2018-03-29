<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Carbon\Carbon;

class Category extends Model implements HasMedia
{
    use Sluggable, HasMediaTrait;

    protected $appends = [
        'picture'
    ];

    public function catgories() 
    {
        return $this->hasMany(RecipeCategory::class);
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

    public function getPictureAttribute()
    {
        if ($this->getMedia()->count() > 0) {
            return $this->getMedia()[0]->getTemporaryUrl(Carbon::now()->addMinutes(10));
        } else {
            return 'https://placehold.it/300';
        }
    }
}
