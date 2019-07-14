<?php

namespace App\Imports;

use App\Facility;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacilityImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Facility([
            'mfl_code'          =>  $row['code'], 
            'facility_name'     =>  $row['name'], 
            'facility_level'    =>  $row['keph_level'], 
            'facility_type'     =>  $row['facility_type'],
            'facility_owner'    =>  $row['owner']
        ]);
    }
}
