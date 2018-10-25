<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ticketController extends Controller
{
    public function index()
    {
        $project = DB::table('d_project')
            ->select('p_code', 'p_comp', 'p_name')
            ->where('p_state', '=', 'RUNNING')
            ->orderBy('p_name')
            ->get();
        return view('ticket/index', compact('project'));
    }

    public function getFitur(Request $request)
    {
        $projectcode = $request->project;
        $fitur = DB::table('d_projectfitur')
            ->select('pf_projectcode', 'pf_comp', 'pf_code', 'pf_detail')
            ->where('pf_projectcode', '=', $projectcode)
            ->orderBy('pf_detail')
            ->get();

        $projectcode = null;
        $comp = null;
        $data = [];

        if ($fitur != null){
            $projectcode = $fitur[0]->pf_projectcode;
            $comp = $fitur[0]->pf_comp;
            for ($i = 0; $i < count($fitur); $i++){
                $temp['id'] = $fitur[$i]->pf_code;
                $temp['text'] = $fitur[$i]->pf_detail;
                array_push($data, $temp);
            }
        }
        return response()->json([
            'projectcode' => $projectcode,
            'comp' => $comp,
            'data' => $data
        ]);
    }

    public function save(Request $request)
    {
        dd($request);
    }
}
