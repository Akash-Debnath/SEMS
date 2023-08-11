@extends('index')
@section('title', '| Privilege')

{{-- @author Akash Chandra Debnath
@Behaviour All manager, admin, mamangement and roster privileger settings here --}}

@section('wrapper')
@parent
@section('content-wrapper')
@parent
@section('content-header')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Administrator Privilege Setting</h4>
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
                                </svg>Settings</a></li>
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
    <div class="row">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-header">
                    <h1 class="lead"> Managerial Privilege</h1>
                </div>
                <div class="card-body d-flex justify-content-center overflow-lg-auto overflow-auto">
                    <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Department</th>
                                <th>Manager</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1 @endphp
                            @foreach ($departments as $dept)
                                @php    $dc = $dept->dept_code;       @endphp

                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $dept ? $dept->dept_name : '' }}</td>

                                    <td>

                                        <div class="container-fluid">
                                            @foreach ($privileger as $priv)
                                                @php
                                                    $tp = $priv->type;
                                                    $dpt = $priv->dept_code;
                                                @endphp

                                                @if ($tp == 'M' && $dpt == $dc)
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card ">
                                                                <!-- /.card-header -->
                                                                <div class="card-body">
                                                                    @if(Auth::user()->can('privilege-delete'))
                                                                        <div class="row d-flex justify-content-between">
                                                                            <form
                                                                                action="{{ route('adminpriv.destroy', $priv->id) }}"
                                                                                method="post" class="ml-auto">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <button type="submit"
                                                                                    class="btn btn-tool ml-auto"
                                                                                    data-card-widget=""
                                                                                    onclick="return confirm('Remove privilege of {{ $priv->employee ? $priv->employee->name : '' }}?')">
                                                                                    <i class="fas fa-times"></i>
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @endif
                                                                    <p class="mb-0">{{ $priv->emp_id }}</p>
                                                                    <p class="mb-0"><a
                                                                            href="{{ route('employees.show', $priv->emp_id) }}">{{ $priv->employee ? $priv->employee->name : '' }}</a>
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        <i>{{ $priv->employee ? $priv->employee->userDesignation->designation : '' }}</i>
                                                                    </p>
                                                                    <p class="mb-0">
                                                                        {{ $priv->employee ? ($priv->employee->department ? $priv->employee->department->dept_name : '') : '' }}
                                                                    </p>
                                                                </div>
                                                                <!-- /.card-body -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach

                                            @if(Auth::user()->can('privilege-create'))
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <form action="{{ route('adminpriv.store') }}" class="form-group"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <select class="form-control select2" style="width: 100%;" name="emp_id">
                                                                <option selected hidden>--Select Employee--</option>
                                                                @foreach ($employees as $emp)
                                                                    <option value={{ $emp->emp_id }}>{{ $emp->emp_id }} -
                                                                        {{ $emp->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" name="dept_code" value="{{ $dc }}">
                                                            <input type="hidden" name="type" value="M">
                                                            <button type="submit" class="btn btn-info btn-sm form-control">Add</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="lead"> Admin Privilege</h1>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Admin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="container-fluid">
                                        @foreach ($privileger as $priv)
                                            @php
                                                $tp = $priv->type;
                                                $dpt = $priv->dept_code;
                                            @endphp

                                            @if ($tp == 'A')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card ">
                                                            <!-- /.card-header -->
                                                            <div class="card-body">
                                                                @if(Auth::user()->can('privilege-delete'))
                                                                    <div class="row d-flex justify-content-between">
                                                                        <form action="{{ url('admin-delete', $priv->id) }}"
                                                                            method="post" class="ml-auto">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-tool ml-auto"
                                                                                data-card-widget=""
                                                                                onclick="return confirm('Remove privilege of {{ $priv->employee ? $priv->employee->name : '' }}?')">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                <p class="mb-0">{{ $priv->emp_id }}</p>
                                                                <p class="mb-0"><a
                                                                        href="{{ route('employees.show', $priv->emp_id) }}">{{ $priv->employee ? $priv->employee->name : '' }}</a>
                                                                </p>

                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? $priv->employee->userDesignation->designation : '' }}</i>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? ($priv->employee->department ? $priv->employee->department->dept_name : '') : '' }}</i>
                                                                </p>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if(Auth::user()->can('privilege-create'))
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ url('admin-privileger') }}" class="form-group"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <select name="emp_id" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected" hidden>--Select Employee--</option>
                                                            @foreach ($employees as $emp)
                                                                <option value={{ $emp->emp_id }}>{{ $emp->emp_id }} -
                                                                    {{ $emp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="type" value="A">
                                                        <button type="submit"
                                                            class="btn btn-info btn-sm form-control">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h1 class="lead"> Roster Privilege</h1>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Employee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="container-fluid">
                                        @foreach ($privileger as $priv)
                                            @php
                                                $tp = $priv->type;
                                                $dpt = $priv->dept_code;
                                            @endphp

                                            @if ($tp == 'R')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card ">
                                                            <!-- /.card-header -->
                                                            <div class="card-body">
                                                                @if(Auth::user()->can('privilege-delete'))
                                                                    <div class="row d-flex justify-content-between">
                                                                        <form action="{{ url('roster-delete', $priv->id) }}"
                                                                            method="post" class="ml-auto">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-tool ml-auto"
                                                                                data-card-widget=""
                                                                                onclick="return confirm('Remove privilege of {{ $priv->employee ? $priv->employee->name : '' }}?')">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                <p class="mb-0">{{ $priv->emp_id }}</p>
                                                                <p class="mb-0">
                                                                    <a href="{{ route('employees.show', $priv->emp_id) }}">{{ $priv->employee ? $priv->employee->name : '' }}</a> 
                                                                </p>
                                                                
                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? $priv->employee->userDesignation->designation : '' }}</i>
                                                                </p>
                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? ($priv->employee->department ? $priv->employee->department->dept_name : '') : '' }}</i>
                                                                </p>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if(Auth::user()->can('privilege-create'))
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ url('roster-privileger') }}" class="form-group"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <select name="emp_id" class="form-control select2" style="width: 100%;">
                                                            <option selected="selected" hidden>--Select Employee--</option>
                                                            @foreach ($employees as $emp)
                                                                <option value={{ $emp->emp_id }}>{{ $emp->emp_id }} -
                                                                    {{ $emp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="type" value="R">
                                                        <button type="submit" class="btn btn-info btn-sm form-control">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h1 class="lead"> Management Privilege</h1>
                </div>
                <div class="card-body d-flex justify-content-center">
                    <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Management</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="container-fluid">
                                        @foreach ($privileger as $priv)
                                            @php
                                                $tp = $priv->type;
                                                $dpt = $priv->dept_code;
                                            @endphp

                                            @if ($tp == 'B')
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card ">
                                                            <!-- /.card-header -->
                                                            <div class="card-body">
                                                                @if(Auth::user()->can('privilege-delete'))
                                                                    <div class="row d-flex justify-content-between">                                                               
                                                                        <form action="{{ url('management-delete', $priv->id) }}"
                                                                            method="post" class="ml-auto">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-tool ml-auto"
                                                                                data-card-widget=""
                                                                                onclick="return confirm('Remove privilege of {{ $priv->employee ? $priv->employee->name : '' }}?')">
                                                                                <i class="fas fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                @endif
                                                                <p class="mb-0">{{ $priv->emp_id }}</p>
                                                                
                                                                <p>
                                                                    <a href="{{ route('employees.show', $priv->emp_id) }}">{{ $priv->employee ? $priv->employee->name : '' }}</a>
                                                                </p>
                                                               
                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? $priv->employee->userDesignation->designation : '' }}</i>
                                                                </p>

                                                                <p class="mb-0">
                                                                    <i>{{ $priv->employee ? ($priv->employee->department ? $priv->employee->department->dept_name : '') : '' }}</i>
                                                                </p>
                                                            </div>
                                                            <!-- /.card-body -->
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach

                                        @if(Auth::user()->can('privilege-create'))
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{ url('management-privileger') }}" class="form-group"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <select name="emp_id" class="form-control select2"
                                                            style="width: 100%;">
                                                            <option selected="selected" hidden>--Select Employee--</option>
                                                            @foreach ($employees as $emp)
                                                                <option value={{ $emp->emp_id }}>{{ $emp->emp_id }} -
                                                                    {{ $emp->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <input type="hidden" name="type" value="B">
                                                        <button type="submit" class="btn btn-info btn-sm form-control">Add</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- end editing-->
@endsection
@endsection
@endsection

@section('script')
@parent
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>
@endsection
@endsection
