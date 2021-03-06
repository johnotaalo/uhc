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
use App\DataWithType;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataController extends Controller
{
    function index(){

    }

    function getUploadComponentData(){
    	return [
    		'counties' => County::orderBy('county')->get()
    	];
    }

    function getCounties(Request $request){
        return County::all();
    }

    function updatePilotCounties(Request $request){
        $req = $request->only('counties');
        
        return $counties;
    }

    function getPilotCounties(Request $request){
        $counties = County::select('id', 'county')->where('is_pilot', true)->get();

        return $counties;
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
// dd($dates);
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

            if($organization['organization_code'] != "" && !is_null($organization['organization_code'])){

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
                    if ($d[$key] != "" && $d[$key] != null) {
                        $org_data = [
                            'upload_id'                 =>  $upload->id,
                            'organization_id'           =>  $org->id,
                            'data_id'                   =>  $df->id,
                            'date'                      =>  date('Y-m-d', strtotime("01-" . $date)),
                            'number'                    =>  $d[$key]
                        ];

                        OrgData::create($org_data);
                    }
                    
                }
            }

        }

        return [ 'type' =>  'success', 'message' => 'Successfully uploaded data to database' ];
    }

    function getDataNamesByType(Request $request){
        return DataWithType::where('type', $request->type)->get();
    }

    function searchDataField(Request $request){
        $query = $request->query('q');
        return DataFields::where('data_name', 'LIKE', "%{$query}%")
        ->whereNotIn('id', function($query){
            $query->select('data_id')
                    ->from('data_with_types');
        })->get();
    }


    function getPilotCountyIPDOPDData(Request $request){
        $county_id = $request->input('id');
        $IPD = \App\Enums\DataType::InPatient;
        $OPD = \App\Enums\DataType::OutPatient;

        $countyPopulation = \App\CountyPopulation::where('county_id', $county_id)->first();

        $data = [];

        $ipdFields = DataWithType::where('type', $IPD)->get();
        $opdFields = DataWithType::where('type', $OPD)->get();

        $ipdFieldsArray = $ipdFields->map(function($field){
            return $field->data_id;
        });

        $opdFieldsArray = $opdFields->map(function($field){
            return $field->data_id;
        });

        $ipdQuery = OrgData::whereIn('data_id', $ipdFieldsArray);
        $opdQuery = OrgData::whereIn('data_id', $opdFieldsArray);

        if ($county_id != "") {
            $ipdQuery->whereHas('upload', function($query) use ($county_id){
                $query->where('county_id', $county_id);
            });

            
            $opdQuery->whereHas('upload', function($query) use ($county_id){
                $query->where('county_id', $county_id);
            });
        }else{
            $counties = County::where('is_pilot', 1)->pluck('id')->toArray();

            $ipdQuery->whereHas('upload', function($query) use ($counties){
                $query->whereIn('county_id', $counties);
            });

            
            $opdQuery->whereHas('upload', function($query) use ($counties){
                $query->whereIn('county_id', $counties);
            });
        }

        $data['ipd'] = (int) $ipdQuery->sum('number');
        $data['opd'] = (int) $opdQuery->sum('number');

        return $data;
    }

    function getOPDIPDLevelofFacility(Request $request){
        $county_id = $request->input('id');
        $dataType = "";
        if($request->dataType == 'opd'){
            $dataType = \App\Enums\DataType::OutPatient;
        }elseif($request->dataType == 'ipd'){
            $dataType = \App\Enums\DataType::InPatient;
        }

        $extra_statement = ($county_id == 0) ? "" : " AND u.county_id = {$county_id}";
        $fields = DataWithType::where('type', $dataType)->pluck('id')->toArray();
        $fieldsString = implode(',', $fields);
        $data = [];

        // if ($county_id != "") {
            $sql = "SELECT
                        facility_level,
                        SUM( NO ) AS totals
                    FROM
                        (
                        SELECT
                            f.facility_level,
                            COALESCE ( SUM( number ), 0 ) AS `no` 
                        FROM
                            `org_data` od
                            JOIN data_fields d ON d.id = od.data_id
                            JOIN data_with_types t ON t.data_id = d.id
                            JOIN organizations o ON o.id = od.organization_id
                            JOIN facilities f ON f.mfl_code = o.organization_code
                            JOIN uploads u ON u.id = od.upload_id 
                        WHERE
                            t.type = {$dataType} 
                            AND t.id IN ( {$fieldsString} ) 
                            AND od.number IS NOT NULL 
                            AND u.county_id IN (SELECT id FROM counties WHERE is_pilot = 1)
                            {$extra_statement}
                        GROUP BY
                            f.facility_level 
                        ) x 
                    GROUP BY
                        facility_level";

                        // exit($sql);
            $data = \DB::select($sql);
        // }

        return $data;
    }

    function addDataWithType(Request $request){
        $type = $request->input('type');

        foreach($request->input('data') as $d){
            DataWithType::create([
                'data_id'   =>  $d,
                'type'      =>  $type
            ]);
        }

        return DataWithType::where('type', $type)->get();
    }

    public function getCountyPopulation(Request $request){
        $county = $request->query('q');

        if ($county == 'national') {
            return \App\CountyPopulation::whereRaw('year = (select max(`year`) from county_populations)')->sum('population');
        }else{
            return \App\CountyPopulation::where('county_id', $county)->first()->population;
        }
    }

    public function getFacilityReferralData(Request $request){
        $extra_statement = ($request->county_id != 0) ? "AND u.county_id = {$request->county_id}" : "AND u.county_id IN (SELECT id FROM counties WHERE is_pilot IS TRUE)";
        $sql = "SELECT
                f.mfl_code,
                f.facility_name,
                f.facility_level,
                c.county,
                CAST(SUM( number ) AS UNSIGNED) AS referrals 
            FROM
                org_data d
                JOIN organizations o ON o.id = d.organization_id
                JOIN facilities f ON f.mfl_code = o.organization_code
                JOIN uploads u ON u.id = d.upload_id
                JOIN counties c ON c.id = u.county_id
            WHERE
                d.data_id IN ( SELECT data_id FROM data_with_types WHERE type = 3 ) 
                {$extra_statement}
            GROUP BY
                f.mfl_code, f.facility_name, f.facility_level, c.county";

        $data = \DB::select($sql);

        return $data;
    }

    public function getLengthOfStay(Request $request){
        $extra_statement = ($request->county_id != 0) ? "AND u.county_id = {$request->county_id}" : "AND u.county_id IN (SELECT id FROM counties WHERE is_pilot IS TRUE)";

        $LOS = \App\Enums\DataType::InPatientLengthOfStay;
        $losFields = DataWithType::where('type', $LOS)->pluck('data_id')->toArray();

        $pilotAverageQuery = OrgData::whereIn('data_id', $losFields);
        if ($request->county_id != 0) {
            $county_id = $request->county_id;
            $pilotAverageQuery->whereHas('upload', function($query) use ($county_id){
                $query->where('county_id', $county_id);
            });
        }else{
            $counties = County::where('is_pilot', 1)->pluck('id')->toArray();

            $pilotAverageQuery->whereHas('upload', function($query) use ($counties){
                $query->whereIn('county_id', $counties);
            });
        }

        $pilotAverage = $pilotAverageQuery->avg('number');

        $sql = "SELECT * FROM (
            SELECT
                f.mfl_code,
                f.facility_name,
                f.facility_level,
                c.county,
                CAST(AVG( number ) AS UNSIGNED) AS los 
            FROM
                org_data d
                JOIN organizations o ON o.id = d.organization_id
                JOIN facilities f ON f.mfl_code = o.organization_code
                JOIN uploads u ON u.id = d.upload_id
                JOIN counties c ON c.id = u.county_id
            WHERE
                d.data_id IN ( SELECT data_id FROM data_with_types WHERE type = 2 ) 
                {$extra_statement}
            GROUP BY
                f.mfl_code, f.facility_name, f.facility_level, c.county
                                ) x
                                ORDER BY los DESC
                                LIMIT 10";

            return [
                'average'   =>  $pilotAverage,
                'data'      =>  \DB::select($sql)
            ];
    }

    public function getOPDIPDBySector(Request $request){
        $county_id = ($request->county_id) ? $request->county_id : "";
        // var_dump($county_id);die;
        $extra_statement = ($county_id != "") ? "AND c.id = {$county_id}" : "AND c.is_pilot IS TRUE";
        // dd($extra_statement);
        $sql = "SELECT
                    f.facility_owner,
                    IF(c.is_pilot,'Pilot','Non Pilot') as area,
                    t.type,
                    SUM( number ) AS number 
                FROM
                    org_data d
                    JOIN organizations o ON o.id = d.organization_id
                    JOIN facilities f ON f.mfl_code = o.organization_code
                    JOIN uploads u ON u.id = d.upload_id
                    JOIN counties c ON c.id = u.county_id 
                    {$extra_statement}
                    JOIN data_fields df ON df.id = d.data_id
                    JOIN data_with_types t ON t.data_id = df.id AND t.type IN (0, 1)
                GROUP BY
                    f.facility_owner, IF(c.is_pilot,'Pilot','Non Pilot'), t.type";

                    // die($sql);

        $data = \DB::select($sql);
        $cleanedData = [];
        foreach($data as $d){
            $cleanedData[$d->type][] = $d;
        }

        return $cleanedData;
    }

    function getGeographicalDataOfCounty(Request $request){
        $query = \App\CountyPopulation::where('year', 2018);
        if ($request->county == "national") {
            $query->select(\DB::raw('avg(`urban`) AS urban, avg(`rural`) AS rural'));
        }else{
            $query->select('urban', 'rural');
            $query->where('county_id', $request->county);
        }

        return $query->first();
    }

    function getPyramid(){
        return \App\Pyramid::get();
    }
}
