<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ProjectFitur extends Controller
{
    public function getFitur($project)
    {
        $cl_comp = Auth::user()->un_comp;
        $data = DB::table('d_project')
            ->join('d_projectfitur', function ($q){
                $q->on('p_code', '=', 'pf_projectcode');
                $q->on('p_comp', '=', 'pf_comp');
            })
            ->join('m_projecttype', 'pt_code', '=', 'p_type')
            ->select('pf_projectcode', 'p_name', 'p_code', 'p_type', 'pt_detail', 'p_state', 'pf_code', 'pf_id', 'pf_detail', DB::raw('DATE_FORMAT(pf_doneest, "%d/%m/%Y") as pf_doneest'), 'pf_state', DB::raw('concat(floor(pf_progress), " %") as pf_progress'), DB::raw('DATE_FORMAT(pf_deadline, "%d/%m/%Y") as pf_deadline'))
            ->where('p_code', '=', $project)
            ->where('p_comp', '=', $cl_comp)
            ->orderBy('pf_detail')
            ->get();

        $akses = erpController::getPosisi($project);

        $data = collect($data);
        return Datatables::of($data)
            ->addColumn('aksi', function ($data) use ($akses){
                if ($akses == 'COMDIR' || $akses == 'ADMIN' || $akses == 'PRJSPV'){
                    return '<div class="text-center"><button type="button" title="Lihat Progress" class="btn btn-xs btn-icon waves-effect waves-light btn-custom"> <i class="fa fa-line-chart"></i> </button>
                        <button type="button" onclick="editProgress(\''.$data->pf_projectcode.'\','.$data->pf_id.')" title="Edit Progress" class="btn btn-xs btn-icon waves-effect waves-light btn-warning"> <i class="fa fa-edit"></i> </button>
                        </div>';
                } else {
                    return '<div class="text-center"><button type="button" title="Lihat Progress" class="btn btn-xs btn-icon waves-effect waves-light btn-custom"> <i class="fa fa-line-chart"></i> </button>
                        </div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function getInfo(Request $request)
    {
        $fitur = $request->fitur;
        $project = $request->project;
        $comp = Auth::user()->un_comp;
        $data = DB::table('d_projectfitur')
            ->select('d_projectfitur.*', DB::raw('DATE_FORMAT(pf_deadline, "%d/%m/%Y") as pf_deadline'), DB::raw('DATE_FORMAT(pf_doneest, "%d/%m/%Y") as pf_doneest'))
            ->where('pf_comp', '=', $comp)
            ->where('pf_projectcode', '=', $project)
            ->where('pf_id', '=', $fitur)
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function updateProgress(Request $request)
    {
        DB::beginTransaction();
        try {
            $comp = Auth::user()->un_comp;
            $persen = (int) str_replace(' %', '', $request->persentase);
            $poin = $request->point;
            $status = $request->status;
            $deadline = Carbon::createFromFormat('d/m/Y', $request->deadline, 'Asia/Jakarta');
            $durasi = (int) str_replace(' Hari', '', $request->durasi);
            $donest = Carbon::createFromFormat('d/m/Y', $request->donest, 'Asia/Jakarta');
            $project = $request->project;
            $fitur = $request->fitur;
            DB::table('d_projectfitur')
                ->where('pf_projectcode', '=', $project)
                ->where('pf_comp', '=', $comp)
                ->where('pf_id', '=', $fitur)
                ->update([
                    'pf_point' => $poin,
                    'pf_progress' => $persen,
                    'pf_state' => $status,
                    'pf_deadline' => $deadline,
                    'pf_duration' => $durasi,
                    'pf_doneest' => $donest
                ]);

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

}
