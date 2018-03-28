<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $profile = $user->profile;
        $recipes = $user->recipes()->take(3)->get();

        return response()->json([
            'user'    => $user,
            'profile' => $profile,
            'recipes' => $recipes
        ]);
    }
}
