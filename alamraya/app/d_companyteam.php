<?php

namespace App;
use Illuminate\Foundation\Auth\User as Authenticatable;

class d_companyteam extends Authenticatable
{
    protected $table = 'd_companyteam';
    protected $primaryKey = 'ct_id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['ct_comp', 'ct_id', 'ct_name', 'ct_state', 'ct_birth', 'ct_in', 'ct_out'];

    public function log()
    {
        return $this->hasOne('App\d_username', 'un_companyteam');
    }

}
