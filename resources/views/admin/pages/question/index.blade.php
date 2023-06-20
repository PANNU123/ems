@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Category'])

    <section class="content">
        <div class="container-fluid">
            <div class="row pb-3">
                <div class="col-2">
                    <a href="{{route('backend.question.create',$chapter_id)}}" class="btn btn btn-block btn-custom text-white">Add New Question</a>
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
                                    <th>Question Type</th>
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
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(function () {
                // Summernote
                $('.summernote').summernote()
            })
            let table = $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
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
                        data: 'Question_Type',
                        name: 'Question_Type'
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

            $(document).on('click', '.deleteQuestion', function (e) {
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
                            url: '/admin/question/delete/' + id,
                            type: "GET",
                            dataType: "JSON",
                            success: function (data) {
                                table.draw();
                            },
                        });
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    } else if (
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

            $(document).on('click', '.inactiveQuestion', function (e) {
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
                            url: "{{route('backend.question.status.active')}}",
                            type: "GET",
                            dataType: "JSON",
                            data: {
                                id: id,
                            },
                            success: function (data) {

                                if (data.success == true) {
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
            $(document).on('click', '.activeQuestion', function (e) {
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
                            url: "{{route('backend.question.status.inactive')}}",
                            type: "GET",
                            dataType: "JSON",
                            data: {
                                id: id,
                            },
                            success: function (data) {
                                if (data.success == true) {
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
