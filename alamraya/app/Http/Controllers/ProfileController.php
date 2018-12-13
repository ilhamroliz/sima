<?php

namespace App\Http\Controllers;

use App\d_username;
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
        return view('profile/index', compact('data'));
    }

    public function updatePassword(Request $request)
    {
        $passlama = $request->passwordlama;
        $passbaru = $request->passwordbaru;
        $passbaru2 = $request->passwordbaru2;

        $info = d_username::where('un_username', '=', Auth::user()->un_username)
            ->where('un_comp', '=', Auth::user()->un_comp)
            ->where('un_companyteam', '=', Auth::user()->un_companyteam)
            ->first();

        if ($info == null){
            return response()->json([
                'status' => 'gagal',
                'data' => 'user'
            ]);
        }

        if ($passbaru != $passbaru2){
            return response()->json([
                'status' => 'gagal',
                'data' => 'pass'
            ]);
        }

        if ($info->un_passwd == sha1(md5('لا إله إلاّ الله') . $passlama)){
            $passbaru2 = sha1(md5('لا إله إلاّ الله') . $passbaru2);
            d_username::where('un_username', '=', Auth::user()->un_username)
                ->where('un_comp', '=', Auth::user()->un_comp)
                ->where('un_companyteam', '=', Auth::user()->un_companyteam)
                ->update([
                    'un_passwd' => $passbaru2
                ]);

            return response()->json([
                'status' => 'sukses'
            ]);
        } else {
            return response()->json([
                'status' => 'gagal',
                'data' => 'match'
            ]);
        }
    }
}
