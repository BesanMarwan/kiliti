<?php

namespace App\Http\Controllers\Website\DoctorDashboard;

use App\Http\Controllers\Admin\Controller;
//use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {


        if (request()->get('mode') == 'dark') {
            session(['mode' => 'dark']);
        }
        if (request()->get('mode') == 'light') {
            session(['mode' => 'light']);
        }

        return view('doctors.dashboard');


    }
}
