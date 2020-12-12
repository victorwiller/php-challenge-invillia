<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Peoples;
use App\Http\Resources\Phone\PhoneCollection;

class PeopleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $peoples = [];
        foreach ( $this->resource as $people ) {
            $peoples[] = [
                'personid' => $people->id,
                'personname' => $people->name,        
                'phones' => new PhoneCollection($people->phone)
            ];
        }
        
        return $peoples;
    }
}