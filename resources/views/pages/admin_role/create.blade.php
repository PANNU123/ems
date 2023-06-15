@extends('master')
@section('content')
@include('includes.breadcrumb',['breadcrumb' => 'Admin Create'])
<div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 offset-2">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Quick Example</h3>
          </div>
          <form method="post" action="{{route('backend.store.admin')}}">
              @csrf
              <div class="card-body">
                  <div class="row">
                      <div class="col-12">
                          <input type="text" name="full_name" class="form-control" placeholder="Full Name">
                      </div>
                  </div>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <label>Multiple</label>
                        <select name="roles[]" class="select2" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                            @foreach($role as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('post_scripts')
<script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script>
<script>

    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    });
  </script>
@endpush
