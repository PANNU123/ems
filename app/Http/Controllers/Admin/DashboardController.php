<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function adminDashboard(){
        if(Auth::check()){
            if(Session::get('authEmail')){
                return redirect()->route('backend.lock');
            }
            return view('admin.pages.dashboard');
        }

    }
}
