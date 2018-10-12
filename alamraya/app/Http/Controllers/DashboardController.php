<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard/index');
    }

    public function profile()
    {
        return view('dashboard/profile');
    }
}
