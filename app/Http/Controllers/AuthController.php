<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;

class AuthController extends Controller
{
    public function login(){
        if(Session::get('userLogin')){
            return redirect()->route('backend.dashboard');
        }
        if(Auth::user()){
            if(Session::get('authEmail')){
                return redirect()->route('admin.lock');
            }
            return redirect()->route('admin.dashboard');
        }
        return view('pages.auth.login');
    }
    public  function loginDashboard(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            Session::put('userLogin', 'user_log_in');
            Toastr::success('', 'Login Successfully', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('backend.dashboard');
        }
        else{
            Toastr::error('', 'Invalid Credential', ["positionClass" => "toast-top-right"]);
            return redirect()->back();
        }
    }
    public function logout(){
        if (Auth::check()) {
            Session::forget('userLogin');
            Auth::logout();
            Toastr::success('', 'Logout Successfully', ["positionClass" => "toast-top-right"]);
            return redirect()->route('login');
        }
        return redirect()->back();
    }
    public function lock(){
        if (Auth::check()) {
            $authEmail=Auth::user()->email;
            Session::put('authEmail', $authEmail);
            return view('pages.auth.lock');
        }
        return redirect()->back();
    }

    public function unlock(Request $request){
        $sessionEmail = Session::get('authEmail');
        $authEmail=Auth::user()->email;
        $authPassword=Auth::user()->password;
        if($sessionEmail == $authEmail){
            if(!Hash::check($request->password,$authPassword)){
                Toastr::error('', 'Password Wrong', ["positionClass" => "toast-top-right"]);
                return redirect()->back();
            }
            Session::forget('authEmail');
            Toastr::success('', 'Login Successfully', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('backend.dashboard');
        }
    }
}
