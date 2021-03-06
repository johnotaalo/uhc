<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataFields extends Model
{
    protected $fillable = ['data_uid', 'data_name', 'data_code', 'data_description'];

    public function type(){
    	return $this->hasOne('\App\DataWithType', 'data_id');
    }
}
