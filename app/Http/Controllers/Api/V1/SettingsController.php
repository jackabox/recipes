<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('profile');

        return response()->json($user);
    }

    public function updateBasicInfo(Request $request)
    {
        $rules = [
            'name' => 'required',
            'image'  => 'nullable|image'
        ];

        $user = auth()->user();

        if ($user->username != $request->username) {
            $rules['username'] = 'required|unique:users';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => 'validator failed',
                'response' => $validator->errors()
            ]);
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->save();

        if ($request->image) {
            $user
                ->addMedia($request->image)
                ->toMediaCollection();
        }
    }
}
