<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataWithType extends Model
{
    public function data(){
    	return $this->belongsTo('App\DataFields', 'data_id');
    }
}
