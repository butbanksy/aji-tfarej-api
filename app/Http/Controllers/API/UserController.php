<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function uploadPhoto(Request $request){
        $user = auth()->user();
        $validatedData = $request->validate([
            'image'=>'required|mimes:jpeg,jpg,png|max:2000'
        ]);

        $imagePath = Storage::put('public', $request->image);

        $user->image = Storage::url($imagePath);
        $user->save();

        return $user;

    }
}
