<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required',
            'image'=>'required|mimes:jpeg,jpg,png|max:2000'

        ]);

        $validatedData['password'] = bcrypt($request->password);
        $imagePath = Storage::put('public', $request->image);
        $user = User::create($validatedData);
        $user->image = Storage::url($imagePath);
        $user->save();
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
    }

    public function verifyLogin(Request $request)
    {
        return response(auth()->user(), 200);
    }


}
