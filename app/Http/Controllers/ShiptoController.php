<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipto;

class ShiptoController extends Controller
{
    public function store($idOrder, $shipto){
        $model           = new Shipto();
        $model->order_id = $idOrder;
        $model->name     = $shipto->name;
        $model->city     = $shipto->city;
        $model->country  = $shipto->country;
        return $model->save();
    }
}
