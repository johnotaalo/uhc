<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountyPopulation extends Model
{
    protected $fillable = ['county_id', 'year', 'population', 'rural', 'urban'];
}
