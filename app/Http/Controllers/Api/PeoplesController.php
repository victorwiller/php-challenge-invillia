<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Peoples;
use App\Http\Resources\People\PeopleCollection;

class PeoplesController extends Controller
{
    const HTTP_SUCCESS = 200;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 400;

    public function index()
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], self::HTTP_UNAUTHORIZED);
        }

        $response = new PeopleCollection(Peoples::all());
        
        if($response)
            return response($response, self::HTTP_SUCCESS);
        else
            return response()->json(['error' => 'Not found'], self::HTTP_NOT_FOUND);
    }

    public function show(Peoples $people)
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], self::HTTP_UNAUTHORIZED);
        }

        $response = new PeopleCollection(Peoples::find($people));

        if($response)
            return response($response, self::HTTP_SUCCESS);
        else
            return response()->json(['error' => 'Not found'], self::HTTP_NOT_FOUND);
    }
}
