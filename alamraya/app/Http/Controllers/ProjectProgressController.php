<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectProgressController extends Controller
{
    public function projectProgress($kode)
    {
        $cl_comp = Auth::user()->cl_comp;
        $info = DB::table('d_project')
            ->leftJoin('d_projectfitur', function ($q) use ($cl_comp){
                $q->on('pf_projectcode', '=', 'p_code');
                $q->where('pf_comp', '=', $cl_comp);
            })
            ->leftJoin('d_projectprogress', function ($w) use ($cl_comp){
                $w->on('pp_projectcode', '=', 'p_code');
                $w->where('pp_comp', '=', $cl_comp);
            })
            ->get();
    }
}
