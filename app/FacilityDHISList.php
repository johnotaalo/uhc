<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacilityDHISList extends Model
{
    protected $fillable = ['dhis_code', 'mfl_code'];
}
