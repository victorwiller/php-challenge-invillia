<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;

class LoginController extends Controller
{
    public function login(Request $request){
        $creds = $request->only(['email', 'password']);

        if(!$token = auth()->attempt($creds)) {
            return response()->json(['error' => 'Incorrect email or password'], 401);
        }

        return response()->json(['token'=> $token]);
    }
}
