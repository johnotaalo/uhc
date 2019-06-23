<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\County;

class DataController extends Controller
{
    function index(){

    }

    function getUploadComponentData(){
    	return [
    		'counties' => County::all()
    	];
    }

    function upload(Request $request){
    	echo "<pre>";print_r($request->input());
    }
}
