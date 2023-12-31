@extends('admin.master')
@section('content')
    @include('admin.includes.breadcrumb',['breadcrumb' => 'Role'])
    <section class="content">
        <div class="container-fluid">
            <div class="row pb-3 justify-content-between">
                <div class="col-2">
                    <a type="button">-</a>
                </div>
                <div class="col-2">
                    <a href="{{route('backend.create.role')}}" class="btn btn-block btn-danger">Add New</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Responsive Hover Table</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right"
                                           placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($role as $item)
                                    <tr>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @foreach ($item->permissions as $key=>$perm)
                                                <span class="badge bg-success">{{$perm->name}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="margin">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success">Action</button>
                                                    <button type="button"
                                                            class="btn btn-success dropdown-toggle dropdown-icon"
                                                            data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item"
                                                           href="{{route('backend.edit.role',$item->id)}}">Edit</a>
                                                        <a class="dropdown-item"
                                                           href="{{route('backend.delete.role',$item->id)}}">Delete</a>
                                                    </div>
                                                </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@endsection
