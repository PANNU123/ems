<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\McqQuestion;
use App\Models\Admin\Question;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function index(Request $request ,$id){
//        return $data = Question::with('mcqquestion')->where('chapter_id',$id)->latest()->get();
        $chapter_id = $id;
        if ($request->ajax()) {
            $data = Question::with('mcqquestion')->where('chapter_id',$id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = '<a href="'.route('backend.question.edit',$data->id).'" class="btn btn-primary btn-sm "><i data-id="'.$data->id.'" class="fas fa-edit editQuestion"></i></a>';
                    $btn =$btn.'<a href="javascript:void(0)" class="btn btn-danger btn-sm ml-2 "><i data-id="'.$data->id.'" class="fas fa-trash deleteQuestion"></i></a>';
                    if($data->status == 'active'){
                        $btn =$btn.'<a href="javascript:void(0)" class="btn btn-warning btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-down inactiveQuestion"></i></a>';
                    }else{
                        $btn =$btn.'<a href=" javascript:void(0)" class="btn btn-success btn-sm ml-2 "><i data-id="'.$data->id.'" style="color: white" class="fas fa-arrow-up activeQuestion"></i></a>';
                    }
                    return $btn;
                })
                ->editColumn('Question', function ($data) {
                    return strip_tags($data->question_text);
                })
                ->editColumn('Question_Type', function ($data) {
                    if($data->question_type_id == 1){
                        return 'MCQ';
                    }
                })
                ->editColumn('Status', function ($data) {
                    if($data->status == 'active'){
                        return '<span class="badge bg-success">Active</span>';
                    }else{
                        return '<span class="badge bg-warning">InActive</span>';
                    }
                })
                ->rawColumns(['action','Question','Question_Type','Status'])
                ->make(true);
        }
        return view('admin.pages.question.index',compact('chapter_id',));
    }

    public function create($chapter_id){
        return view('admin.pages.question.create',compact('chapter_id'));
    }
    public function store(Request $request){

        try {
            DB::beginTransaction();
            $question = Question::create([
                'chapter_id'=>$request->chapter_id,
                'question_type_id'=>$request->question_type_id,
                'difficulty_level'=>$request->difficulty_level,
                'marks'=>$request->marks,
                'question_text'=>$request->question_text,
                'academic_id'=>$request->academic_id,
                'question_hint'=>$request->question_hint,
                'question_detail'=>$request->question_detail,
                'question_solution'=>$request->question_solution,
            ]);
            if($question){
                $MQ = McqQuestion::create([
                    'question_id'=>$question->id,
                    'option_1'=>$request->option_one,
                    'option_2'=>$request->option_two,
                    'option_3'=>$request->option_three,
                    'option_4'=>$request->option_four,
                    'correct_answer' =>$request->correct_answer,
                ]);
                if($MQ){
                    DB::commit();
                    Toastr::success('', 'Question added Successfully', ["positionClass" => "toast-bottom-right"]);
                    return redirect()->back();
                }
            }else{
                Toastr::error('', 'Something is wrong! Please check again', ["positionClass" => "toast-bottom-right"]);
                return redirect()->back();
            }
        }
        catch (\Exception $e) {
            DB::rollBack();
            Toastr::error('', 'Data Does not stored', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    public function edit($id){
        $data = Question::with('mcqquestion')->where('id',$id)->first();
        return view('admin.pages.question.edit',compact('data'));
    }

    public function delete($id){
        $delete=Question::where('id',$id)->delete();
        return response()->json($delete);
    }

    public function active(Request $request){
        $status = Question::where('id',$request->id)->update([
            'status'=> 'inactive'
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }
    public function inactive(Request $request){
        $status=Question::where('id',$request->id)->update([
            'status'=> 'active'
        ]);
        if($status){
            return response()->json(['success' => true]);
        }
    }
}
