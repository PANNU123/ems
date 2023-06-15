@extends('master')
@section('content')
@include('includes.breadcrumb',['breadcrumb' => 'Create Role'])
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Quick Example</h3>
            </div>
            <form method="post" action="{{route('backend.update.role',$role->id)}}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <input type="text" value="{{$role->name}}" name="name" class="form-control" placeholder="Role Name">
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkpermissionall">
                                <label class="form-check-label">Check All</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="row">
                        @php $i = 1; @endphp
                        @foreach ($groupbyname as $group)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <label><input  class="form-check-input" type="checkbox" for="checkpermission" id="{{ $i }}Management"  onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)" value="{{ $group->group_name}}" {{ App\Models\User::roleHasPermissions($role, $permission) ? 'checked' : '' }}><span>{{$group->group_name}}</span></label>
                                    </div>
                                </div>
                                <div class="col-md-9 ms-auto role-{{ $i }}-management-checkbox">
                                    @php
                                        $permissions=App\Models\User::getpermissionsByGroupName($group->group_name);
                                        $j = 1;
                                    @endphp
                                    <div class="mt-4 mt-lg-0">
                                        @foreach ($permissions as $item )
                                            <div class="form-check">
                                                <label><input class="form-check-input" type="checkbox" for="checkpermission{{$item->id}}" id="checkpermission{{$item->id}}" name="permissions[]" value="{{$item->name}}" {{ $role->hasPermissionTo($item->name) ? 'checked' : '' }}><span>{{$item->name}}</span></label>
                                            </div>
                                            @php  $j++; @endphp
                                        @endforeach
                                    </div>
                                    <hr>
                                </div>
                            </div>
                            @php  $i++; @endphp
                        @endforeach
                    </div>
                </div>


              <div class="card-footer">
                <button type="submit" class="btn btn-danger">Submit</button>
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
        $('#checkpermissionall').click(function(){
            if($(this).is(':checked')){
                $('input[type=checkbox]').prop('checked',true);
            }else{
                $('input[type=checkbox]').prop('checked',false);
            }
        });
        function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');
            if(groupIdName.is(':checked')){
                classCheckBox.prop('checked', true);
            }else{
                classCheckBox.prop('checked', false);
            }
        }
    </script>
@endpush
