@extends('index')
@section('title', '| Leave')
@section('wrapper')
    @parent

    @section('content-wrapper')
        @parent
        @section('content-header')

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Leave List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Leave</a></li>
                                <li class="breadcrumb-item"><a href="#">Leave-list</a></li>
                                <li class="breadcrumb-item active">Leave</li>
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
                    @php
                        $current_year = date('Y');
                        $start_year = 2008;
                    @endphp
                    <div class="container-fluid">
                    @if ($message = Session::get('success'))
                        <div class="w-100 alert alert-success alert-dismissible fade show" id="successMsg" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($message = Session::get('fail'))
                        <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                        <div class="row">
                            <!-- leave request by year table -->
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header ">
                                        <form action="{{ route('emp.leave') }}" class="" method="post">
                                            @csrf

                                            <div class="row ">
                                                <div class="col-md-3 ">

                                                    <select id="year" class="form-control" name="year">
                                                        @foreach (range($current_year, $start_year) as $leave_year)
                                                            <option value="{{ $leave_year }}" {{ $leave_year==$year ? 'selected' : '' }}> {{ $leave_year }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @if(Auth::user()->can('leave-satff-search'))
                                                    <div class="col-md-4 mt-md-0 mt-2">

                                                        {{-- <form action="{{route('emp.list')}}" method="get">
                                                        @csrf --}}
                                                        <select id="dept" class="form-control select2" name="dept" style="width: 100%;">
                                                            {{-- onchange="this.form.submit()" --}}
                                                            <option value="" selected hidden> --Department--</option>
                                                            @foreach ($dept as $d)
                                                                <option data-state="{{ $d->dept_code }}" value="{{ $d->dept_code }}" {{ $d->dept_code == $department ? 'selected' : '' }} >  {{ $d->dept_name }} </option>
                                                            @endforeach

                                                        </select>

                                                        {{-- </form> --}}


                                                    </div>

                                                    <div class="col-md-3 mt-md-0 mt-2">

                                                        <select name="emp" class="form-control select2" style="width: 100%;"
                                                                id="staff"
                                                                data-placeholder="--Staff--">
                                                        
                                                            @foreach ($dept as $d)
                                                                @foreach ($d->employee as $e)
                                                                    @if($e->archive=='N')
                                                                        <option data-state="{{ $e->dept_code }}" value="{{ $e->emp_id }}" {{ $e->emp_id==$staff ? 'selected' : ''}}>  {{ $e->emp_id }}&nbsp; - &nbsp; {{ $e->name }}</option>
                                                                    @endif        
                                                                @endforeach
                                                            @endforeach

                                                            {{-- @foreach ($employee as $e)
                                                             <option value="{{$e->emp_id}}">{{$e->emp_id}}&nbsp; - &nbsp; {{$e->name}}</option>
                                                            @endforeach --}}

                                                        </select>

                                                    </div>
                                            @endif    

                                                <div class="col-md-2 mt-md-0 mt-2">

                                                    <button class="btn btn-info form-control"><span
                                                            class="fas fa-search"></span>
                                                        Search
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                    <div class="card-body">
                                        <table class="table  table-bordered table-responsive-sm selectpicker"
                                               data-live-search="true">
                                            <thead>
                                            <tr>
                                                <th rowspan="2" class="text-center" style="vertical-align: middle;">SL
                                                </th>
                                                <th rowspan="2" class="text-center" style="vertical-align: middle;">
                                                    Leave Type
                                                </th>
                                                <th rowspan="2" class="text-center" style="vertical-align: middle;">
                                                    Day(s)
                                                </th>
                                                <th rowspan="2" class="text-center" style="vertical-align: middle;">
                                                    Leave Date
                                                </th>
                                                <th colspan="2" class="text-center">Approval</th>
                                                @if(Auth::user()->can('leave-cancel')||Auth::user()->can('leave-edit')||Auth::user()->can('leave-view'))
                                                <th rowspan="2" class="text-center" style="vertical-align: middle;">
                                                    Action
                                                </th>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th class="text-center">Manager</th>
                                                <th class="text-center">Admin</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            @foreach ($leave as $l)
                                                @foreach ($option as $o)
                                                    @if ($o->option_code == $l->leave_type)
                                                        <tr>
                                                            <td>1</td>

                                                            <td> {{ $o->option_value }}</td>

                                                            <td class="text-center">{{ $l->period }}</td>
                                                            <td class="text-center"><i>{{ $l->leave_start }}</i> to
                                                                <i>{{ $l->leave_end }}</i>
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($l->m_approved_date == null)
                                                                    <a class="text-danger" href=""> Approval Pending</a>
                                                                @else
                                                                    <a href="" class="text-info"> Approved</a>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if ($l->admin_approve_date == null)
                                                                    <a href="" class="text-danger"> Verification
                                                                        Pending</a>
                                                                @else
                                                                    <a href="" class="text-info"> Verified for
                                                                        record</a>
                                                                @endif
                                                            </td>
                                                            @if(Auth::user()->can('leave-cancel')||Auth::user()->can('leave-edit')||Auth::user()->can('leave-view'))
                                                            <td class="d-flex justify-content-center">
                                                                @if ($l->emp_id != Auth::user()->employeeInfo->emp_id)
                                                                  @if(Auth::user()->can('leave-view'))
                                                                    <a class="btn btn-info btn-sm"
                                                                       href={{ asset('view-leave/' . $l->emp_id . '/' . $l->id . '/' . $l->leave_start) }}>
                                                                        <svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="16"
                                                                            height="16" fill="currentColor"
                                                                            class="bi bi-eye"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                            <path
                                                                                d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                                        </svg>
                                                                    </a>
                                                                    @endif
                                                                @elseif($l->m_approved_date == null && $l->admin_approve_date == null)
                                                                    {{-- edit --}}
                                                                    {{-- <a href={{ asset('edit-leave/' . $l->emp_id . '/' . $l->id . '/' . $l->leave_start) }} --}}
                                                                        @if(Auth::user()->can('leave-edit'))
                                                                    <a href={{ asset('edit-leave-request-form/' . $l->emp_id . '/' . $l->id . '/' . $l->leave_start) }}
                                                            class="btn btn-info btn-sm">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="currentColor"
                                                                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                        <path fill-rule="evenodd"
                                                                              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                                    </svg>
                                                                    </a>
                                                                    @endif
                                                                    {{-- delete --}}
                                                                    {{-- {{ "delete-leave/". $l->id."/".$l->leave_start}}deleteLeave --}}
                                                                    @if(Auth::user()->can('leave-delete'))
                                                                    <a href={{ asset('delete-leave/' . $l->id) }}
                                                            class="btn btn-danger btn-sm ml-1">
                                                                    <svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="currentColor"
                                                                        class="bi bi-archive"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                                    </svg></a>
                                                                    @endif
                                                                @else
                                                                    {{-- cancel --}}
                                                                    @if(Auth::user()->can('leave-cancel'))
                                                                    <a class="btn btn-danger btn-sm"
                                                                       href={{ asset('view-leave/' . $l->emp_id . '/' . $l->id . '/' . $l->leave_start) }}>
                                                                        <svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="16"
                                                                            height="16" fill="currentColor"
                                                                            class="bi bi-x-octagon" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353L4.54.146zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1H5.1z"/>
                                                                            <path
                                                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                                                        </svg>
                                                                    </a>
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            @endif
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--leave request part  -->
                            <div class="col-xl-4  ">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header gap-card-header">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 bg-info">
                                                                <p class="mb-0 py-2">
                                                                    Leave Request
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 ">
                                                                <p class="mb-0 text-justify">
                                                                    I hereby declare that I'm aware and agree to the
                                                                    terms and conditions of
                                                                    related leave policies.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- button -->
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 ">
                                                                <a class="btn btn-info btn-sm"
                                                                   href={{asset('/leave-request-form')}}>Send Leave
                                                                    Request</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body gap-card-header">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 bg-info">
                                                                <p class="mb-0 py-2">
                                                                    Leave Taken
                                                                    in {{ $year }} @php $date = strtotime($year.' -1 year');  @endphp
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Table -->
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 d-flex justify-content-center">
                                                                <table class="table table-bordered">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Leave</th>
                                                                        <th>total</th>
                                                                        <th>taken</th>
                                                                        <th style="width: 40px">Available</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    {{-- temporary off  --}}
                                                                    {{-- @foreach ($option as $o)

                                                                        @if ($o->option_code != 'PL' && $o->option_code != 'ML' && $o->option_code != 'WL')
                                                                            <tr>
                                                                                <td>{{ $o->option_value }}</td>




                                                                                <td>{{ $o->leave_m }}</td>



                                                                                @if ($o->option_code == 'HL')
                                                                                    <td rowspan="2"
                                                                                        style="vertical-align : middle;text-align:center;">
                                                                                        @php $total = array(); @endphp
                                                                                        @foreach ($leave as $l)
                                                                                            @if ($l->leave_type == $o->option_code || $l->leave_type == 'AL')

                                                                                                @php array_push($total,$l->period);@endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        <p class="mb-0"> @php print_r(array_sum($total)); @endphp</p>


                                                                                    </td>
                                                                                    <td rowspan="2"
                                                                                        style="vertical-align : middle;text-align:center;">
                                                                                        @php print_r(abs($o->leave_m)-array_sum($total)); @endphp</td>
                                                                                @elseif($o->option_code == 'AL')
                                                                                @else
                                                                                    <td class="text-center">@php $total = array(); @endphp
                                                                                        @foreach ($leave as $l)
                                                                                            @if ($l->leave_type == $o->option_code)

                                                                                                @php array_push($total,$l->period);@endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        @php print_r(array_sum($total)); @endphp
                                                                                    </td>
                                                                                    <td class="text-center">@php print_r(($o->leave_m)-array_sum($total)); @endphp</td>
                                                                                @endif

                                                                            </tr>
                                                                        @endif
                                                                    @endforeach --}}
                                                                    {{-- temporary off  --}}
                                                                    @php $carryF=array();$days=0; $tc=0; @endphp
                                                                    @foreach($option as $o)
                                                                        @if ($o->option_code != 'PL' && $o->option_code != 'ML' && $o->option_code != 'WL')
                                                                            <tr>
                                                                                <td>{{ $o->option_value }}</td>

                                                                                {{-- @if($o->option_code=='HL') rowspan="2" @endif @if($o->option_code=='AL')style="display:none;" @endif --}}
                                                                                <td class="text-center">  @if($o->option_code=='AL')
                                                                                        @php $days =$o->leave_m; $tc = $days - array_sum($carryF); @endphp
                                                                                    @endif   @if($o->option_code=='CA')
                                                                                        @foreach($carry as $c)
                                                                                            @php array_push($carryF,$c->period); @endphp
                                                                                        @endforeach {{$days - array_sum($carryF)}}
                                                                                    @else
                                                                                        {{$o->leave_m}}
                                                                                    @endif  </td>
                                                                                <td class="text-center">
                                                                                    @php $total = array();  @endphp
                                                                                    @foreach ($leave as $l)
                                                                                        @if ($l->leave_type == $o->option_code)

                                                                                            @php array_push($total,$l->period);@endphp
                                                                                        @endif
                                                                                    @endforeach
                                                                                    @php print_r(array_sum($total)); @endphp
                                                                                </td>
                                                                                {{-- @if($o->option_code=='HL') rowspan="2" @endif @if($o->option_code=='AL')style="display:none;" @endif --}}
                                                                                <td class="text-center"> @if($o->option_code=='AL')
                                                                                        @php $days =$o->leave_m; $tc = $days - array_sum($carryF); @endphp
                                                                                    @endif @if($o->option_code=='CA')
                                                                                        {{($days - array_sum($carryF))-array_sum($total)}}
                                                                                    @else
                                                                                        {{($o->leave_m)-array_sum($total)}}
                                                                                    @endif  </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach

                                                                    @php
                                                                        $gen = 'M';
                                                                        foreach ($dept as $d) {
                                                                            foreach ($d->employee as $e) {
                                                                                foreach ($leave as $l) {
                                                                                    if ($l->emp_id == $e->emp_id) {
                                                                                        $gen = $e->gender;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }

                                                                    @endphp
                                                                    <tr>
                                                                        <td colspan="4" class="bg-info">Leave in Genuity
                                                                            Life
                                                                        </td>
                                                                    </tr>
                                                                    {{-- @foreach ($genuity_leaves as $gl)
                                                                <tr>
                                                                    <td>{{$gl->option_value}}</td>



                                                                </tr>
                                                               @endforeach --}}
                                                                    @foreach ($genuity_leaves as $gl)
                                                                        @if ($gen == 'F')
                                                                            @if ($gl->option_code != 'PL')
                                                                                <tr>

                                                                                    <td>{{ $gl->option_value }}</td>

                                                                                    <td class="text-center">{{ $gl->leave_f }}</td>
                                                                                    <td class="text-center">@php $total = array(); @endphp
                                                                                        @foreach ($leave as $l)
                                                                                            @if ($l->leave_type == $gl->option_code)
                                                                                                {{-- <p class="mb-0">{{$l->period}}</p> --}}


                                                                                                @php
                                                                                                    array_push($total, $l->period);
                                                                                                    break;
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        @php print_r(array_sum($total)); @endphp
                                                                                    </td>

                                                                                    <td class="text-center">@php print_r(abs($gl->leave_f)-array_sum($total)); @endphp </td>
                                                                                </tr>
                                                                            @endif
                                                                        @elseif($gen == 'M')
                                                                            @if ($gl->option_code != 'ML')
                                                                                <tr>

                                                                                    <td>{{ $gl->option_value }}</td>

                                                                                    <td class="text-center">{{ $gl->leave_m }}</td>
                                                                                    <td class="text-center">@php $total = array(); @endphp
                                                                                        @foreach ($leave as $l)
                                                                                            @if ($l->leave_type == $gl->option_code)
                                                                                                {{-- <p class="mb-0">{{$l->period}}</p> --}}


                                                                                                @php
                                                                                                    array_push($total, $l->period);
                                                                                                    break;
                                                                                                @endphp
                                                                                            @endif
                                                                                        @endforeach
                                                                                        @php print_r(array_sum($total)); @endphp
                                                                                    </td>

                                                                                    <td class="text-center">
                                                                                        @php print_r(abs($gl->leave_m)-array_sum($total)); @endphp
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            var $selectDept = $('#dept'),
                $selectStaff = $('#staff'),
                $options = $selectStaff.find('option');

            $selectDept.on('change', function () {
                $selectStaff.html($options.filter('[data-state="' + this.value + '"]'));
            }).trigger('change');




            // fail/success msg

            setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
        </script>

    @endsection

@endsection
