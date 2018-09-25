<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class d_username extends Authenticatable
{
    protected $table = 'd_username';
    protected $primaryKey = 'un_username';
    public $incrementing = false;
    public $remember_token = false;
    const CREATED_AT = 'un_insert';
    const UPDATED_AT = 'un_update';

    protected $fillable = ['un_comp','un_username', 'un_passwd', 'un_companyteam', 'un_lastlogin', 'un_lastlogout', 'un_insert', 'un_update'];

    public function team()
    {
        return $this->belongsTo('App\d_companyteam', 'ct_id');
    }
}
