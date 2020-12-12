<?php

namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Peoples;
use App\Http\Resources\Item\ItemCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $orders = [];
        foreach ( $this->resource as $order ) {
            $orders[] = [
                'orderid'     => $order->id,
                'orderperson' => $order->people_id,
                'shiporder'   => $order->shipto->only('name', 'address', 'city', 'country'),
                'items'       => new ItemCollection($order->item),
            ];
        }
        
        return $orders;
    }
}