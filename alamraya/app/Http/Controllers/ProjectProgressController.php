<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class ProjectProgressController extends Controller
{
    public function projectProgress($kode)
    {
        $cl_comp = Auth::user()->cl_comp;
        $info = DB::select("select p_code, p_name, pt_detail, pf_id, pf_detail, pf_progress, init.ct_id as init_id, init.ct_name as init_name, team.ct_id as team_id, team.ct_name as team_name, pp_init, pp_team, pp_execution, pp_target from d_project left join m_projecttype on p_type = pt_code left join d_projectfitur on pf_projectcode = p_code and pf_comp = '".$cl_comp."' left join d_projectprogress on pf_id = pp_fitur left join d_companyteam init on init.ct_id = pp_init left join d_companyteam team on team.ct_id = pp_team where p_code = '".$kode."'");

        $team = DB::table('d_projectteam')
            ->join('d_companyteam', 'ct_id', '=', 'pt_teamid')
            ->join('m_position', 'pt_position', '=', 'pp_code')
            ->where('pt_comp', '=', $cl_comp)
            ->where('pt_projectcode', '=', $kode)
            ->get();

        return view('manajemen-project/project-progress/project-progress', compact('info', 'team'));
    }

    public function save(Request $request)
    {
        DB::beginTransaction();
        try {
            $target = $request->target;
            $eksekusi = $request->eksekusi;
            $fitur = $request->id;
            $comp = Auth::user()->cl_comp;
            $projek = $request->project;
            $team = $request->team;
            $init = $request->init;

            $cek = DB::table('d_projectprogress')
                ->where('pp_comp', '=', $comp)
                ->where('pp_projectcode', '=', $projek)
                ->where('pp_fitur', '=', $fitur)
                ->get();

            if (count($cek) > 0){
                if ($target == null && $eksekusi != null){
                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $projek)
                        ->where('pp_fitur', '=', $fitur)
                        ->update([
                            'pp_execution' => $eksekusi
                        ]);
                } elseif ($target != null && $eksekusi == null){
                    DB::table('d_projectprogress')
                        ->where('pp_comp', '=', $comp)
                        ->where('pp_projectcode', '=', $projek)
                        ->where('pp_fitur', '=', $fitur)
                        ->update([
                            'pp_target' => $target
                        ]);
                }
            } else {
                $id = DB::table('d_projectprogress')
                    ->where('pp_comp', '=', $comp)
                    ->where('pp_projectcode', '=', $projek)
                    ->where('pp_fitur', '=', $fitur)
                    ->max('pp_id');

                ++$id;

                if ($target == null && $eksekusi != null){
                    DB::table('d_projectprogress')
                        ->insert([
                            'pp_comp' => $comp,
                            'pp_projectcode' => $projek,
                            'pp_id' => $id,
                            'pp_init' => $init,
                            'pp_team' => $team,
                            'pp_date' => Carbon::now('Asia/Jakarta'),
                            'pp_fitur' => $fitur,
                            'pp_execution' => $eksekusi,
                            'pp_note' => '',
                            'pp_state' => 'Entry'
                        ]);
                } elseif ($target != null && $eksekusi == null){
                    DB::table('d_projectprogress')
                        ->insert([
                            'pp_comp' => $comp,
                            'pp_projectcode' => $projek,
                            'pp_id' => $id,
                            'pp_init' => $init,
                            'pp_team' => $team,
                            'pp_date' => Carbon::now('Asia/Jakarta'),
                            'pp_fitur' => $fitur,
                            'pp_target' => $target,
                            'pp_note' => '',
                            'pp_state' => 'Control'
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
}
