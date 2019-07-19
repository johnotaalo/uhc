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
        $facility_owner = "";

        $mapping = [
            'Private Practice- Pharmacist'                      =>  'Private',
            'Private Practice - Private Company'                =>  'Private',
            'Private Practice - Clinical Officer'               =>  'Private',
            'Ministry of Health'                                =>  'Public',
            'Private Practice - Medical Specialist'             =>  'Private',
            'Private Practice - General Practitioner'           =>  'Private',
            'Private Practice - Nurse / Midwifery'              =>  'Private',
            'Public Institution - Parastatal'                   =>  'Public',
            'Private Practice Lab Technician/Technologist'      =>  'Private',
            'Non-Governmental Organizations'                    =>  'Private',
            'Other Faith Based'                                 =>  'Private',
            'Kenya Episcopal Conference-Catholic Secretariat'   =>  'Private',
            'Christian Health Association of Kenya'             =>  'Private',
            'Private Practice - Private Institution Academic'   =>  'Private',
            'Public Institution - Academic'                     =>  'Public',
            'Seventh Day Adventist'                             =>  'Private',
            'Supreme Council for Kenya Muslims'                 =>  'Private',
            'Armed Forces'                                      =>  'Private',
            'Private Practice - Unspecified'                    =>  'Private',
        ];

        $facility_owner = $mapping[$row['owner']];
        
        return new Facility([
            'mfl_code'          =>  $row['code'], 
            'facility_name'     =>  $row['name'], 
            'facility_level'    =>  $row['keph_level'], 
            'facility_type'     =>  $row['facility_type'],
            'facility_owner'    =>  $facility_owner
        ]);
    }
}
