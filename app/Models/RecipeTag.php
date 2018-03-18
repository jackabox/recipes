<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecipeTag extends Model
{
    public function tag() 
    {
        return $this->belongsTo(Tag::class);
    }

    public function recipe() 
    {
        return $this->belongsTo(Recipe::class);
    }
}
