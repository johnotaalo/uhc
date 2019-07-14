<?php

namespace App\Helpers;

ini_set("memory_limit", "-1");

use App\Imports\FacilityImport;
use Maatwebsite\Excel\Facades\Excel;

class MFLDataHelper {

	public static function importExcelData($file_path){
		Excel::import(new FacilityImport, $file_path);
	}
}