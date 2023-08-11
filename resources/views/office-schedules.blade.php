@extends('index')
@section('title', '| Office Schedule')
@section('wrapper')
    @parent


    @section('content-wrapper')
        @parent
        @section('content-header')

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>Office Schedule</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                                <li class="breadcrumb-item"><a href="#">Office_schedule</a></li>
                                <li class="breadcrumb-item active">Office Schedule</li>
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
                        <!-- leave request by year table -->@php $time=date('Y-m-d'); @endphp
                        <div class="col-xl-12">
                            <div class="card card-primary">
                                <div class="card-header ">
                                    <form action="{{ route('officeSchedule') }}" method="POST">
                                        @csrf
                                        <div class="container-fluid">
                                            <div class="row gap-5">

                                               @if(Auth::user()->can('officeSchedule-department-staff-search'))
                                                <div class="col-md-3 mt-md-0 mt-2 ">
                                                    <label for="dept">Department</label>
                                                    <select id='dept' class="select2 form-control" name="dept_code"
                                                            style="width:100%;" >
                                                        <option data-state="{{ Auth::user()->employeeInfo->department->dept_code }}" value="{{Auth::user()->employeeInfo->department->dept_code}}" selected hidden> --Department--</option>
                                                        @foreach ($employeeDept as $dept)
                                                            <option data-state="{{ $dept->dept_code }}"
                                                                    value="{{ $dept->dept_code }}">
                                                                {{ $dept->dept_name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                                <div class="col-md-3 mt-md-0 mt-2 ml-auto">
                                                    <label for="staff">Staff</label>
                                                    <select id="all_staff" name="emp_id" class="select2 form-control"
                                                            data-placeholder='select staff' style="width:100%;" >                                                           
                                                        <option value="{{ Auth::user()->employeeInfo->emp_id }}"
                                                                selected> {{ Auth::user()->username }} -
                                                            {{ Auth::user()->employeeInfo->name }} </option>
                                                        @foreach ($employeeDept as $d)
                                                            @foreach ($d->employee as $e)
                                                                @if ($e->archive = 'N')
                                                                    <option data-state="{{ $e->dept_code }}"
                                                                            value="{{ $e->emp_id }}">
                                                                        {{ $e->emp_id }} - {{ $e->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                    </select>
                                                </div>
                                               @endif
                                                @php
                                                    $sdate = date('Y-m-01');
                                                    $edate = date('Y-m-d');
                                                @endphp

                                                <div  @if(Auth::user()->can('officeSchedule-department-staff-search ')) class="col-md-2 mt-md-0 mt-2 ml-auto" @else class="col-md-2 mt-md-0 mt-2"  @endif>
                                                    <label for="from">From (mm/dd/yyyy)</label>
                                                    <input type="date" name="sdate" id="from"
                                                           value="{{ date('Y-m-d', $startdate) }}"
                                                           class="form-control js-date-field bg-white">
                                                </div>

                                                <div @if(Auth::user()->can('officeSchedule-department-staff-search ')) class="col-md-2 mt-md-0 mt-2 ml-auto" @else class="col-md-2 mt-md-0 mt-2"  @endif>
                                                    <label for="to">To (mm/dd/yyyy)</label>
                                                    <input type="date" name="edate"
                                                           value="{{ date('Y-m-d', $enddate) }}"
                                                           id="to" class="form-control js-date-field bg-white">
                                                </div>

                                                <div @if(Auth::user()->can('officeSchedule-department-staff-search ')) class="col-md-2 mt-md-0 mt-2 ml-auto" @else class="col-md-2 mt-md-0 mt-2"  @endif>
                                                    <label for="search"></label>
                                                    <button type="submit" class="btn btn-warning form-control"> <span
                                                            class="fas fa-search"></span> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- defining roster/non-roster/non-sloted roster --}}

                                @php
                                    $rmdn = false;
                                    $nonSlot = true;
                                    $foundSlot = false;
                                    $hday = false;
                                @endphp


                                <div class="card-body  overflow-auto">
                                    <table class="table table-bordered table-hover ">
                                        <thead class="text-center">

                                        <tr>
                                            <th>Date</th>
                                            <th>Day</th>
                                            @if ($roster == true)
                                                @foreach ($rosterSlots as $slot)
                                                    <th>{{ date('h:i:s a', strtotime($slot->from)) }}
                                                        &nbsp;<b>to</b>&nbsp;{{ date('h:i:s a', strtotime($slot->to)) }}
                                                    </th>
                                                @endforeach
                                                <th>Weekend</th>
                                            @else
                                                <th>From</th>
                                                <th>To</th>
                                            @endif


                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for ($i = $startdate; $i <= $enddate; $i = $i + 86400)

                                            @php $thisDate = date('Y-m-d',$i); @endphp
                                            {{-- defining if ramadan is true --}}
                                            @foreach ($employee as $e)
                                                @foreach ($e->nonSloted as $n)
                                                    @if ($e->emp_id == $n->emp_id && $thisDate == $n->ddate)
                                                        @php $foundSlot = true; @endphp
                                                    @endif
                                                @endforeach
                                            @endforeach
                                            {{-- // --}}
                                            <tr>
                                                <td class="text-center">
                                                    @if ($roster == true)
                                                        {{ $thisDate }} &nbsp;&nbsp; <b>to</b> &nbsp;&nbsp;
                                                        {{ date('Y-m-d', strtotime($thisDate . '+1 days')) }}
                                                    @else
                                                        {{ $thisDate }}
                                                    @endif

                                                </td>

                                                <td class="text-center">
                                                    @if ($roster == true)
                                                        {{ date('l', $i) }} &nbsp;&nbsp; <b>to</b> &nbsp;&nbsp;
                                                        {{ date('l', strtotime($thisDate . '+1 days')) }}
                                                    @else
                                                        {{ date('l', $i) }}
                                                    @endif
                                                </td>

                                                @if ($roster == true)
                                                    @foreach ($rosterSlots as $slot)
                                                        <td>
                                                            {{-- with only employee tables --}}

                                                            <ol>
                                                                @foreach ($employee as $e)
                                                                    @foreach ($e->rostering as $r)
                                                                        @php
                                                                            $sdate = date('Y-m-d', strtotime($r->stime));
                                                                            $slotTime = date('H:i:s', strtotime($r->stime));
                                                                        @endphp
                                                                        @if ($sdate == $thisDate && $slotTime == $slot->from)
                                                                            @php

                                                                                $nonSlot = false;
                                                                            @endphp
                                                                            <li><b>{{ $e->name }}</b></li>
                                                                        @else
                                                                            @php

                                                                                $nonSlot = true;
                                                                            @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    {{-- {{$nonSlot}} --}}
                                                                @endforeach

                                                            </ol>
                                                            {{-- // --}}
                                                            {{-- {{$nonSlot}} --}}
                                                            @if ($foundSlot == true)
                                                                <p class="mb-0 text-warning text-center">not Set</p>
                                                            @endif

                                                        </td>
                                                    @endforeach


                                                    <td>
                                                        <ol>
                                                            @foreach ($employee as $e)
                                                                @foreach ($e->weekends as $w)
                                                                    @if ($w->date == $thisDate)
                                                                        <li><b>{{ $e->name }}</b></li>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </ol>
                                                    </td>
                                                @elseif($foundSlot == true && $roster == false)
                                                    @foreach ($employee as $e)
                                                        @foreach ($e->nonSloted as $n)
                                                            @if ($e->emp_id == $n->emp_id && $thisDate == $n->ddate)
                                                                @php $foundSlot = true; @endphp
                                                                <td> {{ date('h:i:s a', strtotime($n->start_time)) }} </td>
                                                                <td> {{ date('h:i:s a', strtotime($n->end_time)) }}</td>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @else
                                                    {{-- defining ramadan --}}

                                                    @foreach ($defaultWeekend as $dw)
                                                        @if ($dw->option_code == date('l', $i) && $dw->option_value == 'N')
                                                            @foreach ($holiday as $h)
                                                                @if ($h->date == $thisDate)
                                                                    @php $hday=true; @endphp
                                                                    {{-- <td colspan="2" class="text-center">
                                                                <p class="mb-0 text-info">{{$h->description}}</p>
                                                            </td> --}}
                                                                @else
                                                                    @php $hday=false; @endphp
                                                                @endif
                                                            @endforeach

                                                            {{-- @if ($hday == false)
                                                            <td class="text-center" @if ($hday == true) style="display:none;" @endif> {{ date('h:i:s a', strtotime($defaultTime->stime)) }}</td>
                                                            <td class="text-center" @if ($hday == true) style="display:none;" @endif> {{ date('h:i:s a', strtotime($defaultTime->etime)) }}</td>
                                                            @endif --}}
                                                            <td class="text-center"
                                                                @foreach ($holiday as $h) @if ($h->date == $thisDate) colspan="2" @endif @endforeach>


                                                                @foreach ($holiday as $h)
                                                                    @if ($h->date == $thisDate)
                                                                        @php $hday=true; @endphp {{ $h->description }}
                                                                    @endif
                                                                @endforeach
                                                                @if ($hday == false)
                                                                    @foreach ($ramadan as $r)
                                                                        @if ($thisDate >= $r->date_from && $thisDate <= $r->date_to)
                                                                            @php $rmdn = true; @endphp
                                                                            {{ date('h:i:s a', strtotime($r->stime)) }}
                                                                        @else
                                                                            @php $rmdn = false; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    @if ($rmdn == false)
                                                                        {{ date('h:i:s a', strtotime($defaultTime->stime)) }}

                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td class="text-center"
                                                                @foreach ($holiday as $h) @if ($h->date == $thisDate) style="display:none;" @endif @endforeach>
                                                                @foreach ($ramadan as $r)
                                                                    @if ($thisDate >= $r->date_from && $thisDate <= $r->date_to)
                                                                        {{ date('h:i:s a', strtotime($r->etime)) }}
                                                                    @endif
                                                                @endforeach
                                                                @if ($rmdn == false)
                                                                    {{ date('h:i:s a', strtotime($defaultTime->etime)) }}
                                                                @endif
                                                            </td>
                                                        @elseif($dw->option_code == date('l', $i) && $dw->option_value == 'Y')
                                                            <td colspan="2" class="text-center">
                                                                <p class="mb-0 text-info">Weekend</p>
                                                            </td>
                                                        @endif
                                                    @endforeach
                                                @endif


                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->

                                <!-- /.card -->

                            </div>
                        </div>
                        <!--leave request part  -->

                    </div>

                @endsection
                <!-- end editing-->
            @endsection
        @endsection
    @endsection

    @section('script')
        @parent

        <script>
            let $selectDepartment = $('#dept'),
                $selectEmployee = $('#all_staff'),
                $options = $selectEmployee.find('option');

            $selectDepartment.on('change', function () {
                $selectEmployee.html($options.filter('[data-state="' + this.value + '"]'));
            }).trigger('change');


            // Date  field customization
            $(function () {
                $('.js-date-field').flatpickr();
            })
        </script>

    @endsection
@endsection
