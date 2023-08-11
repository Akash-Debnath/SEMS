@extends('index')
@section('title', '| Setting')
@section('wrapper')
@parent


@section('content-wrapper')
    @parent
@section('content-header')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Leave</a></li>
                        <li class="breadcrumb-item"><a href="#">Leave-list</a></li>
                        <li class="breadcrumb-item active">Leave </li>
                    </ol>
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
        <div class="col-12 mt-5">
            <div class="card ">
                <div class="card-header">

                    <h5 class="text-center text-info mb-0">Default Time</h5>

                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('store') }}" method="POST">
                                @csrf
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Option Name</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th> Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            @foreach ($option as $o)
                                                @if ($o->option_name == 'default_time')
                                                    <td>Default Office Time</td>
                                                    <td>
                                                        <input type="time" name="stime" id="stime"
                                                            value="{{ $o->stime }}" class="form-control js-time-field bg-transparent">
                                                    </td>

                                                    <td>
                                                        <input type="time" name="etime" id="etime"
                                                            value="{{ $o->etime }}" class="form-control js-time-field bg-transparent">
                                                    </td>

                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button class="btn btn-sm btn-info  ">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-save"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                </svg> Save

                                                            </button>
                                                        </div>
                                                    </td>

                                        </tr>
                                        @endif
                                        @endforeach


                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>




        </div>


        {{-- default weekend --}}

        <div class="col-12 mt-5">


            <div class="card ">
                <div class="card-header">
                    <h5 class="text-center mb-0 text-info">Default Weekend</h5>
                    {{-- {{ $opt_value }} --}}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">


                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Option Name</th>
                                        <th>Days</th>
                                        <th>Working Day/Weekend</th>

                                        <th> Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td rowspan="8">Default Weekend</td>
                                    </tr>
                                    @foreach ($option as $o)
                                        @if ($o->option_name == 'default_weekend')
                                            <form action="{{ route('weekend.store', $o->option_id) }}" method="post">
                                                @csrf
                                                <tr>
                                                    <td>{{ $o->option_code }} </td>
                                                    <td>
                                                        <select name="day" id="" class="form-control">
                                                            <option value="Y"
                                                                @if ($o->option_value == 'Y') selected @endif>Weekend
                                                            </option>
                                                            <option value="N"
                                                                @if ($o->option_value == 'N') selected @endif>Working
                                                                Day</option>
                                                        </select>
                                                    </td>



                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button class="btn btn-sm btn-info"
                                                                href={{ 'edit-weekend/' . $o->option_id }}>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-save"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                </svg> Save

                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </form>
                                        @endif
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>




        </div>
        @if(Auth::user()->can('leave-create'))
        {{-- leave type --}}
        <div class="col-12 mt-5">


            <div class="card ">
                <div class="card-header">
                    <div class="col-12">
                        <h5 class="text-center mb-0 text-info">Genuity Leaves</h5>
                    </div>
                    {{-- {{ $opt_value }} --}}
                    <div class="col-12">
                        <button class="btn btn-sm btn-info " data-toggle="modal" data-target="#leave">Add New Leave</button>


                        <div class="modal fade" id="leave">
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title ">Add New Leave</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{route('addLeave.store')}}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="ltype">Full Form of the Leave :</label>
                                                    <input type="text" name="fullForm" id="ltype" class="form-control"
                                                        placeholder="For Example: Annual Leave">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="src">Short Form of the Leave :</label>
                                                    <input type="text" name="shortForm" id="src"
                                                        class="form-control" placeholder="For Example: AL">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12">
                                                    <label for="days">Number of Days:</label>
                                                    <input type="number" name="days" id="days"
                                                        class="form-control">
                                                </div>

                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6 ">

                                                    <input type="checkbox" name="ispresc" id="ispresc" value="Y">
                                                    <label for="ispresc">Add a Prescription</label>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button class="btn btn-info btn-sm ">Add new Leave</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">


                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Option Name</th>
                                        <th>Leave Type</th>
                                        <th>Common for Male/female</th>
                                        <th>Prescription</th>

                                        <th> Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> @php $i=1; @endphp
                                        {{-- &&($o->option_code!='PL')&&($o->option_code!='WL')&&($o->option_code!='ML') --}}
                                        <td @foreach ($option as $o) @if ($o->option_name == 'leave_type' &&
                                            $o->option_code != 'PL' &&
                                            $o->option_code != 'WL' &&
                                            $o->option_code != 'ML') @php $i=$i+1; @endphp @endif
                                            @endforeach rowspan="{{ $i }}">Leave Type</td>
                                    </tr>
                                    {{-- && ($o->option_code!='PL')&&($o->option_code!='WL')&&($o->option_code!='ML') --}}
                                    @foreach ($option as $o)
                                        @if ($o->option_name == 'leave_type' &&
                                            $o->option_code != 'PL' &&
                                            $o->option_code != 'WL' &&
                                            $o->option_code != 'ML')
                                            <form action="{{ route('cmnleave.store', $o->option_id) }}" method="post">
                                                @csrf
                                                <tr>
                                                    <td>{{ $o->option_value }}</td>
                                                    <td>
                                                        <input type="number" name="ldays" id=""
                                                            value="{{ $o->leave_m }}" class="form-control">
                                                    </td>


                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <input type="checkbox" name="presc" id="check"
                                                                value="Y"
                                                                @if ($o->prescription == 'Y') checked @endif>

                                                    </td>
                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button class="btn btn-sm btn-info"
                                                                href={{ 'edit-cmn-leave/' . $o->option_id }}>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-save"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                </svg> Save
                                                            </button>

                                                            {{-- <button type="submit"  class="btn btn-sm btn-danger ml-1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                                  </svg>
                                                            </button> --}}
                                                          
                                                        </div>
                                                        
                                                       
                                                    </td>

                                                </tr>
                                            </form>
                                        @endif

                                    @endforeach






                                </tbody>
                            </table>



                            {{-- genuity_leaves_array --}}

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Option Name</th>
                                        <th>Leave Type</th>

                                        <th>Male</th>
                                        <th>Female</th>
                                        <th> Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> @php $j=1; @endphp
                                        {{-- &&($o->option_code!='PL')&&($o->option_code!='WL')&&($o->option_code!='ML') --}}
                                        <td @foreach ($option as $o) @if ($o->option_name == 'genuity_leaves_array') @php $j=$j+1; @endphp @endif
                                            @endforeach rowspan="{{ $j }}">
                                            Leave Type</td>
                                    </tr>
                                    {{-- && ($o->option_code!='PL')&&($o->option_code!='WL')&&($o->option_code!='ML') --}}
                                    @foreach ($option as $o)
                                        @if ($o->option_name == 'genuity_leaves_array')
                                            <form action="{{ route('fmLeave.store', $o->option_id) }}" method="post">
                                                @csrf
                                                <tr>
                                                    <td>{{ $o->option_value }}</td>
                                                    <td>
                                                        <input type="number" name="ldays_m" id=""
                                                            value="{{ $o->leave_m }}" class="form-control">
                                                    </td>

                                                    <td><input type="number" name="ldays_f" id=""
                                                            value="{{ $o->leave_f }}" class="form-control"></td>


                                                    <td>
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button class="btn btn-sm btn-info"
                                                                href={{ 'edit-leave/' . $o->option_id }}>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" class="bi bi-save"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z" />
                                                                </svg> Save

                                                            </button>
                                                        </div>
                                                    </td>

                                                </tr>
                                            </form>
                                        @endif

                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>


@endsection
<!-- end editing-->
@endsection
@endsection
@endsection
@section('script')
@parent
<script>
    $(function(){
        $('.js-time-field').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
            defaultHour: 12
        });
    });
</script>
@endsection
@endsection
