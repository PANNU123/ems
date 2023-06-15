<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Brian2694\Toastr\Facades\Toastr;

class AdminRoleController extends Controller
{
    public function adminList(){
        $data = User::orderBy('id','DESC')->get();
        return view('pages.admin_role.index',compact('data'));
    }
    public function createAdmin(){
        $role = Role::all();
        return view('pages.admin_role.create',compact('role'));
    }
    public function storeAdmin(Request $request){
        $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'confirm_password' => 'required|min:5|max:12',
            'password' => 'required|min:5|max:12|same:confirm_password'
        ]);

        $admin = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if ($admin) {
            if ($request->roles) {
                $admin->assignRole($request->roles);
            }
             Toastr::success('User Create With Role', 'Successfully', ["positionClass" => "toast-bottom-right"]);
            return redirect()->route('backend.user.list');
        }
         Toastr::error('Something is wrong', 'warning', ["positionClass" => "toast-bottom-right"]);
        return redirect()->back();
    }

    public function editAdmin($id){
        $role = Role::all();
        $edit = User::where('id', $id)->first();
        return view('pages.admin_role.edit', compact('role', 'edit'));
    }
    public function updateAdmin(Request $request){
        $this->validate($request, [
            'full_name' => 'required',
            'password' => 'required|min:5|max:12|same:confirm_password',
            'roles' => 'required'
        ]);

        $id = $request->id;
        $admin = User::find($id);
        User::where('id',$id)->update([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roles = $request['roles'];
        if (isset($roles)) {
            $admin->roles()->sync($roles);  //If one or more role is selected associate user to roles
        } else {
            $admin->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
         Toastr::success('User Update  With Role', 'Successfully', ["positionClass" => "toast-bottom-right"]);
        return redirect()->back();
    }
    public function deleteAdmin($id){
        $delete = User::where('id', $id)->delete();
        if ($delete) {
             Toastr::success('User Delete', 'Successfully', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
         Toastr::error('User does not delete', 'Successfully', ["positionClass" => "toast-bottom-right"]);
        return redirect()->back();
    }
}
