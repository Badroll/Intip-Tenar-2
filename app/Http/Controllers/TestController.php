<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller as mCtl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Model as M;
use Helper, DB;
use Carbon\Carbon;

class TestController
{

    protected $request;

    public function __construct(Request $request) {
    }

    public function download(){
        
        // cara 1
        $path = public_path("/assets/logo-user-1.png");
        $headers = array(
            "Content-disposition: attachment; filename=img.png",
            "Content-type: image/jpeg"
            );
        return Response::download($path, "img.png", $headers);

    	// cara 2
        // $path = public_path("/assets/logo-user-1.png");
        // return response()->download($path);

        /*
			image : image/jpeg
            pdf : application/pdf
        */
    }

    public function readFile(){
    	$path = public_path("/assets/countries.json");
        $json = json_decode(file_get_contents($path), true);

        return $json;
    }

}
