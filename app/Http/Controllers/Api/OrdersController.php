<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\Order\OrderCollection;

const HTTP_SUCCESS = 200;
const HTTP_UNAUTHORIZED = 401;
const HTTP_NOT_FOUND = 400;

class OrdersController extends Controller
{
    public function index()
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], HTTP_UNAUTHORIZED);
        }

        $response = new OrderCollection(Orders::all());
        
        return ($response) ? response($response, HTTP_SUCCESS) : response()->json(['error' => 'Not found'], HTTP_NOT_FOUND);
    }

    public function show(Orders $order)
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], HTTP_UNAUTHORIZED);
        }

        $response = new OrderCollection(Orders::find($order));

        return ($response) ? response($response, HTTP_SUCCESS) : response()->json(['error' => 'Not found'], HTTP_NOT_FOUND);
    }
}
