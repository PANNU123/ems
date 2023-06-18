@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Category'])
    <section class="content">
        <div class="container-fluid">
            <div class="row pb-3 justify-content-between">

                <div class="col-2">
                    <a href="{{route('backend.subject.permanent.delete.all')}}" class="btn btn-block btn-danger text-white">Delete All</a>
                </div>
                <div class="col-2">
                    <a href="{{route('backend.subject.restore.all')}}" class="btn btn-block btn-custom text-white">Restore All</a>
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
                            <h3 class="card-title">Subject Table</h3>
                            <table id="dataTable" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Subject Name</th>
                                    <th>Academy Type</th>
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
        @include('admin.pages.subject.modal_form')
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
                    url: "{{route('backend.subject.trashed')}}",
                },
                columns: [
                    {
                        data: 'Subject_Name',
                        name: 'Subject_Name'
                    },
                    {
                        data: 'Academic_Name',
                        name: 'Academic_Name'
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
            $(document).on('click', '.trashedSubject', function (e) {
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
                            url: '/admin/subject/undo-trashed/' + id,
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
            $(document).on('click', '.parmanentDelete', function (e) {
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
                            url: '/admin/subject/permanent-delete/' + id,
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

        });
    </script>
@endpush
