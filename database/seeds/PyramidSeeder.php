<?php

use Illuminate\Database\Seeder;

use PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class PyramidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spreadsheet = PhpSpreadsheet\IOFactory::load(public_path("pyramid.csv"));
        $data = $spreadsheet->getActiveSheet()->toArray();
        $header = array_shift($data);
        // $years = [2 => $header[2], 3 => $header[3]];
        // dd($years);
        // $cleanedData = [];
        // foreach($data as $d){
        // 	foreach ($years as $key => $year) {
        // 		$cleanedData[] = [
	       //  		'age_group'		=>	$d[0],
	       //  		'female'		=>	$d[1],
	       //  		'male'			=>	$d[2],
	       //  	];
        // 	}
        // }
        $cleanedData = collect($data)->map(function($d){
        	return [
        		'age_group' => 	$d[0],
        		'female'	=>	$d[1],
        		'male'		=>	$d[2]
        	];
        })->toArray();

        // dd($cleanedData);

        \App\Pyramid::insert($cleanedData);
    }
}
