<?php

use Illuminate\Database\Seeder;

ini_set("memory_limit", "-1");

use App\Facility;
use App\FacilityDHISList;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Facility::query()->truncate();
    	\App\Helpers\MFLDataHelper::importExcelData(public_path("data/facility-mfl-list.xlsx"));

        $facilities = \App\Helpers\DHISDataHelper::facilities();
		FacilityDHISList::query()->truncate();
        $insertData = collect($facilities)->map(function($facility){
        	return ['dhis_code' => $facility->id, 'mfl_code' => (isset($facility->code) ? $facility->code : 0)];
        })->toArray();

        FacilityDHISList::insert($insertData);
    }
}
