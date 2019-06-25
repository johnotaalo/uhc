<?php

namespace App\Http\Controllers\Api;

ini_set("max_execution_time", "-1");
ini_set("memory_limit", "-1");

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\County;
use App\Upload;
use App\Organization;
use App\DataFields;
use App\OrgData;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $path = $request->file->store('data');
        $upload = Upload::create([
            'file'          =>  $path,
            'county_id'     =>  $request->input('county'),
            'data_type'     =>  $request->input('dataType')
        ]);

        $spreadsheet = PhpSpreadsheet\IOFactory::load(storage_path("app/".$path));

        $data = $spreadsheet->getActiveSheet()->toArray();
        $header = array_shift($data);
        $dates = array_slice($header, 8, count($header), true);

        $organizations = [];
        $data_fields = [];
        $org_data = [];

    	foreach($data as $d){
            $keys = array_keys($d);
            
            $organization = [
                'organization_uid'          =>  $d[0],
                'organization_name'         =>  $d[1],
                'organization_code'         =>  $d[2],
                'organization_description'  =>  $d[3]
            ];

            $org = Organization::updateOrCreate(
                [ 'organization_uid' =>  $organization['organization_uid'] ],
                $organization
            );

            $data_fields = [
                'data_uid'                  =>  $d[4],
                'data_name'                 =>  $d[5],
                'data_code'                 =>  $d[6],
                'data_description'          =>  $d[7]
            ];

            $df = DataFields::updateOrCreate(
                [ 'data_uid' =>  $data_fields['data_uid'] ],
                $data_fields
            );

            foreach ($dates as $key => $date) {
                $org_data = [
                    'upload_id'                 =>  $upload->id,
                    'organization_id'           =>  $org->id,
                    'data_id'                   =>  $df->id,
                    'date'                      =>  date('Y-m-d', strtotime($date)),
                    'number'                    =>  $d[$key]
                ];

                OrgData::create($org_data);
            }

        }

        return [ 'type' =>  'success', 'message' => 'Successfully uploaded data to database' ];
    }
}
