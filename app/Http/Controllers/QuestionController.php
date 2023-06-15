<?php

namespace App\Http\Controllers;

use App\Models\Admin\Chapter;
use App\Models\Admin\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function index(Request $request ,$id){
        $chapter_id = $id;
        if ($request->ajax()) {
            $data = Chapter::where('chapter_id',$id)->latest()->get();
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
                    return $btn;
                })
                ->editColumn('Question', function ($data) {
                    return $data->question;
                })
                ->editColumn('Type', function ($data) {
                    return $data->question;
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
        return view('pages.question.index',compact('chapter_id','data'));
    }
}
