<?php

namespace App\Http\Controllers;

use App\d_companylog;
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

        $user = d_companylog::where(DB::raw('BINARY cl_username'), $request->username)->first();
        if ($user && $user->cl_password == sha1(md5('لا إله إلاّ الله') . $request->password)) {

            d_companylog::where('cl_id', '=', $user->cl_id)
                ->update([
                    'cl_lastlogin' => Carbon::now('Asia/Jakarta')
                ]);

            Auth::login($user);

            return redirect(url('/home'));
        } else {
            return redirect(url('/login'))->with(['gagal' => 'gagal']);
        }
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect(url('/login'));
    }

}
