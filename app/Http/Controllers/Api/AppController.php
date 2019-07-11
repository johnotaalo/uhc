<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index(Request $request){
    	$data = [];
    	if($request->route('any') == 'test'){
    		$data['type'] = 'test';
    	}else{
    		$data['type'] = '';
    	}
    	return view('app.main')->with($data);
    }
}
