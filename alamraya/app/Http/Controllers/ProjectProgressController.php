<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Response;
use Yajra\DataTables\DataTables;

class ProjectProgressController extends Controller
{
    public function index()
    {
        if (Auth::user()->un_companyteam == 'AR000000'){
            $cl_comp = Auth::user()->un_comp;
            $project = DB::table('d_project')
                ->where('p_comp', '=', $cl_comp)
                ->where('p_state', '=', 'RUNNING')
                ->get();
        } else {
            $cl_comp = Auth::user()->un_comp;
            $cl_id = Auth::user()->un_companyteam;
            $project = DB::table('d_projectteam')
                ->join('d_project', function ($q) {
                    $q->on('pt_comp', '=', 'p_comp');
                    $q->on('pt_projectcode', '=', 'p_code');
                    $q->where('p_state', '=', 'RUNNING');
                })
                ->select('p_name', 'p_code')
                ->where('pt_teamid', '=', $cl_id)
                ->where('pt_comp', '=', $cl_comp)
                ->get();
        }

        return view('manajemen-project/project-progress/index', compact('project'));
    }

    public function projectProgress($kode)
    {
        $cl_comp = Auth::user()->un_comp;
        $cl_id = Auth::user()->un_company;
        $posisi = erpController::getPosisi($kode);
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        $project = DB::table('d_project')
            ->join('m_projecttype', 'pt_code', '=', 'p_type')
            ->where('p_code', '=', $kode)
            ->get();

        $info = DB::table('d_projectprogress')
            ->join('d_project', function ($q){
                $q->on('p_code', '=', 'pp_projectcode');
                $q->on('p_comp', '=', 'pp_comp');
            })
            ->join('d_projectfitur', function ($q){
                $q->on('pp_projectcode', '=', 'pf_projectcode');
                $q->on('pp_comp', '=', 'pf_comp');
                $q->on('pp_fitur', '=', 'pf_id');
            })
            ->where('pp_projectcode', '=', $kode)
            ->where('pp_comp', '=', $cl_comp)
            ->where('pp_date', '=', $now)
            ->where(function ($q) use ($cl_id){
                $q->orWhere('pp_init', '=', $cl_id);
                $q->orWhere('pp_team', '=', $cl_id);
            })
            ->get();

        $fitur = [];
        for ($i = 0; $i < count($info); $i++){
            $fitur[$i] = $info[$i]->pf_id;
        }

        $projectFitur = DB::table('d_projectteam')
            ->join('d_project', function ($q) {
                $q->on('p_code', '=', 'pt_projectcode');
                $q->on('p_comp', '=', 'pt_comp');
            })
            ->join('m_projecttype', 'pt_code', '=', 'p_type')
            ->join('d_projectfitur', 'pf_projectcode', '=', 'p_code')
            ->where('pt_projectcode', '=', $kode)
            ->whereNotIn('pf_id', $fitur)
            ->where('pt_comp', '=', Auth::user()->un_comp)
            ->where('pt_teamid', '=', Auth::user()->un_companyteam)
            ->orderBy('pf_detail')
            ->get();

        $team = DB::table('d_projectteam')
            ->join('d_companyteam', 'pt_teamid', '=', 'ct_id')
            ->join('m_position', 'pp_code', '=', 'pt_position')
            ->where('pt_comp', '=', $cl_comp)
            ->where('pt_projectcode', '=', $kode)
            ->get();

        return view('manajemen-project/project-progress/project-progress', compact('team', 'projectFitur', 'info', 'project', 'posisi', 'kode'));
    }

    public function getProjectProgress(Request $request)
    {
        $cl_comp = Auth::user()->un_comp;
        $start = Carbon::createFromFormat('d/m/Y', $request->awal)->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $request->akhir)->format('Y-m-d');
        $project = $request->project;
        if ($project == null){
            $project = [];
        }
        $team = $request->team;

        if (Auth::user()->un_companyteam == 'AR000000'){
            if ($project == 'all'){
                $data = DB::table('d_projectprogress')
                    ->join('d_project', function ($q) {
                        $q->on('pp_projectcode', '=', 'p_code');
                        $q->on('pp_comp', '=', 'p_comp');
                        $q->where('p_state', '=', 'RUNNING');
                    })
                    ->join('d_projectfitur', function ($q){
                        $q->on('pf_id', '=', 'pp_fitur');
                        $q->on('pf_projectcode', '=', 'pp_projectcode');
                    })
                    ->join('d_companyteam as team', function ($q){
                        $q->on('team.ct_id', '=', 'pp_team');
                    })
                    ->join('d_companyteam as init', function ($q){
                        $q->on('init.ct_id', '=', 'pp_init');
                    })
                    ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                    ->where('pp_comp', '=', $cl_comp)
                    ->where('pp_date', '<=', $end)
                    ->where('pp_date', '>=', $start)
                    ->orderBy('pp_update')
                    ->get();
            } else {
                if ($team != null || $team != ''){
                    if (count($project) > 0){
                        // ada team ada project
                        $data = DB::table('d_projectprogress')
                            ->join('d_project', function ($q) {
                                $q->on('pp_projectcode', '=', 'p_code');
                                $q->on('pp_comp', '=', 'p_comp');
                                $q->where('p_state', '=', 'RUNNING');
                            })
                            ->join('d_projectfitur', function ($q){
                                $q->on('pf_id', '=', 'pp_fitur');
                                $q->on('pf_projectcode', '=', 'pp_projectcode');
                            })
                            ->join('d_companyteam as team', function ($q){
                                $q->on('team.ct_id', '=', 'pp_team');
                            })
                            ->join('d_companyteam as init', function ($q){
                                $q->on('init.ct_id', '=', 'pp_init');
                            })
                            ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                            ->where('pp_comp', '=', $cl_comp)
                            ->where('pp_date', '<=', $end)
                            ->where('pp_date', '>=', $start)
                            ->whereIn('pp_projectcode', $project)
                            ->where(function ($q) use ($team){
                                $q->where('pp_team', '=', $team);
                                $q->orWhere('pp_init', '=', $team);
                            })
                            ->orderBy('pp_update')
                            ->get();
                    } else {
                        // ada team gak ada project
                        $data = DB::table('d_projectprogress')
                            ->join('d_project', function ($q) {
                                $q->on('pp_projectcode', '=', 'p_code');
                                $q->on('pp_comp', '=', 'p_comp');
                                $q->where('p_state', '=', 'RUNNING');
                            })
                            ->join('d_projectfitur', function ($q){
                                $q->on('pf_id', '=', 'pp_fitur');
                                $q->on('pf_projectcode', '=', 'pp_projectcode');
                            })
                            ->join('d_companyteam as team', function ($q){
                                $q->on('team.ct_id', '=', 'pp_team');
                            })
                            ->join('d_companyteam as init', function ($q){
                                $q->on('init.ct_id', '=', 'pp_init');
                            })
                            ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                            ->where('pp_comp', '=', $cl_comp)
                            ->where('pp_date', '<=', $end)
                            ->where('pp_date', '>=', $start)
                            ->where(function ($q) use ($team){
                                $q->where('pp_team', '=', $team);
                                $q->orWhere('pp_init', '=', $team);
                            })
                            ->orderBy('pp_update')
                            ->get();
                    }
                } else {
                    if (count($project) > 0){
                        // gak ada team ada project
                        $data = DB::table('d_projectprogress')
                            ->join('d_project', function ($q) {
                                $q->on('pp_projectcode', '=', 'p_code');
                                $q->on('pp_comp', '=', 'p_comp');
                                $q->where('p_state', '=', 'RUNNING');
                            })
                            ->join('d_projectfitur', function ($q){
                                $q->on('pf_id', '=', 'pp_fitur');
                                $q->on('pf_projectcode', '=', 'pp_projectcode');
                            })
                            ->join('d_companyteam as team', function ($q){
                                $q->on('team.ct_id', '=', 'pp_team');
                            })
                            ->join('d_companyteam as init', function ($q){
                                $q->on('init.ct_id', '=', 'pp_init');
                            })
                            ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                            ->where('pp_comp', '=', $cl_comp)
                            ->where('pp_date', '<=', $end)
                            ->where('pp_date', '>=', $start)
                            ->whereIn('pp_projectcode', $project)
                            ->orderBy('pp_update')
                            ->get();
                    } else {
                        // gak ada team gak ada project
                        $data = DB::table('d_projectprogress')
                            ->join('d_project', function ($q) {
                                $q->on('pp_projectcode', '=', 'p_code');
                                $q->on('pp_comp', '=', 'p_comp');
                                $q->where('p_state', '=', 'RUNNING');
                            })
                            ->join('d_projectfitur', function ($q){
                                $q->on('pf_id', '=', 'pp_fitur');
                                $q->on('pf_projectcode', '=', 'pp_projectcode');
                            })
                            ->join('d_companyteam as team', function ($q){
                                $q->on('team.ct_id', '=', 'pp_team');
                            })
                            ->join('d_companyteam as init', function ($q){
                                $q->on('init.ct_id', '=', 'pp_init');
                            })
                            ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                            ->where('pp_comp', '=', $cl_comp)
                            ->where('pp_date', '<=', $end)
                            ->where('pp_date', '>=', $start)
                            ->orderBy('pp_update')
                            ->get();
                    }
                }
            }

            $data = collect($data);
            return Datatables::of($data)
                ->addColumn('aksi', function ($data){
                    if ($data->pp_notestate == '10' || $data->pp_notestate == '20'){
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-success noti-icon-badge"><i class="mdi mdi-check-all"></i></span></div></div>';
                    } elseif ($data->pp_notestate == '11' || $data->pp_notestate == '21'){
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-primary noti-icon-badge"><i class="mdi mdi-check"></i></span></div></div>';
                    } else {
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                            <button type="button" onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon waves-effect btn-info btn-xs"> <i class="icon-note"></i> </button></div>';
                    }
                })
                ->editColumn('pp_date', function ($data){
                    return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
                })
                ->setRowId(function ($data) {
                    return $data->pp_projectcode;
                })
                ->setRowClass(function (){
                    return 'list-progress';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        } else {
            $data = $this->getProjectProgressAll($request);
            $data = collect($data);
            return Datatables::of($data)
                ->addColumn('aksi', function ($data){

                    if ($data->id_eksekutor == Auth::user()->un_companyteam){
                        //== user adalah eksekutor
                        if ($data->pp_notestate == '10'){
                            //read by inisiator
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-success noti-icon-badge"><i class="mdi mdi-check-all"></i></span></div></div>';
                        } elseif ($data->pp_notestate == '11'){
                            //edit by inisiator
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-warning noti-icon-badge">!</span></div></div>';
                        } elseif ($data->pp_notestate == '20'){
                            //read by eksekutor
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                        } elseif ($data->pp_notestate == '21'){
                            //edit by eksekutor
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-primary noti-icon-badge"><i class="mdi mdi-check"></i></span></div></div>';
                        } else {
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                        }
                    } else if ($data->id_inisiator == Auth::user()->un_companyteam){
                        //== user adalah inisiator
                        if ($data->pp_notestate == '10'){
                            //read by inisiator
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                        } elseif ($data->pp_notestate == '11'){
                            //edit by inisiator
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-primary noti-icon-badge"><i class="mdi mdi-check"></i></span></div></div>';
                        } elseif ($data->pp_notestate == '20'){
                            //read by eksekutor
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-success noti-icon-badge"><i class="mdi mdi-check-all"></i></span></div></div>';
                        } elseif ($data->pp_notestate == '21'){
                            //edit by eksekutor
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-warning noti-icon-badge">!</span></div></div>';
                        } else {
                            return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                        }
                    }


                })
                ->editColumn('pp_date', function ($data){
                    return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
                })
                ->setRowId(function ($data) {
                    return $data->pp_projectcode;
                })
                ->setRowClass(function (){
                    return 'list-progress';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function getProjectProgressAll(Request $request)
    {
        $cl_comp = Auth::user()->un_comp;
        $cl_id = Auth::user()->un_companyteam;
        $start = Carbon::createFromFormat('d/m/Y', $request->awal)->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $request->akhir)->format('Y-m-d');
        $project = $request->project;
        $team = $request->team;
        $data = [];
        if ($project == null){
            $project = [];
        }

        if ($project == 'all'){
            $data = DB::table('d_projectprogress')
                ->join('d_project', function ($q) {
                    $q->on('pp_projectcode', '=', 'p_code');
                    $q->on('pp_comp', '=', 'p_comp');
                    $q->where('p_state', '=', 'RUNNING');
                })
                ->join('d_projectfitur', function ($q){
                    $q->on('pf_id', '=', 'pp_fitur');
                    $q->on('pf_projectcode', '=', 'pp_projectcode');
                })
                ->join('d_companyteam as team', function ($q){
                    $q->on('team.ct_id', '=', 'pp_team');
                })
                ->join('d_companyteam as init', function ($q){
                    $q->on('init.ct_id', '=', 'pp_init');
                })
                ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                ->where('pp_comp', '=', $cl_comp)
                ->where(function ($q) use ($cl_id){
                    $q->orWhere('pp_init', '=', $cl_id);
                    $q->orWhere('pp_team', '=', $cl_id);
                })
                ->where('pp_date', '<=', $end)
                ->where('pp_date', '>=', $start)
                ->orderBy('pp_update')
                ->get();
        } else {
            if ($team != null || $team != ''){
                if (count($project) > 0){
                    // ada team ada project
                    $data = DB::table('d_projectprogress')
                        ->join('d_project', function ($q) {
                            $q->on('pp_projectcode', '=', 'p_code');
                            $q->on('pp_comp', '=', 'p_comp');
                            $q->where('p_state', '=', 'RUNNING');
                        })
                        ->join('d_projectfitur', function ($q){
                            $q->on('pf_id', '=', 'pp_fitur');
                            $q->on('pf_projectcode', '=', 'pp_projectcode');
                        })
                        ->join('d_companyteam as team', function ($q){
                            $q->on('team.ct_id', '=', 'pp_team');
                        })
                        ->join('d_companyteam as init', function ($q){
                            $q->on('init.ct_id', '=', 'pp_init');
                        })
                        ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->where('pp_date', '<=', $end)
                        ->where('pp_date', '>=', $start)
                        ->whereIn('pp_projectcode', $project)
                        ->where(function ($q) use ($team){
                            $q->where('pp_team', '=', $team);
                            $q->orWhere('pp_init', '=', $team);
                        })
                        ->orderBy('pp_update')
                        ->get();
                } else {
                    // ada team gak ada project
                    $data = DB::table('d_projectprogress')
                        ->join('d_project', function ($q) {
                            $q->on('pp_projectcode', '=', 'p_code');
                            $q->on('pp_comp', '=', 'p_comp');
                            $q->where('p_state', '=', 'RUNNING');
                        })
                        ->join('d_projectfitur', function ($q){
                            $q->on('pf_id', '=', 'pp_fitur');
                            $q->on('pf_projectcode', '=', 'pp_projectcode');
                        })
                        ->join('d_companyteam as team', function ($q){
                            $q->on('team.ct_id', '=', 'pp_team');
                        })
                        ->join('d_companyteam as init', function ($q){
                            $q->on('init.ct_id', '=', 'pp_init');
                        })
                        ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->where('pp_date', '<=', $end)
                        ->where('pp_date', '>=', $start)
                        ->where(function ($q) use ($team){
                            $q->where('pp_team', '=', $team);
                            $q->orWhere('pp_init', '=', $team);
                        })
                        ->orderBy('pp_update')
                        ->get();
                }
            } else {
                if (count($project) > 0){
                    // gak ada team ada project
                    $data = DB::table('d_projectprogress')
                        ->join('d_project', function ($q) {
                            $q->on('pp_projectcode', '=', 'p_code');
                            $q->on('pp_comp', '=', 'p_comp');
                            $q->where('p_state', '=', 'RUNNING');
                        })
                        ->join('d_projectfitur', function ($q){
                            $q->on('pf_id', '=', 'pp_fitur');
                            $q->on('pf_projectcode', '=', 'pp_projectcode');
                        })
                        ->join('d_companyteam as team', function ($q){
                            $q->on('team.ct_id', '=', 'pp_team');
                        })
                        ->join('d_companyteam as init', function ($q){
                            $q->on('init.ct_id', '=', 'pp_init');
                        })
                        ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->where('pp_date', '<=', $end)
                        ->where('pp_date', '>=', $start)
                        ->whereIn('pp_projectcode', $project)
                        ->orderBy('pp_update')
                        ->get();
                } else {
                    // gak ada team gak ada project
                    $data = DB::table('d_projectprogress')
                        ->join('d_project', function ($q) {
                            $q->on('pp_projectcode', '=', 'p_code');
                            $q->on('pp_comp', '=', 'p_comp');
                            $q->where('p_state', '=', 'RUNNING');
                        })
                        ->join('d_projectfitur', function ($q){
                            $q->on('pf_id', '=', 'pp_fitur');
                            $q->on('pf_projectcode', '=', 'pp_projectcode');
                        })
                        ->join('d_companyteam as team', function ($q){
                            $q->on('team.ct_id', '=', 'pp_team');
                        })
                        ->join('d_companyteam as init', function ($q){
                            $q->on('init.ct_id', '=', 'pp_init');
                        })
                        ->select('pp_notestate', 'p_name', 'pp_date', 'team.ct_id as id_eksekutor', 'init.ct_id as id_inisiator', 'team.ct_name as eksekutor', 'init.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->where('pp_date', '<=', $end)
                        ->where('pp_date', '>=', $start)
                        ->orderBy('pp_update')
                        ->get();
                }
            }
        }

        return $data;
    }

    public function saveInit(Request $request, $project)
    {
        DB::beginTransaction();
        try {
            $note = $request->note;
            $eksekusi = $request->eksekusi;
            $target = $request->target;
            $fitur = $request->fitur;
            $comp = Auth::user()->un_comp;
            $eksekutor = $request->eksekutor;
            $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');
            $posisi = erpController::getPosisi($project);
            $noteStatus = null;

            if ($note != null || $note != ''){
                $time = Carbon::now('Asia/Jakarta')->format('H:i');
                $temp = [];
                $temp['team'] = Auth::user()->un_companyteam;
                $temp['time'] = $time;
                $temp['date'] = $now;
                $temp['note'] = $note;
                $note = json_encode([$temp]);
                $noteStatus = '11';
            };

            $cek = DB::table('d_projectprogress')
                ->where('pp_comp', '=', $comp)
                ->where('pp_projectcode', '=', $project)
                ->where('pp_fitur', '=', $fitur)
                ->where('pp_date', '=', $now)
                ->where('pp_team', '=', $eksekutor)
                ->get();

            if (count($cek) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'failed'
                ]);
            } else {
                if ($posisi == 'PRJSPV') {
                    $id = DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $project)
                        ->max('pp_id');
                    ++$id;

                    DB::table('d_projectprogress')
                        ->insert([
                            'pp_comp' => $comp,
                            'pp_projectcode' => $project,
                            'pp_id' => $id,
                            'pp_init' => Auth::user()->un_companyteam,
                            'pp_team' => $eksekutor,
                            'pp_date' => Carbon::now('Asia/Jakarta'),
                            'pp_fitur' => $fitur,
                            'pp_target' => $target,
                            'pp_execution' => $eksekusi,
                            'pp_notestate' => $noteStatus,
                            'pp_note' => $note,
                            'pp_state' => 'ENTRY',
                            'pp_entry' => Carbon::now('Asia/Jakarta'),
                            'pp_update' => Carbon::now('Asia/Jakarta')
                        ]);
                } else {
                    DB::rollback();
                    return response()->json([
                        'status' => 'failed'
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'data' => $e
            ]);
        }
    }

    public function dataProgress($project)
    {
        $posisi = erpController::getPosisi($project);
        $cl_comp = Auth::user()->un_comp;
        $cl_id = Auth::user()->un_companyteam;
        $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');

        if ($posisi == 'COMDIR' || $posisi == 'PRJSPV'){
            $data = DB::table('d_projectprogress')
                ->join('d_project', function ($q) use ($cl_comp) {
                    $q->on('p_code', '=', 'pp_projectcode');
                    $q->where('p_comp', '=', $cl_comp);
                })
                ->join('d_companyteam as i', function ($w) use ($cl_comp) {
                    $w->on('i.ct_id', '=', 'pp_init');
                    $w->where('i.ct_comp', '=', $cl_comp);
                })
                ->join('d_companyteam as t', function ($w) use ($cl_comp) {
                    $w->on('t.ct_id', '=', 'pp_team');
                    $w->where('t.ct_comp', '=', $cl_comp);
                })
                ->join('d_projectfitur', function ($q) use ($project) {
                    $q->on('pf_id', '=', 'pp_fitur');
                    $q->where('pf_projectcode', '=', $project);
                })
                ->select('pp_notestate', 'p_name', 'pp_date', 't.ct_id as id_eksekutor', 'i.ct_id as id_inisiator', 't.ct_name as eksekutor', 'i.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id', 'pp_state')
                ->where('pp_projectcode', '=', $project)
                ->where('pp_date', '=', $now)
                ->orderBy('pp_date')
                ->get();
        } else {
            $data = DB::table('d_projectprogress')
                ->join('d_project', function ($q) use ($cl_comp) {
                    $q->on('p_code', '=', 'pp_projectcode');
                    $q->where('p_comp', '=', $cl_comp);
                })
                ->join('d_companyteam as i', function ($w) use ($cl_comp) {
                    $w->on('i.ct_id', '=', 'pp_init');
                    $w->where('i.ct_comp', '=', $cl_comp);
                })
                ->join('d_companyteam as t', function ($w) use ($cl_comp) {
                    $w->on('t.ct_id', '=', 'pp_team');
                    $w->where('t.ct_comp', '=', $cl_comp);
                })
                ->join('d_projectfitur', function ($q) use ($project) {
                    $q->on('pf_id', '=', 'pp_fitur');
                    $q->where('pf_projectcode', '=', $project);
                })
                ->select('pp_notestate', 'p_name', 'pp_date', 't.ct_id as id_eksekutor', 'i.ct_id as id_inisiator', 't.ct_name as eksekutor', 'i.ct_name as inisiator', 'pf_detail', 'pp_projectcode', 'pf_id', 'pp_id', 'pp_state')
                ->where('pp_projectcode', '=', $project)
                ->where(function ($q) use ($cl_id) {
                    $q->where('pp_init', '=', $cl_id);
                    $q->orWhere('pp_team', '=', $cl_id);
                })
                ->where('pp_date', '=', $now)
                ->orderBy('pp_date')
                ->get();
        }

        $data = collect($data);
        return DataTables::of($data)
            ->editColumn('pp_state', function ($data){
                if ($data->pp_state == 'ENTRY'){
                    return '<div class="text-center"><span class="label label-table label-danger">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'HOLD'){
                    return '<div class="text-center"><span class="label label-table label-warning">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'REVISION'){
                    return '<div class="text-center"><span class="label label-table label-info">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'CLOSED'){
                    return '<div class="text-center"><span class="label label-table label-success">'.$data->pp_state.'</span></div>';
                }
            })
            ->editColumn('pp_date', function ($data){
                return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
            })
            ->addColumn('aksi', function ($data){
                if ($data->id_eksekutor == Auth::user()->un_companyteam){
                    //== user adalah eksekutor
                    if ($data->pp_notestate == '10'){
                        //read by inisiator
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-success noti-icon-badge"><i class="mdi mdi-check-all"></i></span></div></div>';
                    } elseif ($data->pp_notestate == '11'){
                        //edit by inisiator
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-warning noti-icon-badge">!</span></div></div>';
                    } elseif ($data->pp_notestate == '20'){
                        //read by eksekutor
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                    } elseif ($data->pp_notestate == '21'){
                        //edit by eksekutor
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-primary noti-icon-badge"><i class="mdi mdi-check"></i></span></div></div>';
                    } else {
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                    }
                } else if ($data->id_inisiator == Auth::user()->un_companyteam){
                    //== user adalah inisiator
                    if ($data->pp_notestate == '10'){
                        //read by inisiator
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                    } elseif ($data->pp_notestate == '11'){
                        //edit by inisiator
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-primary noti-icon-badge"><i class="mdi mdi-check"></i></span></div></div>';
                    } elseif ($data->pp_notestate == '20'){
                        //read by eksekutor
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-success noti-icon-badge"><i class="mdi mdi-check-all"></i></span></div></div>';
                    } elseif ($data->pp_notestate == '21'){
                        //edit by eksekutor
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button><span class="badge badge-warning noti-icon-badge">!</span></div></div>';
                    } else {
                        return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                                    <div class="list-inline-item dropdown notification-list" style="cursor: pointer"><button style="cursor: pointer" type="button"  onclick="note('.$data->pp_id. ',\'' . $data->pp_projectcode. '\')" title="Catatan" class="btn btn-icon btn-info btn-xs"> <i class="icon-note"></i> </button></div></div>';
                    }
                }


            })
            ->rawColumns(['pp_date', 'pp_state', 'aksi'])
            ->make(true);

    }

    public function getProgress(Request $request, $project)
    {
        $cl_comp = Auth::user()->un_comp;
        $pp_id = $request->pp_id;
        $data = DB::table('d_projectprogress')
            ->join('d_companyteam as i', function ($w) use ($cl_comp){
                $w->on('i.ct_id', '=', 'pp_init');
                $w->where('i.ct_comp', '=', $cl_comp);
            })
            ->join('d_companyteam as t', function ($w) use ($cl_comp){
                $w->on('t.ct_id', '=', 'pp_team');
                $w->where('t.ct_comp', '=', $cl_comp);
            })
            ->join('d_projectfitur', function ($q) use ($project) {
                $q->on('pf_id', '=', 'pp_fitur');
                $q->where('pf_projectcode', '=', $project);
            })
            ->select('pp_date', 'pp_id', 'pf_id', 'pf_detail', 't.ct_name as team', 'i.ct_name as init', 'pp_target', 'pp_execution', 'pp_team', 'pp_state')
            ->where('pp_id', '=', $pp_id)
            ->where('pp_comp', '=', $cl_comp)
            ->where('pp_projectcode', '=', $project)
            ->get();

            if ($data != null){
                if (count($data) > 0){
                    $data[0]->pp_date = Carbon::createFromFormat('Y-m-d', $data[0]->pp_date)->format('d M Y');
                }
            }

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateProgress(Request $request, $project)
    {
        DB::beginTransaction();
        try {
            $eksekusi = $request->eksekusi;
            $target = $request->target;
            $pp_id = $request->pp_id;
            $comp = Auth::user()->un_comp;
            $cl_id = Auth::user()->un_companyteam;
            $eksekutor = $request->eksekutor;

            $info = DB::table('d_projectprogress')
                ->where('pp_comp', '=', $comp)
                ->where('pp_projectcode', '=', $project)
                ->where('pp_id', '=', $pp_id)
                ->first();

            if (erpController::getPosisi($project) == 'PRJSPV' || erpController::getPosisi($project) == 'COMDIR'){
                $status = $request->status;
                DB::table('d_projectprogress')
                    ->where('pp_comp', '=', $comp)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_id', '=', $pp_id)
                    ->update([
                        'pp_target' => $target,
                        'pp_team' => $eksekutor,
                        'pp_state' => $status,
                        'pp_update' => Carbon::now('Asia/Jakarta')
                    ]);
            } else {
                DB::table('d_projectprogress')
                    ->where('pp_comp', '=', $comp)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_id', '=', $pp_id)
                    ->update([
                        'pp_team' => $cl_id,
                        'pp_execution' => $eksekusi,
                        'pp_update' => Carbon::now('Asia/Jakarta')
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'success'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'failed',
                'data' => $e
            ]);
        }
    }

    public function getTeam(Request $request)
    {
        $keyword = $request->query->all()['query'];
        if (Auth::user()->un_companyteam == 'AR000000'){
            $data = DB::table('d_companyteam')
                ->select('ct_name', 'ct_id')
                ->where(function ($q){
                    $q->orWhere('ct_state', '=', 'ACTIVE');
                    $q->orWhere('ct_state', '=', 'TRIAL');
                })
                ->where('ct_name', 'like', '%'.$keyword.'%')
                ->get();
        } else {
            $data = DB::select("select * from d_projectprogress inner join d_projectteam on pp_projectcode = pt_projectcode and pp_comp = pt_comp inner join d_companyteam as init on pp_init = init.ct_id and pp_comp = init.ct_comp inner join d_companyteam as team on pp_team = team.ct_id and pp_comp = team.ct_comp where pp_comp = '".Auth::user()->un_comp."'and (init.ct_name like '%".$keyword."%' or team.ct_name like '%".$keyword."%') group by init.ct_id, team.ct_id");
        }

        if ($data == null) {
            $in = array(
                "suggestions" => array(
                    array("value" => "Tidak ditemukan", "data" => null)
                )
            );
        } else {
            $in = array(
                "suggestions" => array(

                )
            );
            foreach ($data as $query) {
                $temp = array("value" => $query->ct_name, "data" => $query->ct_id);
                array_push($in['suggestions'], $temp);
            }
        }
        return Response::json($in);
    }

    public function chat(Request $request)
    {
        $pp_id = $request->id;
        $pp_projectcode = $request->project;

        $data = DB::table('d_projectprogress')
            ->join('d_projectfitur', function ($q){
                $q->on('pf_id', '=', 'pp_fitur');
                $q->on('pf_projectcode', '=', 'pp_projectcode');
            })
            ->select('pp_note', 'pf_detail', 'pp_date', 'pp_team', 'pp_init', 'pp_notestate')
            ->where('pp_comp', '=', Auth::user()->un_comp)
            ->where('pp_projectcode', '=', $pp_projectcode)
            ->where('pp_id', '=', $pp_id)
            ->first();

        $chat = json_decode($data->pp_note);

        if ($chat != null) {
            for ($i = 0; $i < count($chat); $i++) {
                $ct_id = DB::table('d_companyteam')
                    ->where('ct_id', '=', $chat[$i]->team)
                    ->first();

                $chat[$i]->name = $ct_id->ct_name;
                $chat[$i]->date = Carbon::createFromFormat('Y-m-d', $chat[$i]->date)->format('d M Y');
            }
        }

        if ($data->pp_notestate != null){
            if (Auth::user()->un_companyteam == $data->pp_team){
                //== user adalah eksekutor
                if ($data->pp_notestate == '11'){
                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', Auth::user()->un_comp)
                        ->where('pp_projectcode', '=', $pp_projectcode)
                        ->where('pp_id', '=', $pp_id)
                        ->update([
                            'pp_notestate' => '20'
                        ]);
                }
            } elseif (Auth::user()->un_companyteam == $data->pp_init){
                //== user adalah inisiator
                if ($data->pp_notestate == '21'){
                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', Auth::user()->un_comp)
                        ->where('pp_projectcode', '=', $pp_projectcode)
                        ->where('pp_id', '=', $pp_id)
                        ->update([
                            'pp_notestate' => '10'
                        ]);
                }
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $chat,
            'fitur' => $data->pf_detail,
            'tanggal' => Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y')
        ]);
    }

    public function saveNote(Request $request)
    {
        DB::beginTransaction();
        try {
            $project = $request->project;
            $pp_id = $request->id;
            $note = $request->note;
            $now = Carbon::now('Asia/Jakarta')->format('Y-m-d');

            $get = DB::table('d_projectprogress')
                ->select('pp_note', 'pp_team', 'pp_init')
                ->where('pp_projectcode', '=', $project)
                ->where('pp_id', '=', $pp_id)
                ->where('pp_comp', '=', Auth::user()->un_comp)
                ->first();

            $noteAwal = json_decode($get->pp_note);
            if ($noteAwal == null){
                $noteAwal = [];
            }

            if ($note != null || $note != ''){
                $time = Carbon::now('Asia/Jakarta')->format('H:i');
                $temp = [];
                $temp['team'] = Auth::user()->un_companyteam;
                $temp['time'] = $time;
                $temp['date'] = $now;
                $temp['note'] = $note;
                $note = json_encode([$temp]);

                $note = json_decode($note);
                array_push($noteAwal, $note[0]);
                $note = json_encode($noteAwal);
            } else {
                $note = json_encode($noteAwal);
            }

            if (Auth::user()->un_companyteam == $get->pp_team){
                //== user adalah eksekutor
                DB::table('d_projectprogress')
                    ->where('pp_id', '=', $pp_id)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_comp', '=', Auth::user()->un_comp)
                    ->update([
                        'pp_note' => $note,
                        'pp_notestate' => '21'
                    ]);
            } elseif (Auth::user()->un_companyteam == $get->pp_init){
                //== user adalah inisiator
                DB::table('d_projectprogress')
                    ->where('pp_id', '=', $pp_id)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_comp', '=', Auth::user()->un_comp)
                    ->update([
                        'pp_note' => $note,
                        'pp_notestate' => '11'
                    ]);
            }

            $data = DB::table('d_projectprogress')
                ->select('pp_note')
                ->where('pp_projectcode', '=', $project)
                ->where('pp_id', '=', $pp_id)
                ->where('pp_comp', '=', Auth::user()->un_comp)
                ->first();
            $data = json_decode($data->pp_note);
            DB::commit();
            return response()->json($data);
        } catch (\Exception $e){
            DB::rollback();
            return 'gagal';
        }
    }

    public function controllProgress()
    {
        $data = DB::select("select prj.p_name, team.ct_name as eksekutor, spv.ct_name as supervisor,
(select 'oke' from d_projectprogress where pp_projectcode = prj.p_code and pp_comp = prj.p_comp and pp_team = team.ct_id and pp_date = CURDATE() and pp_execution is not null group by pp_team) as status
from d_companyteam team
JOIN d_projectteam pt on pt.pt_comp = team.ct_comp and team.ct_id = pt.pt_teamid
join d_project prj on prj.p_comp = pt.pt_comp and prj.p_code = pt.pt_projectcode
left join 
	(SELECT super.ct_comp, super.ct_id, super.ct_name, ptspv.pt_comp, ptspv.pt_position, ptspv.pt_projectcode, ptspv.pt_teamid from d_companyteam super 
	join d_projectteam ptspv 
	on ptspv.pt_comp = super.ct_comp 
	and super.ct_id = ptspv.pt_teamid 
	where ptspv.pt_position = 'PRJSPV') spv 
	on (spv.ct_comp = pt.pt_comp and spv.pt_projectcode = prj.p_code) 
where prj.p_state = 'RUNNING'
and (team.ct_state = 'ACTIVE' or team.ct_state = 'TRIAL')
order by team.ct_name");

        $data = collect($data);
        return DataTables::of($data)
            ->editColumn('status', function ($data){
                if ($data->status == null){
                    return '<div class="text-center"><button type="button" class="btn btn-icon btn-xs waves-effect waves-light btn-danger"> <strong><i class="fi fi-cross"></i></strong> </button></div>';
                } elseif ($data->status == 'oke'){
                    return '<div class="text-center"><button type="button" class="btn btn-icon btn-xs waves-effect waves-light btn-info"> <strong><i class="fi fi-check"></i></strong> </button></div>';
                }
            })
            ->rawColumns(['status'])
            ->make(true);
    }

}
