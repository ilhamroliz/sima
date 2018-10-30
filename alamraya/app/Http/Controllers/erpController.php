<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class erpController
{
    public static function getPosisi($project)
    {
        if (Auth::user()->un_companyteam == 'AR000000'){
            return 'COMDIR';
        } elseif (Auth::user()->un_companyteam == 'AR000031') {
            return 'ADMIN';
        } else {
            $posisi = DB::table('d_projectteam')
                ->where('pt_comp', '=', Auth::user()->un_comp)
                ->where('pt_projectcode', '=', $project)
                ->where('pt_teamid', '=', Auth::user()->un_companyteam)
                ->first();

            return $posisi->pt_position;
        }
    }
}
