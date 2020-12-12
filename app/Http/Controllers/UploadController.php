<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use App\Http\Controllers\PeoplesController;
use App\Http\Controllers\OrdersController;

class UploadController extends Controller
{
    protected $request;
    protected $peoples;
    protected $orders;

    public function __construct(Request $request){
        $this->request = $request;
        $this->peoples = new PeoplesController();
        $this->orders  = new OrdersController();
    }

    public function index() {
        $this->request->validate(['filexml' => 'bail|required']);

        $savePeople    = $saveOrders = true;
        $filesReceived = Request()->file('filexml');
        $filesConverts = $this->processFiles($filesReceived);
        
        if(isset($filesConverts['person']))
            $savePeople = $this->peoples->store($filesConverts['person']);
        
        if(isset($filesConverts['shiporder']))
            $saveOrders = $this->orders->store($filesConverts['shiporder']);

        return ($savePeople && $saveOrders) ? view('index')->with(['success'=>'Upload completed!']) : false;
    }

    private function processFiles($filesReceived) {
        $filesConverts = array();
        foreach($filesReceived as $file) {
            if($file->isValid()){
                $temp = $this->convertXmlToArray($file);
                if(isset($temp['person']))
                    $filesConverts['person'] = $temp['person'];
                elseif(isset($temp['shiporder']))
                    $filesConverts['shiporder'] = $temp['shiporder'];
                else
                    $filesConverts['error'] = 'Any file with error';
            }
        }

        return $filesConverts;
    }
    
    private function convertXmlToArray($file) {
        libxml_use_internal_errors(true);
        $xml = (array) simplexml_load_string(file_get_contents($file));

        return collect((array) json_decode(json_encode($xml, true)));
    }
}