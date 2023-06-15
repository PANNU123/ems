<?php

namespace App\Http\Controllers;

use App\Models\Admin\AcademicType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Brian2694\Toastr\Facades\Toastr;
class AcademicTypeController extends Controller
{
    public function index(Request $request){
        if ($request->ajax()) {
            $data = AcademicType::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:voide(0)" class="btn btn-primary btn-sm "><i data-id="'.$data->id.'" class="fas fa-edit editAcademic"></i></a>';
                    $btn =$btn.'<a href="javascript:voide(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash deleteAcademic"></i></a>';
                    if($data->status == 'active'){
                        $btn =$btn.'<a href="javascript:voide(0)" class="btn btn-warning btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-down inactiveAcademic"></i></a>';
                    }else{
                        $btn =$btn.'<a href=" javascript:voide(0)" class="btn btn-success btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-up activeAcademic"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('Academic_Type', function ($data) {
                    return $data->academic_type_name;
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Academic_Type','Status'])
                ->make(true);
        }
        return view('pages.academic_type.index');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'academic_type_name'=>'required',
        ]);
        if(!$validate){
            return response()->json([$validate]);
        }
        if($request->status == 'active'){
            $status = 'active';
        }
        if($request->status == 'inactive'){
            $status = 'inactive';
        }

        $data = AcademicType::updateOrCreate(['id' => $request->id],
            [
                'academic_type_name'=> $request->academic_type_name,
                'academic_type_slug' => slug($request->academic_type_name),
                'status' => $status
            ]);
        if($data){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function edit($id){
        $edit=AcademicType::where('id',$id)->first();
        return response()->json($edit);
    }

    public function delete($id){
        $delete=AcademicType::where('id',$id)->delete();
        return response()->json($delete);
    }

    public function active(Request $request){
        $status = AcademicType::where('id',$request->id)->update([
            'status'=> 'inactive' ,
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }

    public function inactive(Request $request){
        $status=AcademicType::where('id',$request->id)->update([
            'status'=> 'active',
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }
}
