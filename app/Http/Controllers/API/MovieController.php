<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index() {
        return response (['message'=>'You are successfully authorized :D!']);
    }
    //
}
