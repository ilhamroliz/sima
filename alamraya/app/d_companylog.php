<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_companylog extends Model
{
    protected $table = 'd_companylog';
    protected $primaryKey = 'cl_id';
    public $incrementing = false;
    public $remember_token = false;
    const CREATED_AT = 'cl_insert';
    const UPDATED_AT = 'cl_update';

    protected $fillable = ['cl_comp','cl_id', 'cl_username', 'cl_password', 'cl_lastlogin', 'cl_lastlogout', 'cl_insert', 'cl_update'];

}
