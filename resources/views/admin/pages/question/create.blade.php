@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Category'])
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10 offset-1">

                    <section class="content">
                        <div class="container-fluid">
                            <div class="row pb-3">
                                <div class="col-3">
                                    <a href="{{route('backend.question.index',$chapter_id)}}" class="btn btn btn-block btn-custom text-white">Chapter List</a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="card card-primary">
                        <div class="card-header"></div>
                        <form action="{{route('backend.question.store')}}" method="post" id="questionAddForm">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <label>Difficulty Level</label>
                                        <select class="form-control" name="difficulty_level" id="difficulty_level">
                                            <option value="10">10%</option>
                                            <option value="20">20%</option>
                                            <option value="30">30%</option>
                                            <option value="40">40%</option>
                                            <option value="50">50%</option>
                                            <option value="60">60%</option>
                                            <option value="70">70%</option>
                                            <option value="80">80%</option>
                                            <option value="90">90%</option>
                                            <option value="100">100%</option>
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
                                        <input type="number" name="marks" id="marks" class="form-control" placeholder="Enter marks">
                                    </div>
                                    <div class="col-3">
                                        <label>Chapter</label>
                                        <select class="form-control" name="chapter_id" id="chapter_id">
                                            @foreach(showAllChapter() as $chapter)
                                                <option  value="{{$chapter->id}}" {{$chapter->id == $chapter_id ? "selected" : ""}}>{{$chapter->chapter_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Write Question</label>
                                        <textarea name="question_text" id="question_text" class="summernote" required></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Option 1</label>
                                        <textarea name="option_one" id="option_one" class="summernote" required></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label>Option 2</label>
                                        <textarea name="option_two" id="option_two" class="summernote" required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label>Option 3</label>
                                        <textarea name="option_three" id="option_three" class="summernote" required></textarea>
                                    </div>
                                    <div class="col-6">
                                        <label>Option 4</label>
                                        <textarea name="option_four" id="option_four" class="summernote" required></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <label>Correct Option</label>
                                        <select class="form-control" name="correct_answer" id="correct_answer">
                                            <option value="option_1">option 1</option>
                                            <option value="option_2">option 2</option>
                                            <option value="option_3">option 3</option>
                                            <option value="option_4">option 4</option>
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
