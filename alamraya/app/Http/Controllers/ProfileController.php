<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $comp = Auth::user()->un_comp;
        $id = Auth::user()->un_companyteam;
        $data = DB::table('d_companyteam')
            ->where('ct_id', '=', $id)
            ->where('ct_comp', '=', $comp)
            ->first();
        return view('dashboard/profile', compact('data'));
    }
}
