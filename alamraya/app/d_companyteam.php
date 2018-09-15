<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_companyteam extends Model
{
    protected $table = 'd_companyteam';
    protected $primaryKey = 'ct_comp';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;

    protected $fillable = ['ct_comp', 'ct_id', 'ct_name', 'ct_state', 'ct_birth', 'ct_in', 'ct_out'];
}
