<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeCategory extends Model
{
    public function category() 
    {
        return $this->belongsTo(Category::class);
    }

    public function recipe() 
    {
        return $this->belongsTo(Recipe::class);
    }
}
