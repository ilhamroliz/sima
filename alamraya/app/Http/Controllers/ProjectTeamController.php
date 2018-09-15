<?php

namespace App\Http\Controllers;
use App\d_companyteam;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ProjectTeamController extends Controller
{
    public function index()
    {
        return view('manajemen-project/project-team/project-team');
    }

    public function projectTeam($kode)
    {
        $data = DB::table('d_project')
            ->leftJoin('d_projectteam', function ($q) use ($kode){
                $q->on('pt_projectcode', '=', 'p_code');
                $q->where('pt_comp', '=', Auth::user()->cl_comp);
            })
            ->leftJoin('d_companyteam', function ($a) use ($kode){
                $a->on('pt_teamid', '=', 'ct_id');
                $a->where('ct_comp', '=', Auth::user()->cl_comp);
            })
            ->leftJoin('m_position', function ($z) use ($kode){
                $z->on('pp_code', '=', 'pt_position');
            })
            ->leftJoin('m_projecttype', 'pt_code', '=', 'p_type')
            ->select('p_comp', 'p_code', 'p_name', 'p_state', 'pt_detail', 'p_deadline', 'pp_detail', 'ct_name', 'ct_id', 'ct_state')
            ->where('p_code', '=', $kode)
            ->where('p_comp', '=', Auth::user()->cl_comp)
            ->get();

        if (count($data) > 0){
            Carbon::setLocale('id');
            $data[0]->deadline = Carbon::createFromFormat('Y-m-d', $data[0]->p_deadline)->diffForHumans();
        }

        $team = d_companyteam::where('ct_state', '=', 'Active')->orderBy('ct_id')->get();

        return view('manajemen-project/project-team/project-team', compact('data', 'team'));
    }

}
