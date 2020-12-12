<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Http\Resources\Order\OrderCollection;

class OrdersController extends Controller
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

        $response = new OrderCollection(Orders::all());
        
        if($response)
            return response($response, self::HTTP_SUCCESS);
        else
            return response()->json(['error' => 'Not found'], self::HTTP_NOT_FOUND);
    }

    public function show(Orders $order)
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], self::HTTP_UNAUTHORIZED);
        }

        $response = new OrderCollection(Orders::find($order));

        if($response)
            return response($response, self::HTTP_SUCCESS);
        else
            return response()->json(['error' => 'Not found'], self::HTTP_NOT_FOUND);
    }
}
