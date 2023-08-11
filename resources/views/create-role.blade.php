@extends('index')
@section('title', '| Role & Permission')

{{-- @author Akash Chandra Debnath
@Behaviour create new roles and permission --}}

@section('wrapper')
    @parent
@section('content-wrapper')
    @parent
@section('content-header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Roles</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Remark </a></li>
                        <li class="breadcrumb-item"><a href="#">Attachment </a></li>
                        <li class="breadcrumb-item active">Attachment Board </li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg" role="alert">
                            <strong>{{ implode('', $errors->all(':message')) }}</strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($message = Session::get('success'))
                        <div class="w-100 alert alert-success alert-dismissible fade show" id="successMsg" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($message = Session::get('fail'))
                        <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg" role="alert">
                            <strong> {{ $message }} </strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('main-content')
@parent
@section('container-fluid')
@parent

    <!--edit here-->
@section('row')
    <div class="row d-flex justify-content-center ">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="col-12">
                        <h5 class="mb-0 "> Add New Role </h5>
    
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-12 ">
                        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12"><label for="name">Role Name:</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 ">
                                    <h5 class="mb-0 "> Permissions </h5>
                                </div>
                            </div>

                            
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label" for="checkPermissionAll">All</label>
                            </div>
                            <hr/>

                            {{-- <div class="row "> --}}
                                {{-- @foreach ($permissions as $permission)
                                    <div class="col-md-4 mb-4">
                                        <label for="permissions{{$permission->id}}" class="font-weight-normal">
                                            <input type="checkbox" class="mr-1" name="permissions[]" value="{{ $permission->id }}" id="permissions{{$permission->id}}">{{ $permission->name}}
                                        </label>
                                    </div>
                                @endforeach --}}

                                @php $i = 1; @endphp
                                @foreach ($permission_groups as $group)
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" onclick="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                <label class="form-check-label create-role-form-check" for="checkPermission">{{ $group->name }}</label>
                                            </div>
                                        </div>
    
                                        <div class="col-9 role-{{ $i }}-management-checkbox">
                                            @php
                                                $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                                $j = 1;
                                            @endphp
                                            @foreach ($permissions as $permission)
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                    <label class="form-check-label create-role-form-check" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                                @php  $j++; @endphp
                                            @endforeach
                                            <br>
                                        </div>
    
                                    </div>
                                    @php  $i++; @endphp
                                @endforeach
                            {{-- </div> --}}
                            <div class="row">
                                <div class="col-md-2 ml-auto">
                                    <button type="submit" class="btn btn-sm btn-info btn-block">Save Role</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ./row -->

@endsection
@endsection
@endsection
@endsection




<!-- extra js section -->
@section('script')
@parent
<script>
    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);

    /**
     * Check all the permissions
    */
    $("#checkPermissionAll").click(function(){
        if($(this).is(':checked')){
            // check all the checkbox
            $('input[type=checkbox]').prop('checked', true);
        }else{
            // un check all the checkbox
            $('input[type=checkbox]').prop('checked', false);
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
        implementAllChecked();
    }
    function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
        const classCheckbox = $('.'+groupClassName+ ' input');
        const groupIDCheckBox = $("#"+groupID);
        // if there is any occurance where something is not selected then make selected = false
        if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
            groupIDCheckBox.prop('checked', true);
        }else{
            groupIDCheckBox.prop('checked', false);
        }
        implementAllChecked();
    }
    function implementAllChecked() {
        const countPermissions = {{ count($all_permissions) }};
        const countPermissionGroups = {{ count($permission_groups) }};
        //  console.log((countPermissions + countPermissionGroups));
        //  console.log($('input[type="checkbox"]:checked').length);
        if($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)){
            $("#checkPermissionAll").prop('checked', true);
        }else{
            $("#checkPermissionAll").prop('checked', false);
        }
    }
</script>
@endsection
@endsection
