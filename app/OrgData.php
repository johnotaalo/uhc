<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgData extends Model
{
    protected $fillable = ['upload_id', 'organization_id', 'data_id', 'date', 'number'];
}
