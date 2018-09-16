<?php

namespace App\Http\Controllers;
use App\d_companyteam;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProjectTeamController extends Controller
{
    public function index()
    {
        return view('manajemen-project/project-team/project-team');
    }

    public function projectTeam($kode)
    {
        $project = DB::table('d_project')
            ->join('m_projecttype', 'pt_code', '=', 'p_type')
            ->where('p_code', '=', $kode)
            ->where('p_comp', '=', Auth::user()->cl_comp)
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
                ->make(true);
        } elseif ($kode == 'projectteam'){
            $data = DB::table('d_companyteam')
                ->join('d_projectteam', function ($q){
                    $q->on('pt_teamid', '=', 'ct_id');
                })
                ->join('m_position', 'pp_code', '=', 'pt_position')
                ->select('ct_name', 'pp_detail', 'ct_id')
                ->where('pt_comp', '=', Auth::user()->cl_comp)
                ->where('pt_projectcode', '=', $project)
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
                ->where('pt_comp', '=', Auth::user()->cl_comp)
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
                ->where('pt_comp', '=', Auth::user()->cl_comp)
                ->where('pt_projectcode', '=', $p_code)
                ->max('pt_id');

            $id = $getId + 1;

            DB::table('d_projectteam')
                ->insert([
                    'pt_comp' => Auth::user()->cl_comp,
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
            $cl_comp = Auth::user()->cl_comp;

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

}
