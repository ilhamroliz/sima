<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use File;
use Yajra\DataTables\DataTables;

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
        DB::beginTransaction();
        try {
            $projectcode = $request->projectcode;
            $fitur = $request->fitur;
            $error = $request->error;
            $prioritas = $request->prioritas;
            $area = $request->area;

            $idTicket = DB::table('d_projectticket')
                ->max('pt_id');
            ++$idTicket;

            $imgPath = null;
            $tgl = Carbon::now('Asia/Jakarta');
            $folder = $tgl->timestamp . $tgl->year . $tgl->month;
            $dir = 'images/uploads/ticket/' . $idTicket;
            $this->deleteDir($dir);
            $childPath = $dir . '/';
            $path = $childPath;
            $file = $request->file('image-upload');
            $name = null;
            if ($file != null){
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imgPath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            $tiket = $tgl->timestamp;

            DB::table('d_projectticket')
                ->insert([
                    'pt_id' => $idTicket,
                    'pt_comp' => 'ASB0000001',
                    'pt_projectcode' => $projectcode,
                    'pt_number' => $tiket,
                    'pt_asktime' => $tgl,
                    'pt_client' => 1,
                    'pt_clientteam' => 1,
                    'pt_status' => 'ENTRY',
                    'pt_error' => $error,
                    'pt_fitur' => $fitur,
                    'pt_urgency' => $prioritas,
                    'pt_ask' => $area,
                    'pt_attachment' => $imgPath
                ]);

            DB::commit();
            return view('sukses/success_ticket', compact('tiket'));

        } catch (\Exception $e){
            DB::rollback();
            return view('error/error_ticket');
        }
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function ticketAnda()
    {
        return view('ticket/ticket-anda');
    }

    public function dataTicketAnda()
    {
        $data = DB::table('d_projectticket')
            ->leftJoin('d_projectticket_dt', 'ptdt_id', '=', 'pt_id')
            ->join('d_project', function ($q){
                $q->on('p_code', '=', 'pt_projectcode');
                $q->on('p_comp', '=', 'pt_comp');
            })
            ->join('d_projectfitur', function ($a){
                $a->on('pf_comp', '=', 'pt_comp');
                $a->on('pf_projectcode', '=', 'pt_projectcode');
                $a->on('pf_code', '=', 'pt_fitur');
                $a->on('pf_comp', '=', 'p_comp');
                $a->on('pf_projectcode', '=', 'p_code');
            })
            ->select('pt_number', 'p_name', 'pf_detail', DB::raw('date_format(pt_asktime, "%d/%m/%Y") as pt_asktime'), 'pf_detail', 'pt_status')
            ->get();

        $data = collect($data);
        return DataTables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center"></div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
