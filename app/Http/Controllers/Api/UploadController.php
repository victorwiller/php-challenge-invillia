<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use Validator,Redirect,Response,File;
use App\Http\Controllers\UploadController as UploadNotApi;
use App\Http\Controllers\PeoplesController;
use App\Http\Controllers\OrdersController;

class UploadController extends Controller
{
    const HTTP_SUCCESS        = 200;
    const HTTP_UNAUTHORIZED   = 401;
    const HTTP_NOT_FOUND      = 400;
    const HTTP_NOT_ACCEPTABLE = 406;
    
    protected $request;
    protected $peoples;
    protected $orders;

    public function __construct(Request $request) {
        parent::__construct();
        $this->request = $request;
        $this->peoples = new PeoplesController();
        $this->orders  = new OrdersController();
    }

    public function index()
    {
        try {
            auth()->userOrFail();
        } catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return response()->json(['error'=> $e->getMessage()], self::HTTP_UNAUTHORIZED);
        }

        $validator = Validator::make($this->request->all(), 
              ['file' => 'required']);

        if ($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], self::HTTP_NOT_ACCEPTABLE);                        
        }

        $savePeople    = $saveOrders = true;

        $filesReceived = $this->request->file;
        $filesConverts = $this->processFiles($filesReceived);
        
        if(isset($filesConverts['person']))
            $savePeople = $this->peoples->store($filesConverts['person']);
        
        if(isset($filesConverts['shiporder']))
            $saveOrders = $this->orders->store($filesConverts['shiporder']);
            
        if ($savePeople && $saveOrders)
            return response()->json(['success' => 'File successfully uploaded']);
        else
            return response()->json(['error' => 'Upload failed'], self::HTTP_NOT_FOUND);
    }

    private function processFiles($filesReceived) {
        $filesConverts = array();
        
        foreach($filesReceived as $file) {
            $result;
            if(is_array($file)){
                $result = $this->separateFiles($file);
            } elseif($file->isValid()) {
                $temp   = $this->convertXmlToArray($file);
                $result = $this->separateFiles($temp);
            }
        }

        return $result;
    }
    
    private function convertXmlToArray($file) {
        libxml_use_internal_errors(true);
        $xml = (array) simplexml_load_string(file_get_contents($file));

        return collect((array) json_decode(json_encode($xml, true)));
    }

    private function separateFiles($array){
        if(isset($temp['person']))
            $filesConverts['person'] = $temp['person'];
        elseif(isset($temp['shiporder']))
            $filesConverts['shiporder'] = $temp['shiporder'];
        else
            $filesConverts['error'] = 'Any file with error';
    }
}
