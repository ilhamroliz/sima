<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class erpController
{
    public static function getPosisi($project)
    {
        $posisi = DB::table('d_projectteam')
            ->where('pt_comp', '=', Auth::user()->cl_comp)
            ->where('pt_projectcode', '=', $project)
            ->where('pt_teamid', '=', Auth::user()->cl_id)
            ->first();

        return $posisi->pt_position;
    }
}