<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['file', 'county_id', 'data_type'];

    public function county(){
    	return $this->belongsTo('\App\County', 'county_id');
    }
}
