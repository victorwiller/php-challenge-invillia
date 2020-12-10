<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ShiptoController;
use App\Http\Controllers\ItemsController;
use App\Models\Orders;


class OrdersController extends Controller
{
    public function __construct() {
        $this->shipto = new ShiptoController();
        $this->items = new ItemsController();
    }

    public function store($orders){
        foreach($orders as $order) {
            $orderId = $this->saveOrder($order);
            $this->shipto->store($orderId, $order->shipto);
            $this->items->store($orderId, $order->items);
        }

        return true;
    }

    private function saveOrder($order){
        $model              = new Orders();
        $model->id          = $order->orderid;
        $model->people_id   = $order->orderperson;
        $model->save();
        
        return $model->id;
    }
}
