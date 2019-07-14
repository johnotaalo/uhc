<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $fillable = ['mfl_code', 'facility_name', 'facility_level', 'facility_type', 'facility_owner'];
}
