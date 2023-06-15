@extends('master')
@section('content')
    @include('includes.breadcrumb',['breadcrumb' => 'Category'])

    <section class="content">
        <div class="container-fluid">
            <div class="row pb-3 justify-content-between">
                <div class="col-2">
                    <a type="button">-</a>
                </div>
                <div class="col-1">
                    <button id="createChapter" class="btn btn btn-block btn-custom">Add New</button>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Type</th>
                                    <th>Question Cat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('post_scripts')
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{route('backend.question.index',$chapter_id)}}",
                },
                columns: [
                    {
                        data: 'Question',
                        name: 'Question'
                    },
                    {
                        data: 'Type',
                        name: 'Type'
                    },
                    {
                        data: 'Question_Cat',
                        name: 'Question_Cat'
                    },
                    {
                        data: 'Status',
                        name: 'Status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            $('#createChapter').click(function () {
                $('#saveBtn').html("Save");
                $('#modelHeading').html("Chapter Add Form");
                $('#ajaxModelChapter').modal('show');
            });
            $('.closeBtn').click(function () {
                $('#ajaxModelChapter').modal('hide');
                $('#chapterForm').trigger('reset');
            });
            $('body').on('click', '.editChapter', function () {
                var id = $(this).data('id');
                $.ajax({
                    method:"GET",
                    dataType:"json",
                    url:'/admin/chapter/edit/'+id,
                    success:function(data){
                        $('#id').val(id);
                        $('#subject_id').val(data.subject_id);
                        $('#chapter_name').val(data.chapter_name);
                        $('#status').val(data.status);
                        $('#modelHeading').html("Edit Subject Form");
                        $('#saveBtn').html("Update");
                        $('#ajaxModelChapter').modal('show');
                    }
                })
            });
            $(".saveBtn").on('click',function (e){
                e.preventDefault();
                let formdata = new FormData(document.getElementById("chapterForm"));

                $.ajax({
                    url: '{{ route('backend.chapter.store') }}',
                    method: 'post',
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success:function (data){
                        console.log(data);
                        if(data.success === true){
                            toastr["success"]("Store successfully");
                            $('#chapterForm').trigger("reset");
                            $('#ajaxModelChapter').modal('hide');
                            table.draw();
                        }
                        else{
                            toastr["error"]("Need Data");
                            $('#chapterForm').trigger("reset");
                            table.draw();
                        }
                    },
                    error:function(reject){
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function(key, val) {
                            $("#" + key + "_error").text(val[0]);
                        })
                        toastr["error"](response.message);
                    }
                });
            });

            $(document).on('click', '.deleteChapter', function (e) {
                e.preventDefault();
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:'/admin/chapter/delete/'+id,
                            type: "GET",
                            dataType:"JSON",
                            success: function (data) {
                                table.draw();
                            },
                        });
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        Swal.fire(
                            'Cancelled',
                            'Your file is safe :)',
                            'error'
                        )
                    }
                })
            });

            $(document).on('click', '.inactiveChapter', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want be able to inactive!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, inactive it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('backend.chapter.status.active')}}",
                            type: "GET",
                            dataType:"JSON",
                            data:{
                                id:id,
                            },
                            success: function (data) {

                                if(data.success == true){
                                    toastr["info"](" Inactive Successfully");

                                    table.draw();
                                }
                            },
                        });
                        swalWithBootstrapButtons.fire(
                            'Inactive!',
                            'Your file has been Inactive.',
                            'success'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {

                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Its not been Inactive.)',
                            'error'
                        )
                    }
                })

            });
            // Category status Inactive
            $(document).on('click', '.activeChapter', function (e) {
                e.preventDefault();
                let id = $(this).data('id');
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want be able to active!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, active it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{route('backend.chapter.status.inactive')}}",
                            type: "GET",
                            dataType:"JSON",
                            data:{
                                id:id,
                            },
                            success: function (data) {
                                if(data.success == true){
                                    toastr["info"](" Inactive Successfully");
                                    table.draw();
                                }
                            },
                        });
                        swalWithBootstrapButtons.fire(
                            'Inactive!',
                            'Your file has been active.',
                            'success'
                        )
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Its not been active.)',
                            'error'
                        )
                    }
                })
            });
        });
    </script>
@endpush
