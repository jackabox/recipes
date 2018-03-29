<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\Hash;

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
                'message' => 'validator failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user->username = $request->username;
        $user->name = $request->name;
        $user->save();

        if ($request->image) {
            $user
                ->addMedia($request->image)
                ->toMediaCollection();
        }

        return response()->json([
            'message' => 'Basic User Info Updated',
        ], 200);
    }

    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if (Hash::check($request->password, auth()->user()->password)) {
            auth()->user()->update([
                'email' => $request->email
            ]);
        }

        return response()->json([
            'message' => 'Email Updated',
        ], 200);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old' => 'required',
            'new' => 'required',
            'confirm' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ], 422);
        }

        if ( ! Hash::check($request->old, auth()->user()->password) || $request->new !== $request->confirm) {
            return response()->json([
                'message' => 'Passwords did not match',
            ], 422);
        }

        auth()->user()->update([
            'passowrd' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'Password Updated',
        ], 200);        
    }
}
