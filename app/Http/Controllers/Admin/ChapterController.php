<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Admin\Chapter;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ChapterController extends Controller
{

    public function index(Request $request, $id){
        if ($request->ajax()) {
            $data = Chapter::where('subject_id',$id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:void(0)" class="btn btn-primary btn-sm "><i data-id="'.$data->id.'" class="fas fa-edit editChapter"></i></a>';
                    $btn =$btn.'<a href="javascript:void(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash deleteChapter"></i></a>';
                    if($data->status == 'active'){
                        $btn =$btn.'<a href="javascript:void(0)" class="btn btn-warning btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-down inactiveChapter"></i></a>';
                    }else{
                        $btn =$btn.'<a href=" javascript:void(0)" class="btn btn-success btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-up activeChapter"></i></a>';
                    }
                    $btn =$btn.'<a href="'.route('backend.question.index',$data->id).'" class="btn btn-custom btn-sm ml-2 "><i class="far fa-plus-square text-white"></i></a>';
                    return $btn;
                })
                ->editColumn('Chapter', function ($data) {
                    return $data->chapter_name;
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Chapter','Status'])
                ->make(true);
        }
        $subject_id = $id;
        return view('admin.pages.chapter.index',compact('subject_id'));
    }

    public function store(Request $request){
        $validate = $request->validate([
            'chapter_name'=>'required',
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

        $data = Chapter::updateOrCreate(['id' => $request->id],
            [
                'subject_id'=>$request->subject_id,
                'chapter_name'=> $request->chapter_name,
                'chapter_slug' => slug($request->chapter_name),
                'status' => $status
            ]);
        if($data){
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
    public function edit($id){
        $edit=Chapter::where('id',$id)->first();
        return response()->json($edit);
    }

    public function delete($id){
        $delete=Chapter::where('id',$id)->delete();
        return response()->json($delete);
    }

    public function active(Request $request){
        $status = Chapter::where('id',$request->id)->update([
            'status'=> 'inactive'
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }
    public function inactive(Request $request){
        $status=Chapter::where('id',$request->id)->update([
            'status'=> 'active'
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }

    public function trashed(Request $request, $id){
//        return $data = Chapter::where('subject_id',$id)->onlyTrashed()->get();
        if ($request->ajax()) {
            $data = Chapter::where('subject_id',$id)->onlyTrashed()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="javascript:voide(0)" class="btn btn-dark btn-sm "><i data-id="'.$data->id.'" class="fas fa-trash-restore trashedChapter"></i></a>';
                    $btn =$btn.'<a href="javascript:voide(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash parmanentDelete"></i></a>';
                    return $btn;
                })
                ->editColumn('Chapter', function ($data) {
                    return $data->chapter_name;
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Chapter','Status'])
                ->make(true);
        }
        $subject_id = $id;
        return view('admin.pages.chapter.trashed',compact('subject_id'));
    }

    public function undoTrashed($id){
        $record = Chapter::onlyTrashed()->where('id',$id)->first();
        $record->restore();
        return response()->json(['success' => true]);
    }
    public function restoreAll($id){
        Chapter::onlyTrashed()->restore();
        return redirect()->route('backend.chapter.index',$id);
    }

    public function permanentDelete($id){
        $record = Chapter::onlyTrashed()->where('id',$id)->first();
        $record->forceDelete();
        return response()->json(['success' => true]);
    }

    public function permanentDeleteAll($id){
        Chapter::onlyTrashed()->forceDelete();
        return redirect()->route('backend.chapter.index',$id);
    }
}
