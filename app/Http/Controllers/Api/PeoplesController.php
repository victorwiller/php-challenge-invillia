<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Peoples;
use App\Http\Resources\People\PeopleCollection;

const HTTP_SUCCESS = 200;
const HTTP_UNAUTHORIZED = 401;
const HTTP_NOT_FOUND = 400;

class PeoplesController extends Controller
{
    public function index()
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], HTTP_UNAUTHORIZED);
        }

        $response = new PeopleCollection(Peoples::all());
        
        return ($response) ? response($response, HTTP_SUCCESS) : response()->json(['error' => 'Not found'], HTTP_NOT_FOUND);
    }

    public function show(Peoples $people)
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], HTTP_UNAUTHORIZED);
        }

        $response = new PeopleCollection(Peoples::find($people));

        return ($response) ? response($response, HTTP_SUCCESS) : response()->json(['error' => 'Not found'], HTTP_NOT_FOUND);
    }
}
