<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function responseOK($message, $data)
    {
    	return response()->json(['status'=>true,'message'=>$message,'data'=>$data]);
    }

    public function responseFAIL($message, $data)
    {
    	return response()->json(['status'=>false,'message'=>$message,'errors'=>$data]);
    }
}
