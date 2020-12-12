<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Phones;

class PhonesController extends Controller
{
    public function store($idPerson, $phones){
        $phones = (array) $phones->phone;
        foreach($phones as $phone) {
            $this->create($idPerson, $phone);
        }

        return true;
    }

    private function create($idPerson, $phone){
        $model            = new Phones();
        $model->people_id = $idPerson;
        $model->number    = $phone;
        return $model->save();
    }
}
