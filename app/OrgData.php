<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgData extends Model
{
    protected $fillable = ['upload_id', 'organization_id', 'data_id', 'date', 'number'];

    protected $appends = ['county'];

    public function data(){
    	return $this->belongsTo('App\DataFields', 'data_id');
    }

    public function upload(){
    	return $this->belongsTo('App\Upload', 'upload_id');
    }

    public function organization(){
    	return $this->belongsTo('App\Organization', 'organization_id', 'id');
    }

    public function getCountyAttribute($value){
    	return $this->upload->county;
    }
}
