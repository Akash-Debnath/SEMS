@extends('index')
@section('title', '| Office Time')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Show office time of all employees for selected date range --}}

@section('content-wrapper')
@parent
@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Office Time Schedule</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark</a></li>
                    <li class="breadcrumb-item"><a href="#">Job Description</a></li>
                    <li class="breadcrumb-item active">Office Time </li>
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
<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Department</h3>
        </div>
        <!-- ./card-header -->
        <div class="card-body ">
            <div class="row">
                <div class="col-12 overflow-auto">
                    <table class="table table-bordered  table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                @if(Auth::user()->can('schedule-update'))
                                    <th>Attendance</th>
                                @endif
                                @if(Auth::user()->can('roster-update'))
                                    <th>Roster</th>
                                @endif
                                <th>Weekend</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departments as $dept)
                                @php
                                    $dc = $dept->dept_code;
                                @endphp
                                <tr class=" bg-primary">
                                    <td colspan="5 ">
                                        <h5 class="ml-1 mb-0  ">
                                            {{ $dept->dept_name }}
                                        </h5>
                                    </td>
                                </tr>

                                @foreach ($employees as $emp)  
                                    @php
                                        $code = $emp->dept_code;
                                    @endphp
                                    @if ($dc == $code)
                                        <tr data-widget="expandable-table" aria-expanded="true">
                                            <td>{{ $emp->emp_id }}</td>
                                            <td>{{ $emp->name }}</td>
                                            @if(Auth::user()->can('schedule-update'))
                                                <form action="{{ url('schecule-update', $emp->emp_id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    @if($emp->scheduled_attendance == "N")
                                                        <input type="hidden" name="scheduled_attendance" value="Y" hidden>
                                                    @else
                                                        <input type="hidden" name="scheduled_attendance" value="N" hidden>
                                                    @endif
                                                    <td> <button class="btn btn-light btn-sm" type="submit" onclick="return confirm('Change to {{ $emp->scheduled_attendance == 'N' ? 'Scheduled' : 'Non-scheduled' }}')" >{{ $emp->scheduled_attendance == "N" ? "Non-scheduled" : "Scheduled" }}</button> </td>
                                                </form>
                                            @endif
                                            @if(Auth::user()->can('roster-update'))
                                                <form action="{{ url('roster-update', $emp->emp_id) }}" method="post" >
                                                    @csrf
                                                    @method('PUT')
                                                    @if($emp->roster == "N")
                                                        <input type="hidden" name="roster" value="Y" hidden>
                                                    @else
                                                        <input type="hidden" name="roster" value="N" hidden>
                                                    @endif
                                                    <td> <button class="btn btn-light btn-sm" type="submit" onclick="return confirm('Change to {{ $emp->roster == 'N' ? 'Roster' : 'Non-roster' }}')" >{{ $emp->roster == "N" ? "Non-roster" : "Roster" }}</button> </td>
                                                </form>
                                            @endif
                                            <td>
                                                @php
                                                    $id = $emp->emp_id;
                                                    $weekends = array("sat"=>"Saturday", "sun"=>"Sunday", "mon"=>"Monday", "tue"=>"Tuesday", "wed"=>"Wednesday", "thu"=>"Thursday", "fri"=>"Friday");
                                                @endphp
                                                @foreach ($weekleaves as $wl)
                                                    @foreach ($weekends as $key=>$value)
                                                        @if($id == $wl->emp_id && $wl->$key == "Y")
                                                            {{ substr($value, 0, 3) }}
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                                @if(Auth::user()->can('weekly-leave-edit'))
                                                    <button type="button" class="btn ml-auto btn-sm" data-toggle="modal" data-target="#modal-default">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" fill="#fc8403" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                        </svg>
                                                    </button>
                                                @endif 
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- modal -->
            @if(Auth::user()->can('weekly-leave-edit'))
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog  modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title ">Checked respective weekend</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="">
                                    <div class="col-12">
                                        <h4 class=" text-center">Select weekend</h4>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="row">
                                                    @if(!is_null($weekends))
                                                        @foreach ($weekends as $key=>$value)
                                                            <div class="col-12">
                                                                {{-- <label><input type="checkbox" {{ $wl->$key == 'Y' ? 'checked' : '' }} name="" id="">{{ $value }}</label>       --}}
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>                                                        
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between ">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>   <!-- /.modal-content -->
                    </div>  <!-- /.modal-dialog -->
                </div>   <!--////modal--finish  -->
            @endif
        </div>  <!-- /.card-body -->
    </div>  <!-- /.card -->
</div>
@endsection
<!-- end editing-->
@endsection
@endsection
@endsection
@section('script')
@parent
<script>
    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>
@endsection
@endsection