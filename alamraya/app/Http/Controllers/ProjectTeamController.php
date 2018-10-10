<?php

namespace App\Http\Controllers;
use App\d_companyteam;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use GeniusTS\HijriDate\Hijri;
use GeniusTS\HijriDate\Date;

class ProjectTeamController extends Controller
{
    public function index()
    {
        return view('manajemen-project/project-team/index');
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
                ->orderBy('p_code')
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
            ->editColumn('p_kickoff', function ($data){
                return "<div class='text-center'>".Carbon::createFromFormat('d/m/Y', $data->p_kickoff)->format('d M Y')."</div>";
            })
            ->editColumn('p_deadline', function ($data){
                return "<div class='text-center'>".Carbon::createFromFormat('d/m/Y', $data->p_deadline)->format('d M Y')."</div>";
            })
            ->setRowId(function ($data) {
                return $data->p_code;
            })
            ->setRowClass(function (){
                return 'contextMenu list-project';
            })
            ->setRowAttr([
                'style' => function() {
                    return 'cursor: pointer';
                },
                'title' => function() {
                    return 'Klik kiri untuk menampilkan team project';
                }
            ])
            ->setRowData([
                'onclick' => function($data) {
                    return "detail('".$data->p_code."')";
                }
            ])
            ->rawColumns(['p_state', 'p_kickoff', 'p_deadline'])
            ->make(true);
    }

    public function projectTeam($kode)
    {
        $cl_id = Auth::user()->un_companyteam;
        if ($cl_id != 'AR000000' && $cl_id != 'AR000009'){
            abort(403, 'Unauthorized action.');
        }
        $project = DB::table('d_project')
            ->join('m_projecttype', 'pt_code', '=', 'p_type')
            ->where('p_code', '=', $kode)
            ->where('p_comp', '=', Auth::user()->un_comp)
            ->get();

        $posisi = DB::table('m_position')
            ->get();

        if (count($project) > 0){
            Carbon::setLocale('id');
            $project[0]->deadline = Carbon::createFromFormat('Y-m-d', $project[0]->p_deadline)->diffForHumans();
        }

        return view('manajemen-project/project-team/project-team', compact('project', 'posisi'));
    }

    public function getData(Request $request){
        $kode = $request->kode;
        $project = $request->project;

        if ($kode == 'ourteam'){
            $team = d_companyteam::where('ct_state', '=', 'Active')->orderBy('ct_id')->get();
            $team = collect($team);

            return DataTables::of($team)
                ->addColumn('aksi', function ($team){
                    return '<div class="text-center">
                            <button type="button" title="Masukkan" class="btn btn-icon waves-effect btn-pink btn-xs"> <i class="fa fa-arrow-circle-right"></i> </button>
                            </div>';
                })
                ->setRowClass(function (){
                    return 'row-team';
                })
                ->setRowId(function ($data) {
                    return $data->ct_id;
                })
                ->setRowAttr([
                    'style' => function() {
                        return 'cursor: pointer';
                    },
                    'title' => function() {
                        return 'Klik untuk menambahkan';
                    }
                ])
                ->rawColumns(['aksi'])
                ->make(true);
        } elseif ($kode == 'projectteam'){
            $data = DB::table('d_companyteam')
                ->join('d_projectteam', function ($q){
                    $q->on('pt_teamid', '=', 'ct_id');
                })
                ->join('m_position', 'pp_code', '=', 'pt_position')
                ->select('ct_name', 'pp_detail', 'ct_id')
                ->where('pt_comp', '=', Auth::user()->un_comp)
                ->where('pt_projectcode', '=', $project)
                ->orderBy('pp_urut')
                ->get();

            return DataTables::of($data)
                ->addColumn('aksi', function ($data){
                    return '<div class="text-center">
                            <button type="button" onclick="gantiPosisi(\''.$data->ct_id.'\')" title="Ganti Posisi" class="btn btn-icon waves-effect btn-primary btn-xs"> <i class="fa fa-exchange"></i> </button>
                            <button type="button" onclick="hapus(\''.$data->ct_id.'\')" title="Delete" class="btn btn-icon waves-effect btn-danger btn-xs"> <i class="fa fa-times"></i> </button>
                            </div>';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function addTeam(Request $request)
    {
        DB::beginTransaction();
        try{
            $p_code = $request->p_code;
            $ct_id = $request->ct_id;
            $pp_code = $request->position;

            $check = DB::table('d_projectteam')
                ->where('pt_comp', '=', Auth::user()->un_comp)
                ->where('pt_projectcode', '=', $p_code)
                ->where('pt_teamid', '=', $ct_id)
                ->get();

            if (count($check) > 0){
                DB::rollback();
                return response()->json([
                    'status' => 'already'
                ]);
            }

            $getId = DB::table('d_projectteam')
                ->where('pt_comp', '=', Auth::user()->un_comp)
                ->where('pt_projectcode', '=', $p_code)
                ->max('pt_id');

            $id = $getId + 1;

            DB::table('d_projectteam')
                ->insert([
                    'pt_comp' => Auth::user()->un_comp,
                    'pt_projectcode' => $p_code,
                    'pt_id' => $id,
                    'pt_position' => $pp_code,
                    'pt_teamid' => $ct_id
                ]);

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

    public function deleteTeam(Request $request)
    {
        DB::beginTransaction();
        try {
            $ct_id = $request->ct_id;
            $p_code = $request->p_code;
            $cl_comp = Auth::user()->un_comp;

            DB::table('d_projectteam')
                ->where('pt_comp', '=', $cl_comp)
                ->where('pt_projectcode', '=', $p_code)
                ->where('pt_teamid', '=', $ct_id)
                ->delete();

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

    public function projectPosition()
    {
        $project = [];
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
        return view('manajemen-project/project-team/project-position', compact('project'));
    }

    public function getPosition()
    {
        $id = Auth::user()->un_companyteam;
        $data = [];
        if ($id == 'AR000000'){
            $data = DB::table('d_projectteam')
                ->join('d_project', function ($q){
                    $q->on('p_code', '=', 'pt_projectcode');
                    $q->on('p_comp', '=', 'pt_comp');
                })
                ->join('m_position', 'pp_code', 'pt_position')
                ->join('d_companyteam', function ($q){
                    $q->on('pt_teamid', '=', 'ct_id');
                    $q->on('pt_comp', '=', 'ct_comp');
                })
                ->select('p_name', 'p_state', 'pp_detail', 'ct_name')
                ->where('p_state', '=', 'RUNNING')
                ->get();
        } else {
            $data = DB::table('d_projectteam')
                ->join('d_project', function ($q){
                    $q->on('p_code', '=', 'pt_projectcode');
                    $q->on('p_comp', '=', 'pt_comp');
                })
                ->join('m_position', 'pp_code', 'pt_position')
                ->select('p_name', 'p_state', 'pp_detail')
                ->where('pt_teamid', '=', $id)
                ->where('p_state', '=', 'RUNNING')
                ->get();
        }
        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                            <button type="button" class="btn btn-icon waves-effect btn-primary btn-xs"> <i class="fa fa-folder-open-o"></i> </button>
                            </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
