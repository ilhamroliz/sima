<?php

namespace App\Http\Controllers;

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
        $cl_id = Auth::user()->un_companyteam;
        $start = Carbon::createFromFormat('d/m/Y', $request->awal)->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $request->akhir)->format('Y-m-d');
        $project = $request->project;
        $team = $request->team;

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
                ->join('d_companyteam', function ($q){
                    $q->on('ct_id', '=', 'pp_team');
                })
                ->select('p_name', 'pp_date', 'ct_name', 'pf_detail', 'pp_projectcode', 'pf_id')
                ->where('pp_comp', '=', $cl_comp)
                ->where(function ($q) use ($cl_id){
                    $q->orWhere('pp_init', '=', $cl_id);
                    $q->orWhere('pp_team', '=', $cl_id);
                })
                ->whereDate('pp_update', '<=', $end)
                ->whereDate('pp_update', '>=', $start)
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
                        ->join('d_companyteam', function ($q){
                            $q->on('ct_id', '=', 'pp_team');
                        })
                        ->select('p_name', 'pp_date', 'ct_name', 'pf_detail', 'pp_projectcode', 'pf_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->whereDate('pp_update', '<=', $end)
                        ->whereDate('pp_update', '>=', $start)
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
                        ->join('d_companyteam', function ($q){
                            $q->on('ct_id', '=', 'pp_team');
                        })
                        ->select('p_name', 'pp_date', 'ct_name', 'pf_detail', 'pp_projectcode', 'pf_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->whereDate('pp_update', '<=', $end)
                        ->whereDate('pp_update', '>=', $start)
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
                        ->join('d_companyteam', function ($q){
                            $q->on('ct_id', '=', 'pp_team');
                        })
                        ->select('p_name', 'pp_date', 'ct_name', 'pf_detail', 'pp_projectcode', 'pf_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->whereDate('pp_update', '<=', $end)
                        ->whereDate('pp_update', '>=', $start)
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
                        ->join('d_companyteam', function ($q){
                            $q->on('ct_id', '=', 'pp_team');
                        })
                        ->select('p_name', 'pp_date', 'ct_name', 'pf_detail', 'pp_projectcode', 'pf_id')
                        ->where('pp_comp', '=', $cl_comp)
                        ->where(function ($q) use ($cl_id){
                            $q->orWhere('pp_init', '=', $cl_id);
                            $q->orWhere('pp_team', '=', $cl_id);
                        })
                        ->whereDate('pp_update', '<=', $end)
                        ->whereDate('pp_update', '>=', $start)
                        ->orderBy('pp_update')
                        ->get();
                }
            }
        }

        $data = collect($data);
        return Datatables::of($data)
            ->editColumn('pp_date', function ($data){
                return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
            })
            ->setRowId(function ($data) {
                return $data->pp_projectcode;
            })
            ->setRowClass(function (){
                return 'list-progress';
            })
            ->setRowAttr([
                'style' => function() {
                    return 'cursor: pointer';
                },
                'title' => function() {
                    return 'Klik untuk melihat detail';
                }
            ])
            ->make(true);

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

            $cek = DB::table('d_projectprogress')
                ->where('pp_comp', '=', $comp)
                ->where('pp_projectcode', '=', $project)
                ->where('pp_fitur', '=', $fitur)
                ->where('pp_date', '=', $now)
                ->get();

            if (count($cek) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'failed'
                ]);
            } else {
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
                        'pp_note' => $note,
                        'pp_state' => 'Entry',
                        'pp_entry' => Carbon::now('Asia/Jakarta'),
                        'pp_update' => Carbon::now('Asia/Jakarta')
                    ]);
            }



            /*if (count($cek) > 0){
                if (erpController::getPosisi($project) == 'PRJSPV'){
                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $project)
                        ->where('pp_fitur', '=', $fitur)
                        ->update([
                            'pp_init' => Auth::user()->un_companyteam,
                            'pp_date' => Carbon::now('Asia/Jakarta'),
                            'pp_target' => $target,
                            'pp_team' => $eksekutor,
                            'pp_execution' => $eksekusi,
                            'pp_note' => $note,
                            'pp_state' => 'Entry',
                            'pp_update' => Carbon::now('Asia/Jakarta')
                    ]);
                }
            } else {
                if (erpController::getPosisi($project) == 'PRJSPV'){
                    $id = DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $project)
                        ->max('pp_id');

                    ++$id;

                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $project)
                        ->where('pp_fitur', '=', $fitur)
                        ->insert([
                            'pp_comp' => $comp,
                            'pp_projectcode' => $project,
                            'pp_id' => $id,
                            'pp_init' => Auth::user()->un_company,
                            'pp_team' => $eksekutor,
                            'pp_date' => Carbon::now('Asia/Jakarta'),
                            'pp_fitur' => $fitur,
                            'pp_target' => $target,
                            'pp_execution' => $eksekusi,
                            'pp_note' => $note,
                            'pp_state' => 'Entry',
                            'pp_entry' => Carbon::now('Asia/Jakarta'),
                            'pp_update' => Carbon::now('Asia/Jakarta')
                        ]);
                }
            }*/

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

        /*if ($posisi == 'PRJSPV'){
            $data = DB::table('d_projectprogress')
                ->join('d_project', function ($q) use ($cl_comp){
                    $q->on('p_code', '=', 'pp_projectcode');
                    $q->where('p_comp', '=', $cl_comp);
                })
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
                ->select('pp_id', 'pf_detail', 'p_name', DB::raw('i.ct_name as init'), DB::raw('t.ct_name as team'), 'pp_date', 'pp_state', 'pf_detail')
                ->where('pp_projectcode', '=', $project)
                ->where('pp_init', '=', $cl_id)
                ->where('pp_date', '=', $now)
                ->orderBy('pp_date')
                ->get();

            $data = collect($data);
            return DataTables::of($data)
                ->editColumn('pp_state', function ($data){
                    if ($data->pp_state == 'Entry'){
                        return '<div class="text-center"><span class="label label-table label-danger">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Hold'){
                        return '<div class="text-center"><span class="label label-table label-warning">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Revision'){
                        return '<div class="text-center"><span class="label label-table label-info">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Closed'){
                        return '<div class="text-center"><span class="label label-table label-success">'.$data->pp_state.'</span></div>';
                    }
                })
                ->editColumn('pp_date', function ($data){
                    return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
                })
                ->addColumn('aksi', function ($data){
                    return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id.')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                            <button type="button" onclick="hapus('.$data->pp_id.')" title="hapus" class="btn btn-icon waves-effect btn-danger btn-xs"> <i class="fa fa-times"></i> </button></div>';
                })
                ->rawColumns(['pp_date', 'pp_state', 'aksi'])
                ->make(true);

        } else {
            $data = DB::table('d_projectprogress')
                ->join('d_project', function ($q) use ($cl_comp){
                    $q->on('p_code', '=', 'pp_projectcode');
                    $q->where('p_comp', '=', $cl_comp);
                })
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
                ->select('pp_id', 'pf_detail', 'p_name', DB::raw('i.ct_name as init'), DB::raw('t.ct_name as team'), 'pp_date', 'pp_state', 'pf_detail')
                ->where('pp_projectcode', '=', $project)
                ->where('pp_team', '=', $cl_id)
                ->where('pp_date', '=', $now)
                ->get();

            $data = collect($data);
            return DataTables::of($data)
                ->editColumn('pp_state', function ($data){
                    if ($data->pp_state == 'Entry'){
                        return '<div class="text-center"><span class="label label-table label-danger">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Hold'){
                        return '<div class="text-center"><span class="label label-table label-warning">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Revision'){
                        return '<div class="text-center"><span class="label label-table label-info">'.$data->pp_state.'</span></div>';
                    } elseif ($data->pp_state == 'Closed'){
                        return '<div class="text-center"><span class="label label-table label-success">'.$data->pp_state.'</span></div>';
                    }
                })
                ->editColumn('pp_date', function ($data){
                    return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
                })
                ->addColumn('aksi', function ($data){
                    return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id.')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>';
                })
                ->rawColumns(['pp_date', 'pp_state', 'aksi'])
                ->make(true);
        }*/

        $data = DB::table('d_projectprogress')
            ->join('d_project', function ($q) use ($cl_comp){
                $q->on('p_code', '=', 'pp_projectcode');
                $q->where('p_comp', '=', $cl_comp);
            })
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
            ->select('pp_id', 'pf_detail', 'p_name', DB::raw('i.ct_name as init'), DB::raw('t.ct_name as team'), 'pp_date', 'pp_state', 'pf_detail')
            ->where('pp_projectcode', '=', $project)
            ->where('pp_init', '=', $cl_id)
            ->where('pp_date', '=', $now)
            ->orderBy('pp_date')
            ->get();

        $data = collect($data);
        return DataTables::of($data)
            ->editColumn('pp_state', function ($data){
                if ($data->pp_state == 'Entry'){
                    return '<div class="text-center"><span class="label label-table label-danger">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'Hold'){
                    return '<div class="text-center"><span class="label label-table label-warning">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'Revision'){
                    return '<div class="text-center"><span class="label label-table label-info">'.$data->pp_state.'</span></div>';
                } elseif ($data->pp_state == 'Closed'){
                    return '<div class="text-center"><span class="label label-table label-success">'.$data->pp_state.'</span></div>';
                }
            })
            ->editColumn('pp_date', function ($data){
                return Carbon::createFromFormat('Y-m-d', $data->pp_date)->format('d M Y');
            })
            ->addColumn('aksi', function ($data){
                return '<div class="text-center"><button type="button" onclick="edit('.$data->pp_id.')" title="Edit" class="btn btn-icon waves-effect btn-warning btn-xs"> <i class="fa fa-pencil"></i> </button>
                            <button type="button" onclick="hapus('.$data->pp_id.')" title="hapus" class="btn btn-icon waves-effect btn-danger btn-xs"> <i class="fa fa-times"></i> </button></div>';
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
            ->select('pf_id', 'pf_detail', 't.ct_name as team', 'i.ct_name as init', 'pp_target', 'pp_execution', 'pp_note', 'pp_team', 'pp_state')
            ->where('pp_id', '=', $pp_id)
            ->where('pp_comp', '=', $cl_comp)
            ->where('pp_projectcode', '=', $project)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateProgress(Request $request, $project)
    {
        DB::beginTransaction();
        try {
            $note = $request->note;
            $eksekusi = $request->eksekusi;
            $target = $request->target;
            $fitur = $request->fitur;
            $comp = Auth::user()->un_comp;
            $cl_id = Auth::user()->un_companyteam;
            $eksekutor = $request->eksekutor;
            $status = $request->status;

            $info = DB::table('d_projectprogress')
                ->where('pp_comp', '=', $comp)
                ->where('pp_projectcode', '=', $project)
                ->where('pp_fitur', '=', $fitur)
                ->first();

            if (erpController::getPosisi($project) == 'PRJSPV'){
                DB::table('d_projectprogress')
                    ->where('pp_comp', '=', $comp)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_fitur', '=', $fitur)
                    ->update([
                        'pp_date' => Carbon::now('Asia/Jakarta'),
                        'pp_target' => $target,
                        'pp_team' => $eksekutor,
                        'pp_execution' => $eksekusi,
                        'pp_note' => $note,
                        'pp_state' => $status,
                        'pp_update' => Carbon::now('Asia/Jakarta')
                    ]);
            } else {
                if ($info->pp_state == 'Entry'){
                    $status = 'Hold';
                } elseif ($info->pp_state == 'Revision'){
                    $status = 'Entry';
                }
                DB::table('d_projectprogress')
                    ->where('pp_comp', '=', $comp)
                    ->where('pp_projectcode', '=', $project)
                    ->where('pp_fitur', '=', $fitur)
                    ->update([
                        'pp_date' => Carbon::now('Asia/Jakarta'),
                        'pp_target' => $target,
                        'pp_team' => $cl_id,
                        'pp_execution' => $eksekusi,
                        'pp_note' => $note,
                        'pp_state' => $status,
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
                ->where('ct_state', '=', 'ACTIVE')
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

}

