<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = ['organization_uid', 'organization_name', 'organization_code', 'organization_description'];
}
