<?php

namespace App\Http\Controllers;

use App\d_companylog;
use App\d_companyteam;
use App\d_username;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableCOntract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Validator;
use DB;
use Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login/index');
    }

    public function authenticate(Request $request)
    {
        $rules = array(
            'username' => 'required', // make sure the email is an actual email
            'password' => 'required' // password can only be alphanumeric and has to be greater than 3 characters
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect(url('/'))->with(['gagal' => 'gagal']);
        }

        $user = d_username::where(DB::raw('BINARY un_username'), $request->username)->first();
        if ($user && $user->un_passwd == sha1(md5('لا إله إلاّ الله') . $request->password)) {

            d_username::where('un_companyteam', '=', $user->un_companyteam)
                ->update([
                    'un_lastlogin' => Carbon::now('Asia/Jakarta')
                ]);

            $id = DB::table('d_usernamelog')
                ->max('unl_id');

            ++$id;

            DB::table('d_usernamelog')
                ->insert([
                    'unl_id' => $id,
                    'unl_comp' => $user->un_comp,
                    'unl_username' => $user->un_username,
                    'unl_type' => 'IN',
                    'unl_time' => Carbon::now('Asia/Jakarta')->format('Y-m-d')
                ]);

            $team = d_companyteam::where('ct_id', $user->un_companyteam)->first();

            Auth::guard('team')->login($team);
            Auth::login($user);

            return redirect(url('/home'));
        } else {
            return redirect(url('/login'))->with(['gagal' => 'gagal']);
        }
    }

    public function logout()
    {
        $id = DB::table('d_usernamelog')
            ->max('unl_id');

        ++$id;

        DB::table('d_usernamelog')
            ->insert([
                'unl_id' => $id,
                'unl_comp' => Auth::user()->un_comp,
                'unl_username' => Auth::user()->un_username,
                'unl_type' => 'OUT',
                'unl_time' => Carbon::now('Asia/Jakarta')->format('Y-m-d')
            ]);
        session()->flush();
        Auth::logout();
        return redirect(url('/login'));
    }

}
