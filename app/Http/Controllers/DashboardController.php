<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function adminDashboard(){
        return view('adminDashboard');
    }

    public function moderatorDashboard(){
        return view('moderatorDashboard');
    }

    public function dashboard(){
        return view('userDashboard');
    }
}
