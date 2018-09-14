<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\Datatables\Datatables;

class DaftarTeamController extends Controller
{
    public function index()
    {
        return view('manajemen-team/daftar-team/index');
    }

    public function data($status)
    {
        if ($status == 'all'){
            $data = DB::table('d_companyteam')
                ->get();
        } else {
            $data = DB::table('d_companyteam')
                ->where('ct_state', '=', $status)
                ->get();
        }
        $data = collect($data);
        return Datatables::of($data)
            ->addColumn('aksi', function ($data){
                return '<div class="text-center">
                        <a href="#" class="on-default edit-row" data-toggle="tooltip" data-placement="top" title="Proje<!---->ct" data-original-title="Project"><i class="fa fa-window-maximize"></i></a>
                        </div>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
}
