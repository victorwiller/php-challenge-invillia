<?php

namespace App\Http\Resources\Phone;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\Peoples;

class PhoneCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $phones = [];
        foreach ( $this->resource as $phone ) {
            $phones[] = [
                'phone' => $phone->number
            ];
        }
        
        return $phones;
    }
}