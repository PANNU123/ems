<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubjectController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()) {
            $data = Subject::with('academy')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm "><i data-id="'.$data->id.'" class="fas fa-edit editSubject"></i></a>';
                    $btn =$btn.'<a href="javascript:void(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash deleteSubject"></i></a>';
                    if($data->status == 'active'){
                        $btn =$btn.'<a href="javascript:void(0)" class="btn btn-warning btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-down inactiveSubject"></i></a>';
                    }else{
                        $btn =$btn.'<a href=" javascript:void(0)" class="btn btn-success btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-up activeSubject"></i></a>';
                    }
                    $btn =$btn.'<a href="'.route('backend.chapter.index',$data->id).'" class="btn btn-custom btn-sm ml-2" style="color: white"><i class="fas fa-book"></a>';
                    return $btn;
                })
                ->editColumn('Academic_Name', function ($data) {
                    return $data->academy->academic_type_name;
                })
                ->editColumn('Subject_Name', function ($data) {
                    return $data->subject_name;
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Academic_Type_Name','Subject','Status'])
                ->make(true);
        }
        return view('admin.pages.subject.index');
    }

    public function store(Request $request){
        $validate = $request->validate([
            'subject_name'=>'required',
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

        $data = Subject::updateOrCreate(['id' => $request->id],
            [
                'academic_id'=>$request->academic_id,
                'subject_name'=> $request->subject_name,
                'subject_slug' => slug($request->subject_name),
                'status' => $status
            ]);
        if($data){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function edit($id){
        $edit=Subject::where('id',$id)->first();
        return response()->json($edit);
    }

    public function delete($id){
        $delete=Subject::where('id',$id)->delete();
        return response()->json($delete);
    }

    public function active(Request $request){
        $status = Subject::where('id',$request->id)->update([
            'status'=> 'inactive' ,
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }
    public function inactive(Request $request){

        $status=Subject::where('id',$request->id)->update([
            'status'=> 'active',
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }

    public function trashed(Request $request){
        if ($request->ajax()) {
            $data = Subject::with('academy')->onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:voide(0)" class="btn btn-dark btn-sm "><i data-id="'.$data->id.'" class="fas fa-trash-restore trashedSubject"></i></a>';
                    $btn =$btn.'<a href="javascript:voide(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash parmanentDelete"></i></a>';
                    return $btn;
                })
                ->editColumn('Academic_Name', function ($data) {
                    return $data->academy->academic_type_name;
                })
                ->editColumn('Subject_Name', function ($data) {
                    return $data->subject_name;
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Academic_Type_Name','Subject','Status'])
                ->make(true);
        }
        return view('admin.pages.subject.trashed');
    }

    public function undoTrashed($id){
        $record = Subject::onlyTrashed()->where('id',$id)->first();
        $record->restore();
        return response()->json(['success' => true]);
    }
    public function restoreAll(){
        Subject::onlyTrashed()->restore();
        return redirect()->route('backend.subject.index');
    }

    public function permanentDelete($id){
        $record = Subject::onlyTrashed()->where('id',$id)->first();
        $record->forceDelete();
        return response()->json(['success' => true]);
    }

    public function permanentDeleteAll(){
        Subject::onlyTrashed()->forceDelete();
        return redirect()->route('backend.subject.index');
    }
}
