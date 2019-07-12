<?php

namespace App;

use BenSampo\Enum\Traits\CastsEnums;
use App\Enums\DataType;
use Illuminate\Database\Eloquent\Model;

class DataWithType extends Model
{
    protected $fillable = ["data_id", "type"];

    protected $enumCasts = ['data_type' => DataType::class];

    protected $appends = ["data_name"];

    public function getDataNameAttribute(){
    	return $this->dataField->data_name;
    }

    public function dataField(){
    	return $this->belongsTo('\App\DataFields', 'data_id');
    }
}
