<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShoppingList extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function recipe()
    {
        return $this->belongsTo('App\Models\Recipe');
    }

    public function getItemAttribute()
    {
        return "{$this->quantity}{$this->measurement} {$this->ingredient}";
    }

}
