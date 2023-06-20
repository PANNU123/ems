@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Category'])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-1">
                    <div class="card card-primary">
                        <div class="card-header"></div>
                        <form action="{{route('backend.question.store')}}" method="post" id="questionAddForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Difficulty Level</label>
                                        <select class="form-control" name="difficulty_level" id="difficulty_level">
                                            @foreach(difficultyLevel() as $item)
                                                <option value="{{$item}}">{{$item}}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label>Question Type</label>
                                        <select class="form-control" name="question_type_id" id="question_type_id">
                                            <option value="{{MCQ}}">MCQ</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label>Marks</label>
                                        <input type="number" name="marks" id="marks" class="form-control" placeholder="Enter marks" value="{{$data->marks}}">
                                    </div>
                                    <div class="col-3">
                                        <label>Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            @foreach(showAllChapter() as $chapter)
                                                <option  value="{{$chapter->id}} {{$chapter->id == $data->chapter_id ? "selected" : ""}}">{{$chapter->chapter_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Write Question</label>
                                        <textarea name="question_text" id="question_text" class="summernote" required>{!! $data->question_text !!}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Option 1</label>
                                        <textarea name="option_one" id="option_one" class="summernote" required>{!! $data->mcqquestion->option_one !!}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label>Option 2</label>
                                        <textarea name="option_two" id="option_two" class="summernote" required>{!! $data->mcqquestion->option_two !!}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Option 3</label>
                                        <textarea name="option_three" id="option_three" class="summernote" required>{!! $data->mcqquestion->option_three !!}</textarea>
                                    </div>
                                    <div class="col-6">
                                        <label>Option 4</label>
                                        <textarea name="option_four" id="option_four" class="summernote" required>{!! $data->mcqquestion->option_four !!}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Correct Option</label>
                                        <select class="form-control" name="correct_answer" id="correct_answer">
                                            <option value="option_1" {{$data->mcqquestion->correct_answer == 'option_1' ? "selected" : ""}}>option 1</option>
                                            <option value="option_2" {{$data->mcqquestion->correct_answer == 'option_2' ? "selected" : ""}}>option 2</option>
                                            <option value="option_3" {{$data->mcqquestion->correct_answer == 'option_3' ? "selected" : ""}}>option 3</option>
                                            <option value="option_4" {{$data->mcqquestion->correct_answer == 'option_4' ? "selected" : ""}}>option 4</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Hint (If any)</label>
                                            <input type="text" name="question_hint" id="question_hint" class="form-control" placeholder="Write question hint">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <label>Question Detail (If any)</label>
                                        <textarea name="question_detail" id="question_detail" class="summernote"></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label>Solution (If any)</label>
                                        <textarea name="question_solution" id="question_solution" class="summernote"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Academic Type</label>
                                        <select class="form-control" name="academic_id" id="academic_id">
                                            @foreach(academyType() as $item)
                                                <option value="{{$item->id}}">{{$item->academic_type_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-custom">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('post_scripts')
    <script>
        $(function () {
            $('.summernote').summernote()
        })
    </script>
    <script>
        $(document).ready(function() {
            $("#questionAddForm").validate({
                ignore: ":hidden:not(.summernote)",
                rules: {
                    marks: {
                        required: true,
                        minlength: 1
                    },
                    question_text: {
                        required: true,
                    },
                    option_one: {
                        required: true,
                    },

                    option_two: {
                        required: true,
                    },

                    option_three: {
                        required: true,
                    },

                    option_four: {
                        required: true,
                    }
                },
                messages: {
                    marks: {
                        required: "Please give this question mark",
                    },
                    question_text: {
                        required: " Question field can not be empty ",
                    },
                    option_one: {
                        required: " Option One field is required ",
                    },
                    option_two: {
                        required: " Option Two field is required ",
                    },
                    option_three: {
                        required: " Option Three field is required ",
                    },
                    option_four: {
                        required: " Option Four field is required ",
                    },
                }
            });
        });
    </script>
@endpush
