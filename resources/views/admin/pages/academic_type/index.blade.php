@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Category'])

    <section class="content">
        <div class="container-fluid">
            <div class="row pb-3 justify-content-between">
                <div class="col-1">
                    <a href="{{route('backend.academic.type.trashed')}}" class="btn btn-block btn-danger">Trashed</a>
                </div>
                <div class="col-1">
                    <button id="createNewAcademicType" class="btn btn-block btn-custom text-white">Add New</button>
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
                            <h3 class="card-title">Category Table</h3>
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Academic Type</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        @include('admin.pages.academic_type.modal_form')
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
                    url: "{{route('backend.academic.type.index')}}",
                },
                columns: [
                    {
                        data: 'Academic_Type',
                        name: 'Academic_Type'
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


            $('#createNewAcademicType').click(function () {
                $('#saveBtn').html("Save");
                $('#modelHeading').html("Academic Type Add Form");
                $('#ajaxModelAcademicType').modal('show');
            });
            $('.closeBtn').click(function () {
                $('#ajaxModelAcademicType').modal('hide');
                $('#AcademicTypeForm').trigger('reset');
            });
            $('body').on('click', '.editAcademic', function () {
                var id = $(this).data('id');
                $.ajax({
                    method: "GET",
                    dataType: "json",
                    url: '/admin/academic-type/edit/' + id,
                    success: function (data) {
                        $('#id').val(id);
                        $('#status').val(data.status);
                        $('#academic_type_name').val(data.academic_type_name);
                        $('#modelHeading').html("Edit Academic Type Form");
                        $('#saveBtn').html("Update");
                        $('#ajaxModelAcademicType').modal('show');
                    }
                })
            });
            $(".saveBtn").on('click', function (e) {
                e.preventDefault();
                let formdata = new FormData(document.getElementById("academicTypeForm"));

                $.ajax({
                    url: '{{ route('backend.academic.type.store') }}',
                    method: 'post',
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        console.log(data);
                        if (data.success === true) {
                            toastr["success"]("Store successfully");
                            $('#academicTypeForm').trigger("reset");
                            $('#ajaxModelAcademicType').modal('hide');
                            table.draw();
                        } else {
                            toastr["error"]("Need Data");
                            $('#academicTypeForm').trigger("reset");
                            table.draw();
                        }
                    },
                    error: function (reject) {
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        })
                        toastr["error"](response.message);
                    }
                });
            });

            $(document).on('click', '.deleteAcademic', function (e) {
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
                            url: '/admin/academic-type/delete/' + id,
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
            $(document).on('click', '.inactiveAcademic', function (e) {
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
                            url: "{{route('backend.academic.type.status.active')}}",
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
            $(document).on('click', '.activeAcademic', function (e) {
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
                            url: "{{route('backend.academic.type.status.inactive')}}",
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
