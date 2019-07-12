<?php

use Illuminate\Database\Seeder;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PopulationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spreadsheet = PhpSpreadsheet\IOFactory::load(storage_path("app/template-data/population.xlsx"));
        $data = $spreadsheet->getActiveSheet()->toArray();
        $header = array_shift($data);
        $years = [2 => $header[2], 3 => $header[3]];
        // dd($years);
        $cleanedData = [];
        foreach($data as $d){
        	foreach ($years as $key => $year) {
        		$cleanedData[] = [
	        		'county_id'		=>	$d[1],
	        		'rural'			=>	$d[4],
	        		'urban'			=>	$d[5],
	        		'year'			=>	$year,
	        		'population'	=>	$d[$key]
	        	];
        	}
        }

        \App\CountyPopulation::insert($cleanedData);
    }
}
