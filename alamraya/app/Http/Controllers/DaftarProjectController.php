<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class DaftarProjectController extends Controller
{
    public function index(Request $request)
    {
        $project = DB::table('d_project')
            ->get();
        return view('manajemen-project/daftar-project/index', compact('project'));
    }

    public function add()
    {
        return view('manajemen-project/daftar-project/formTambah');
    }

    public function data($status)
    {
        if ($status == 'all'){
            $data = DB::table('d_project')
                ->join('m_projecttype', 'p_type', '=', 'pt_code')
                ->select('p_name', 'p_comp', 'p_code', 'p_state', 'pt_detail', DB::raw('date_format(p_kickoff, "%d/%m/%Y") as p_kickoff'), DB::raw('date_format(p_deadline, "%d/%m/%Y") as p_deadline'))
                ->orderBy('p_code')
                ->get();
        } else {
            $data = DB::table('d_project')
                ->join('m_projecttype', 'p_type', '=', 'pt_code')
                ->select('p_name', 'p_comp', 'p_code', 'p_state', 'pt_detail', DB::raw('date_format(p_kickoff, "%d/%m/%Y") as p_kickoff'), DB::raw('date_format(p_deadline, "%d/%m/%Y") as p_deadline'))
                ->where('p_state', '=', $status)
                ->orderBy('p_code', 'desc')
                ->get();
        }

        $data = collect($data);
        return Datatables::of($data)
            ->editColumn('p_state', function ($data){
                if ($data->p_state == 'RUNNING'){
                    return '<div class="text-center"><span class="label label-table label-info">'.$data->p_state.'</span></div>';
                } elseif ($data->p_state == 'DONE'){
                    return '<div class="text-center"><span class="label label-table label-success">'.$data->p_state.'</span></div>';
                } elseif ($data->p_state == 'FAULT'){
                    return '<div class="text-center"><span class="label label-table label-danger">'.$data->p_state.'</span></div>';
                }
            })
            ->rawColumns(['p_state'])
            ->make(true);
    }
}
