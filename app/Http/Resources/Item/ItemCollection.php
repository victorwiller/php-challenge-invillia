<?php

namespace App\Http\Resources\Item;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Items;

class ItemCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $items = [];
        foreach ( $this->resource as $item ) {
            $items[] = [
                'title'    => $item->title,
                'note'     => $item->note,
                'quantity' => $item->quantity,
                'price'    => $item->price
            ];
        }
        
        return $items;
    }
}