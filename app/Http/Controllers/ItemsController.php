<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;

class ItemsController extends Controller
{
    public function store($idOrder, $items){
        foreach($items as $item) {
            if(is_array($item))
                $this->store($idOrder, $item);
            else
                $this->create($idOrder, $item);
        }

        return true;
    }

    private function create($idOrder, $item){
        $model           = new Items();
        $model->order_id = $idOrder;
        $model->title    = $item->title;
        $model->note     = $item->note;
        $model->quantity = $item->quantity;
        $model->price    = $item->price;
        return $model->save();
    }
}
