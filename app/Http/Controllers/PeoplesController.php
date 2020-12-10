<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PhonesController;
use App\Models\Peoples;

class PeoplesController extends Controller
{
    public function __construct() {
        $this->phones = new PhonesController();
    }

    public function store($peoples){
        foreach($peoples as $person) {
            $personId = $this->savePerson($person);
            $this->phones->store($personId, $person->phones);
        }

        return true;
    }

    private function savePerson($person){
        $model       = new Peoples();
        $model->id   = $person->personid;
        $model->name = $person->personname;
        $model->save();
        
        return $model->id;
    }
}
