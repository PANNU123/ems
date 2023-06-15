<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index(){
        $role = Role::with('permissions')->latest()->get();
       return view('pages.role.index',compact('role'));
   }
   public function createRole(){
    $groupbyname = User::groupByName();
        $permission = Permission::latest()->get();
        return view('pages.role.create', compact('permission', 'groupbyname'));
   }
   public function storeRole(Request $request){
    $permission = $request->input('permissions');
    if (!empty($permission)) {
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($permission);
    }
     Toastr::success('Role Create', 'Successfully', ["positionClass" => "toast-bottom-right"]);
    return redirect()->route('backend.role.list');
    }
    public function editRole($id){
        $role = Role::where('id', $id)->first();
        $groupbyname = User::groupByName();
        $permission = Permission::latest()->get();
        return view('pages.role.edit',compact('permission', 'groupbyname', 'role'));
    }
    public function updateRole(Request $request,$id){
        $role = Role::findById($id);
        $permission = $request->input('permissions');
        if (!empty($permission)) {
            $syncPermissions = $role->syncPermissions($permission);
            if($syncPermissions){
                $role->update([
                   'name'=>$request->name,
                ]);
                 Toastr::success('Role Update', 'Successfully', ["positionClass" => "toast-bottom-right"]);
                return redirect()->route('backend.role.list');
            }
        }
    }
    public function deleteRole($id){
        $delete = Role::where('id', $id)->delete();
        if ($delete) {
            return redirect()->back();
        }
         Toastr::warning('Something is Wrong', 'Warning', ["positionClass" => "toast-bottom-right"]);
        return redirect()->back();
    }
}
