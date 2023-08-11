@extends('index')
@section('title', '| Permssions')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Permission priviligation for employees --}}

@section('content-wrapper')
@parent
@section('content-header')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Permission Privilege Setting</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-gear" viewBox="0 0 16 16">
                                    <path
                                        d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                    <path
                                        d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                                </svg>Settings</a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Privilege</a></li>
                        <li class="breadcrumb-item active">Administrator Privilege Setting </li>
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

    @php
    $permissionGroups = ['1' => 'Purchase', '2' => 'Requisition', '3' => 'Leave', '4' => 'Attendance', '5' => 'Roster'];
    $id = '';
    @endphp

    @if(Auth::user()->can('permissionPrivilege-create'))
        <div class="row">
            <div class="col-12">
                <div class="card d-flex justify-content-center">
                    <form action="{{ route('permission-priv.store') }}" method="POST" enctype="multipart/form-data"
                        class="form-group p-4">
                        @csrf

                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="form-group">
                                    <label for="prev-typ ">Privilege Group</label>
                                    <select class="form-control" style="width: 100%;" onchange="getval(this);">
                                        <option selected="selected" hidden>--Select--</option>
                                        @foreach ($permissionGroups as $key => $value)
                                            <option value="{{ $key }}" onclick="getData({{ $key }})">
                                                {{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mt-md-0 mt-1">
                                <div class="form-group">
                                    <label for="prev-typ ">Privilege Type</label>
                                    <select class="form-control select2" id="privilege_type" name="activity_id"
                                        style="width: 100%;">
                                        <option selected="selected" hidden>--Select--</option>
                                        @foreach ($activity as $act)
                                            <option value="{{ $act->id }}">{{ $act->activity_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 mt-md-0 mt-1">
                                <div class="form-group">
                                    <label>Privileger</label>
                                    <select class="form-control select2" name="privileger_id" style="width: 100%;">
                                        <option selected="selected" hidden>Select</option>

                                        @foreach ($departments as $dpt)
                                            @php
                                                $d = $dpt->dept_code;
                                            @endphp
                                            <option class="bg-primary" disabled>{{ $dpt->dept_name }}</option>
                                            @foreach ($employees as $emp)
                                                @if ($d == $emp->dept_code)
                                                    <option value="{{ $emp->emp_id }}">{{ $emp->emp_id }} -
                                                        {{ $emp->name }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> <!-- /.card-header -->

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Select Employee</label>
                                    <select class="duallistbox" multiple="multiple" name="staff_id[]" style="height:400px;">

                                        @foreach ($departments as $dpt)
                                            @php
                                                $d = $dpt->dept_code;
                                            @endphp
                                            <option class="bg-primary" disabled>{{ $dpt->dept_name }}</option>
                                            @foreach ($employees as $emp)
                                                @if ($d == $emp->dept_code)
                                                    <option value="{{ $emp->emp_id }}">{{ $emp->emp_id }} - {{ $emp->name }}</option>
                                                @endif
                                            @endforeach
                                        @endforeach

                                    </select>
                                </div>
                                <!-- /.form-group -->
                            </div>
                            <!-- /.col -->
                        </div> <!-- /.row -->
                        <div class="row">
                            <div class="col-md mx-auto">
                                <button type="submit" class="btn btn-sm btn-info">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

@endsection
<!-- end editing-->
@endsection
@endsection
@endsection



@section('script')
@parent
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox();
    })


    function getval(sel) {
        var pg = sel.value;
        var activities = `<?php echo $activity; ?>`;
        activities = JSON.parse(activities);
        var selectedActivities = activities.filter((activity) => {
            if (activity.group_id == pg) {
                return activity;
            }
        });

        var dropDownOptions = "`";
        for (var i = 0; i < selectedActivities.length; i++) {
            dropDownOptions = dropDownOptions + "<option value=" + selectedActivities[i].id + ">" + selectedActivities[
                i].activity_name + "</option>";
        }
        dropDownOptions = dropDownOptions + '`';
        $('#privilege_type').html('');
        $('#privilege_type').append(dropDownOptions);
    }

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>
@endsection

@endsection
