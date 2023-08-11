@extends('index')
@section('title', '| Roster ')
@section('wrapper')
    @parent

    {{-- @author: Akash Chandra Debnath
    @Behaviour : Set employee working and weekend days [Roster, Non-roster, Slot-roster]  --}}

    @section('content-wrapper')
        @parent
        @section('content-header')

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>Roster Settings</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"> Remark</a></li>
                                <li class="breadcrumb-item"><a href="#">Attach </a></li>
                                <li class="breadcrumb-item active">Roster Settings</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @if ($errors->any())
                                <div class="w-100 alert alert-warning alert-dismissible fade show" id="successMsg"
                                     role="alert">
                                    <strong>{{ implode('', $errors->all(':message')) }}</strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif ($message = Session::get('success'))
                                <div class="w-100 alert alert-success alert-dismissible fade show" id="successMsg"
                                     role="alert">
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif ($message = Session::get('fail'))
                                <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg"
                                     role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
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
                    $day_array = ['sun' => 'Sunday', 'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday'];
                    $counter = 0;
                    $aDays = array();
                    $max_weekend = 2;
                    $key = 0;
                @endphp
                    <div class="row">
                        <!-- leave request by year table -->
                        <div class="col-xl-12">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    @php
                                        $selected = [];
                                        $slotNumber = count($rosterSlot);
                                        $rowColumnInfo = [];
                                    @endphp
                                    {{-- main form --}}
                                    <form action="{{ url('set-roster') }}" method="POST" id="searchForm">
                                        @csrf
                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Department</label>
                                                        <select class="form-control" name="dept_code" id="deptt"
                                                                style="width: 100%;"
                                                                onchange="this.form.submit()">
                                                            <option selected hidden>--Department--</option>
                                                            @foreach ($departments as $department)
                                                                <option
                                                                    value="{{ $department->dept_code }}" {{ $department->dept_code==$dept ? 'selected' : '' }}>{{ $department->dept_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="r_type">Roster Type</label>
                                                        <select class="form-control" name="roster" id="r_type"
                                                                style="width: 100%;"
                                                                onchange="this.form.submit()">
                                                            <option selected hidden>--Select--</option>
                                                            <option value="Y" {{ $roster=="Y" ? 'selected' : ''}}>Roster</option>
                                                            <option value="N" {{ $roster=="N" ? 'selected' : ''}}>Non-roster</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                @php
                                                    $sdate = date('Y-m-d');
                                                    $edate = date('Y-m-t');
                                                @endphp

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="from">From</label>
                                                        <input class="form-control js-date-field bg-transparent" type="date" value="{{ $sdate }}" name="from" id="from">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="from">To</label>
                                                        <input class="form-control js-date-field bg-transparent" type="date" value="{{ $edate }}"  name="to" id="to">
                                                    </div>
                                                </div>

                                                <div class="col-md-12 d-flex align-items-end ">
                                                    <button type="submit" value="submit" name="submit"
                                                            class="btn btn-sm btn-info ml-auto">Show
                                                    </button>
                                                </div>

                                    </form>
                                    {{-- @if ($slotNumber == 0 && $roster == 'N') --}}
                                    <div class="col-12 ">
                                        <label>Select Staff</label><span> *</span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <select class="select2 select2-info" id="staff" multiple="multiple"
                                                    data-placeholder="Select Staff" style="width: 100%;">
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} - {{ $employee->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    {{-- @endif --}}

                                    <div class="col-md-6">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            @php
                                $from = $startdate;
                                $to = $enddate;
                                $startTime = strtotime($from);
                                $endTime = strtotime($to);
                            @endphp
                            @php  $dateArray = array(); @endphp
                            @if (($rosterDepartment == 'Y' && $roster == 'Y'))
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <button href="#rosterSlotModal" id="openBtn" data-toggle="modal"
                                                class="btn btn-primary btn-sm">Add Roster Slot
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12  overflow-auto ">
                                        <table class="table table-hover table-bordered  selectpicker "
                                               data-live-search="true">
                                            <thead>
                                            <tr>
                                                @foreach ($rosterSlot as $key => $slot)
                                                    @php
                                                        $slotFrom = date('h:i a', strtotime($slot->from));
                                                        $slotTo = date('h:i a', strtotime($slot->to));
                                                    @endphp
                                                    <th id="slot-{{ $key }}"
                                                        data-id="{{ $slot->slot_no }}"> {{ $slotFrom . ' to ' . $slotTo }} </th>
                                                @endforeach
                                                <th>Holiday</th>
                                                <th>Weekend</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $rowColumnInfo = [];
                                            @endphp
                                            @for ($i = $from; $i <= $to; $i = $i + 86400)
                                                @php
                                                    $thisInputDate = date('Y-m-d', $i);
                                                    $thisDate = date('d F, Y(l)', $i);
                                                    $rowColumnInfo[$i] = [];

                                                @endphp
                                                <tr>
                                                    <td colspan="6"><i>{{ $thisDate }}</i></td>
                                                </tr>
                                                <tr id="{{ $i }}">
                                                    <input type="hidden" name="rowDate" class="rosterDate"
                                                           value="{{ $thisInputDate }}">
                                                    @foreach ($rosterSlot as $key => $slot)
                                                        @php
                                                            $st = $i . strtotime($slot->from);
                                                            array_push($dateArray, $st);
                                                            $rowColumnInfo[$i][] = $i . $key;
                                                        @endphp
                                                        <td id="{{ $i . $key }}">
                                                            <div class="container-fluid">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <p class="cellEmployeeListShow"></p>
                                                                    </div>
                                                                </div>

                                                                <div class="row ">
                                                                    <div class="col-12">
                                                                        <input type="hidden" name="stime"
                                                                               value="{{ $slot->from }}">
                                                                        <input type="hidden" name="etime"
                                                                               value="{{ $slot->to }}">

                                                                        <label class="validation-error hide"
                                                                               id="fullNameValidationError"></label>
                                                                        {{-- id="employee{{ $i . strtotime($slot->from) }}" --}}
                                                                        <select name="employees[]" class="form-control"
                                                                                id="staffs" style="width:100%"
                                                                                onchange="onChangeEmployee(event)">
                                                                            <option value="" selected>select staff
                                                                            </option>
                                                                            @foreach ($employees as $emp)
                                                                                <option value="{{ $emp->emp_id }}">
                                                                                    {{ $emp->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    @endforeach

                                                    <td id="{{ $i . ++$key }}">
                                                        @php
                                                            $rowColumnInfo[$i][] = $i . $key;
                                                        @endphp
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="cellEmployeeListShow"></p>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    {{-- <form action="" class="form-group"> --}}
                                                                    <select onchange="onChangeEmployee(event)"
                                                                            class=" form-control "
                                                                            style="width: 100%;">
                                                                        <option selected="selected" hidden>Select
                                                                            Employee
                                                                        </option>
                                                                        @foreach ($employees as $emp)
                                                                            <option value="{{ $emp->emp_id }}">
                                                                                {{ $emp->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td id="{{ $i . ++$key }}">
                                                        @php
                                                            $rowColumnInfo[$i][] = $i . $key;
                                                        @endphp
                                                        <p class="empWeekends"></p>
                                                    </td>
                                                </tr>
                                            @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="ml-auto">
                                        <button type="submit" id="saveBtn" onclick="setRoster()"
                                                class="btn btn-sm btn-info">Set
                                            Roster
                                        </button>
                                    </div>
                                </div>

                                <!-- Roster Slot Setter Modal -->
                                <div class="modal fade" id="rosterSlotModal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-info">
                                                <h4 class="modal-title">Roster Slot List</h4>
                                                <button type="button" class="close ml-auto" data-dismiss="modal"
                                                        aria-hidden="true">x
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="text-center">Department:
                                                    @foreach ($departments as $dpt)
                                                        @if ($dpt->dept_code == $dept)
                                                            {{ $dpt->dept_name }}
                                                        @endif
                                                    @endforeach
                                                </h6>
                                                <form id='rosterSlotForm' name='rosterSlotForm' class='' method="post"
                                                      action="">
                                                    @csrf
                                                    <table class="table table-bordered table-condensed"
                                                           id="rosterTable">

                                                        <thead id="tblHead">
                                                        <tr>
                                                            <th>Slot No.</th>
                                                            <th>From</th>
                                                            <th>To</th>
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($rosterSlot as $k => $ary)
                                                            @php
                                                                $from = date('h:i:s', strtotime($ary->from));
                                                                $to = date('h:i:s', strtotime($ary->to));
                                                                $fromNonEditable = date('h:i A', strtotime($ary->from));
                                                                $toNonEditable = date('h:i A', strtotime($ary->to));
                                                            @endphp
                                                            <tr class="slotRow{{ $k }}">
                                                                <td>
                                                                    <div class='tableData{{ $k }}'>{{ $ary->slot_no }}
                                                                    </div>
                                                                    <div class='tableEdit{{ $k }}'
                                                                         style="display: none">
                                                                        <select
                                                                            class='slotNo selectpicker form-control btn-sm'
                                                                            name='slotNo' data-width='100%'>
                                                                            @for ($i = 1; $i <= 10; $i++)
                                                                                @if ($i == $ary->slot_no)
                                                                                    <option value="{{ $i }}"
                                                                                            selected>{{ $i }}</option>
                                                                                @else
                                                                                    <option
                                                                                        value="{{ $i }}">{{ $i }}</option>
                                                                                @endif
                                                                            @endfor
                                                                        </select>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <div
                                                                        class='tableData{{ $k }}'>{{ $fromNonEditable }}
                                                                    </div>
                                                                    <div class='tableEdit{{ $k }} bootstrap-timepicker'
                                                                         style="display: none">
                                                                        <input type='time'
                                                                               class='rosterSlotFrom form-control'
                                                                               name='rosterSlotFrom' value='{{ $from }}'
                                                                               placeholder='hh:mm:ss'>
                                                                    </div>

                                                                </td>
                                                                <td>
                                                                    <div class='tableData{{ $k }}'>{{ $toNonEditable }}
                                                                    </div>
                                                                    <div class='tableEdit{{ $k }}  bootstrap-timepicker'
                                                                         style="display: none">
                                                                        <input type='time'
                                                                               class='rosterSlotTo form-control'
                                                                               name='rosterSlotTo' value='{{ $to }}'
                                                                               placeholder='hh:mm:ss'>
                                                                    </div>

                                                                </td>
                                                                <td class='text-center'>
                                                                    <div class='tableData{{ $k }}'><a
                                                                            class='rosterSlotEdit btn btn-warning btn-xs'
                                                                            onclick="editSlots({{ $k }})"
                                                                            data-id='{{ $ary->id }}'>Edit</a> | <a
                                                                            class='rosterSlotDelete btn btn-danger btn-xs'
                                                                            data-id='{{ $ary->id }}'
                                                                            href="{{ url('delete-slot', ['id' => $ary->id]) }}">Delete</a>
                                                                    </div>
                                                                    <div class='tableEdit{{ $k }}'
                                                                         style="display: none">
                                                                        <a class='updateRosterSlot btn btn-primary btn-xs'
                                                                           data-id='{{ $ary->id }}'
                                                                           onclick="updateSlots({{ $ary->id }},{{ $k }})">Update</a>
                                                                    </div>

                                                                </td>
                                                            </tr>
                                                        @endforeach

                                                        <tr id='rosterRow'>
                                                            <td><select class='selectpicker form-control btn-sm'
                                                                        id='slotNo'
                                                                        data-width='100%'>
                                                                    @for ($i = 1; $i <= 10; $i++)
                                                                        <option value='{{ $i }}'>{{ $i }} </option>
                                                                    @endfor
                                                                </select></td>
                                                            <td>
                                                                <div class='bootstrap-timepicker'>
                                                                    <input type='time' class='form-control'
                                                                           id='rosterSlotFrom' placeholder='hh:mm:ss'>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class='bootstrap-timepicker'>
                                                                    <input type='time' class='form-control'
                                                                           id='rosterSlotTo' placeholder='hh:mm:ss'>
                                                                </div>
                                                            </td>
                                                            <td class="text-center"><input id='addRosterSlot'
                                                                                           class='btn btn-primary btn-sm'
                                                                                           value='Add' type="submit"
                                                                                           onclick="rosterSlotAdd(event)">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-primary">
                                                    Cancel
                                                </button>
                                            </div>

                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                                <!-- /.modal -->

                            @else

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="card   ">
                                            <div class="card-header">
                                                <ul class="nav nav-pills">
                                                    <li class="nav-item"><a class="nav-link active" href="#same-time"
                                                                            data-toggle="tab">Same Time for All day</a>
                                                    </li>

                                                    <li class="nav-item"><a class="nav-link" href="#diff-time"
                                                                            data-toggle="tab">Custom
                                                            Time for Different Day</a></li>
                                                </ul>
                                            </div>

                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div class="active tab-pane" id="same-time">
                                                        <form action="{{ url('roster-set-same-time') }}" method="POST"
                                                              enctype="multipart/form-data" id="sameTimeFormId">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="row">
                                                                        <input type="hidden" name="type" value="same">
                                                                        <input type="hidden" name="sdate"
                                                                               value="{{ $startdate }}">
                                                                        <input type="hidden" name="edate"
                                                                               value="{{ $enddate }}">
                                                                        <input type="hidden" name="dept_code"
                                                                               value="{{ $dept }}">
                                                                        <input type="hidden" name="emp_ids"
                                                                               id="staffIds">
                                                                        <div class="col-12">
                                                                            <label for="stime">Office Start Time</label>
                                                                            <input type="time" value="09:00:00"
                                                                                   name="stime" id="stime"
                                                                                   class="form-control js-time-field bg-transparent">
                                                                        </div>
                                                                        <div class="col-12 mt-3">
                                                                            <label for="etime">Office End Time</label>
                                                                            <input type="time" value="18:00:00"
                                                                                   name="etime" id="etime"
                                                                                   class="form-control js-time-field bg-transparent">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                @php
                                                                    $day_array = ['sun' => 'Sunday', 'mon' => 'Monday', 'tue' => 'Tuesday', 'wed' => 'Wednesday', 'thu' => 'Thursday', 'fri' => 'Friday', 'sat' => 'Saturday'];
                                                                    $counter = 0;
                                                                @endphp

                                                                <div class="col-md-6 ">
                                                                    <h6 class=" text-center"><strong>Select Weekend
                                                                            Day(s)</strong></h6>
                                                                    <div class="row d-flex justify-content-center">
                                                                        <div class="col-md-5">
                                                                            <div class="row" id="listWeekends">
                                                                                @foreach ($day_array as $key => $value)
                                                                                    <div class="col-12">
                                                                                        <label> <input type="checkbox" class="mr-1"
                                                                                                       name="weekend[]"
                                                                                                       value="{{ $value }}"
                                                                                                       onclick="moreWeekend(event)"
                                                                                                       data-id="{{ $key }}">{{ $value }}
                                                                                        </label>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if(Auth::user()->can('rosterSettings-create'))
                                                                <div class="ml-auto">
                                                                    <button class="btn btn-sm btn-info">Set Roster</button>
                                                                </div>
                                                            @endif
                                                        </form>
                                                    </div>


                                                    {{-- Weekend limit Modal --}}
                                                    <div class="modal fade" id="requestModal" role="dialog"
                                                         aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info">
                                                                    <h5 >Send Request</h5>
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal"
                                                                            aria-hidden="true">&times;
                                                                    </button>
                                                                   
                                                                       
                                                                        
                                                                            
                                                                        
                                                                    </div>
                                                                <form id="requestModalForm" class='form-horizontal'
                                                                      action="{{ url('set-roster-more-weekend') }}"
                                                                      method="post">
                                                                    @csrf
                                                                    <input type="hidden" name="type" value="same">
                                                                    <input type="hidden" name="sdate"
                                                                           value="{{ $startdate }}">
                                                                    <input type="hidden" name="edate"
                                                                           value="{{ $enddate }}">
                                                                    <input type="hidden" name="dept_code"
                                                                           value="{{ $dept }}">
                                                                    <input type="hidden" name="emp_ids"
                                                                           id="staffIdsWeekend">
                                                                    <input type="hidden" id="from_time" name="stime"
                                                                           value="09:00:00">
                                                                    <input type="hidden" id="to_time" name="etime"
                                                                           value="18:00:00">

                                                                   
                                                                    <div class="modal-body">
                                                                        <p>To select more than two weekends in a week
                                                                            slot, send a request to admin selecting
                                                                            those weekends. Otherwise Cancel it.</p>
                                                                        <div class='col-xs-12'>
                                                                            <div class="form-group" id="modalSelect">
                                                                                <div class="row">
                                                                                    @foreach ($day_array as $key => $value)
                                                                                        <div class="col-12">
                                                                                            <label> <input
                                                                                                    type="checkbox" class="mr-1"
                                                                                                    name="weekend[]"
                                                                                                    value="{{ $value }}">{{ $value }}
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class='col-xs-12'>
                                                                            <div class="form-group">
                                                                                <label>Reason</label>
                                                                                <textarea id="reason" name="reason"
                                                                                          placeholder="Enter ..."
                                                                                          rows="2" class="form-control"
                                                                                          required></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class='clearfix'></div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default"
                                                                                data-dismiss="modal">Cancel
                                                                        </button>
                                                                        <button type="submit" class="btn btn-warning"
                                                                                id="sendRequest">Send Request
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- End Weekend limit modal --}}


                                                    {{-- Custom roster more weekend modal start--}}
                                                    <div class="modal fade" id="customModal" role="dialog"
                                                         aria-labelledby="customModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal" aria-hidden="true">
                                                                        &times;
                                                                    </button>
                                                                    <h4 class="modal-title">Send Request</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>To select weekends more than as usual in a week
                                                                        slot, a request will be sent to admin. Otherwise
                                                                        <mark><b>Cancel</b></mark>
                                                                        it.
                                                                    </p>
                                                                    <div class='col-xs-12'>
                                                                        <div class="form-group">
                                                                            <label>Reason</label>
                                                                            <textarea id="customR"
                                                                                      placeholder="Enter valid reason for this weekend ..."
                                                                                      rows="2"
                                                                                      class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class='clearfix'></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default"
                                                                            id="customCancel" data-dismiss="modal">
                                                                        Cancel
                                                                    </button>
                                                                    <button type="button" class="btn btn-warning"
                                                                            id="customOk">Ok
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- Custom roster more weekend modal start end --}}

                                                    <div class="tab-pane overflow-auto" id="diff-time">
                                                        <form action="{{ url('roster-set-custom-time') }}" method="POST"
                                                              enctype="multipart/form-data">
                                                            @csrf

                                                            <input type="hidden" name="emp_ids" id="staffIdCustom">
                                                            <table
                                                                class="table table-hover table-bordered  selectpicker"
                                                                data-live-search="true" id="customTimeTable">
                                                                <thead>
                                                                <th>Weekend</th>
                                                                <th>Date</th>
                                                                <th>Day</th>
                                                                <th>From</th>
                                                                <th>To</th>
                                                                </thead>
                                                                <tbody>
                                                                <input type="hidden" name="type" value="custom">
                                                                <input type="hidden" name="sdate"
                                                                       value="{{ $startdate }}">
                                                                <input type="hidden" name="edate"
                                                                       value="{{ $enddate }}">
                                                                <input type="hidden" name="dept_code"
                                                                       value="{{ $dept }}">
                                                                <input type='hidden' id='customReason'
                                                                       name='customReason' value=''>

                                                                @php
                                                                    $sdate = date('Y-m-d', $from);
                                                                    $edate = date('Y-m-d', $to);
                                                                    $max_weekend = 2;
                                                                    $aDays = array();
                                                                @endphp
                                                                @for ($sDate = $from; $sDate <= $to; $sDate = $sDate + 86400)
                                                                    @php
                                                                        $thisDate = date('Y-m-d', $sDate);
                                                                        $aDays[] = $thisDate;
                                                                    @endphp
                                                                @endfor
                                                                @foreach($aDays as $i=>$date)
                                                                    <tr>
                                                                        <td><input type='checkbox' id='check{{ $i }}'
                                                                                   class='leave_check {{$date}}'
                                                                                   name='leave_chk[]'
                                                                                   value='{{ $date }}'></td>
                                                                        <td>{{ $date }}<input type='hidden'
                                                                                              class='roster_date'
                                                                                              name='date[]'
                                                                                              value='{{ $date }}'></td>
                                                                        <td>{{ date("l", strtotime($date)) }}</td>
                                                                        <td><span class='bootstrap-timepicker'><input
                                                                                    type='time' name='stime[]'
                                                                                    value='09:00:00'
                                                                                    class='form-control time_field stime cstime'></span><span
                                                                                class='holiText text-danger' hidden><b>Weekend</b></span>
                                                                        </td>
                                                                        <td><span class='bootstrap-timepicker'><input
                                                                                    type='time' name='etime[]'
                                                                                    value='18:00:00'
                                                                                    class='form-control time_field etime cetime'></span><span
                                                                                class='holiText text-danger' hidden><b>Weekend</b></span>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                            @if(Auth::user()->can('rosterSettings-create'))
                                                                <div class="ml-auto">
                                                                    <button type="submit" id="save" class="btn btn-sm btn-info">
                                                                        Set Roster
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </form>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                            </div>
                                            {{-- //card-body --}}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <!-- /.card-header -->
                            <!-- /.tab-content -->
                        </div>
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
            var dept = `<?php echo $dept; ?>`;
            let formattedSelectedEmployeeList = {};
            let formattedSelectedColEmployeeList = {};
            let formattedEmployeeList = {};
            let rowColumnInfo = @JSON($rowColumnInfo);
            let employeeList = @JSON($employees);
            let employeeWeekendList = {};
            $(document).ready(function () {
                Object.entries(rowColumnInfo).map(row => {
                    formattedSelectedEmployeeList[row[0]] = []
                    formattedEmployeeList[row[0]] = employeeList;
                    var rowNode = document.getElementById(row[0]).querySelector('.empWeekends');
                    //weekendFormatedHtml(employeeList,rowNode);
                    row[1].map(function (col) {
                        formattedSelectedColEmployeeList[col] = []
                    })
                })

            });

            function weekendFormatedHtml(empList, appendNode) {
                let emplListHtml = ''
                let rowIdForWeekend = appendNode.parentElement.parentElement.getAttribute('id');
                // if(employeeWeekendList[rowIdForWeekend] == undefined){

                // }
                employeeWeekendList[rowIdForWeekend] = []
                empList.forEach(function (emp) {
                    if (employeeWeekendList[rowIdForWeekend].indexOf(emp.emp_id) == -1) {
                        employeeWeekendList[rowIdForWeekend].push(emp.emp_id);
                    }
                    emplListHtml += `<span class="weekendEmpList" data-id='` + emp.emp_id + `'>` + emp.name + `</span>` + `</br>`;
                })
                appendNode.innerHTML = emplListHtml;
            }


            $(function () {

                $('.select2').select2()
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                })

                $('#staff').change(function (e) {
                    $('#staffIds').val($(e.target).val());
                });

                $('#staff').change(function (e) {
                    $('#staffIdCustom').val($(e.target).val());
                });

                $('#staff').change(function (e) {
                    $('#staffIdsWeekend').val($(e.target).val());
                });

                //For date and time field customization
                $('.js-date-field').flatpickr();
                $('.js-time-field').flatpickr({
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: false,
                    defaultHour: 12
                });
            })


            function moreWeekend(e) {

                var form = $("#sameTimeFormId");
                // alert($(this).attr("selectWeekend"));
                var checkboxes = $("input:checkbox", form);
                var x = checkboxes.filter(':checked').length;
                let currentCheckValue = e.target.value;
                $('#requestModalForm input[type=checkbox]').each(function () {
                    if (this.value == currentCheckValue) {
                        this.setAttribute("checked", "checked");
                    }
                });
                if (x > 2) {
                    $(e.target).prop("checked", false);
                    $('#requestModal').modal('show');
                }
            }


            setTimeout(function () {
                $('#successMsg').fadeOut('slow');
                $('#failMsg').fadeOut('slow');
            }, 3000);


            var $selectState = $('#dept'),
                $selectDistrict = $('#staff'),
                $options = $selectDistrict.find('option');

            $selectState.on('change', function () {
                $selectDistrict.html($options.filter('[data-state="' + this.value + '"]'));
            }).trigger('change');


            var selectedRow = null
            let selectedEmp = [];
            var filteredEmpList = {};

            function onChangeEmployee(e) {
                let tdElement = e.target.parentElement.closest('td').getAttribute('id');
                let trElement = e.target.parentElement.closest('tr').getAttribute('id');

                // console.log(tdElement,trElement)
                formattedSelectedColEmployeeList[tdElement].push(e.target.value);
                // console.log(formattedSelectedColEmployeeList[tdElement]);
                formattedSelectedEmployeeList[trElement].push(e.target.value);
                //console.log(formattedEmployeeList,  formattedSelectedEmployeeList[trElement],formattedSelectedColEmployeeList[tdElement]);
                let selectedRowEmpList = formattedEmployeeList[trElement];
                filteredEmpList = selectedRowEmpList.filter((empItem, idx) => {
                    let empId = empItem.emp_id;
                    return formattedSelectedEmployeeList[trElement].includes(empId) == false
                })
                var rowNode = document.getElementById(trElement).querySelector('.empWeekends');
                weekendFormatedHtml(filteredEmpList, rowNode)


                // Append selected employee
                let SelectedEmpListHtml = ''
                employeeList.forEach(function (em) {
                    formattedSelectedColEmployeeList[tdElement].forEach(function (emp) {
                        if (em.emp_id == emp) {
                            SelectedEmpListHtml += `<div><span>` + em.name + `</span>` +
                                ` <a onClick="onDelete(event,` + emp + ',' + trElement + ',' + tdElement +
                                `)"><i style="color:red" class="fa fa-times" aria-hidden="true"></i></a>` +
                                `</br></div>`;
                        }
                        var colNode = document.getElementById(tdElement).querySelector('.cellEmployeeListShow');
                        colNode.innerHTML = SelectedEmpListHtml;
                    })
                })
            }


            function onDelete(event, empId, trId, tdId) {
                event.preventDefault();
                if (confirm('Are you sure to delete this record ?')) {
                    var index = formattedSelectedColEmployeeList[tdId].indexOf(empId.toString());
                    if (index !== -1) {
                        formattedSelectedColEmployeeList[tdId].splice(index, 1);
                    }
                    event.target.parentElement.parentElement.remove();

                    employeeList.forEach(function (emp) {
                        if (emp.emp_id == empId) {
                            filteredEmpList.push(emp);
                        }
                    })
                    var rowNode = document.getElementById(trId).querySelector('.empWeekends');
                    weekendFormatedHtml(filteredEmpList, rowNode)
                }
            }


            function setRoster() {
                let formatSlotSubmiteddata = {};
                let weekendSubmitedData = {};
                let holidaySubmitedData = {};
                Object.entries(formattedSelectedColEmployeeList).map(item => {
                    let len = item[0].toString().length;
                    let rowId = item[0].toString().substr(0, len - 1);
                    let numberOfTotalColum = rowColumnInfo[rowId].length
                    let colForSlot = item[0].toString().slice(-1);
                    let empRosterDate = document.getElementById(rowId).querySelector('.rosterDate').value;
                    if (item[1].length && colForSlot < (numberOfTotalColum - 2)) {
                        let empRosterSlotNumber = document.getElementById('slot-' + colForSlot).getAttribute('data-id');
                        if (formatSlotSubmiteddata[empRosterDate] != undefined) {
                            formatSlotSubmiteddata[empRosterDate] = Object.assign(formatSlotSubmiteddata[
                                empRosterDate], {
                                [empRosterSlotNumber]: [...item[1]]
                            })
                        } else {
                            formatSlotSubmiteddata[empRosterDate] = Object.assign({
                                [empRosterSlotNumber]: [...item[1]]
                            })
                        }

                    } else if (item[1].length && colForSlot < (numberOfTotalColum - 1)) {
                        holidaySubmitedData[empRosterDate] = [...item[1]]
                    } else if (employeeWeekendList[rowId] != undefined && colForSlot == (numberOfTotalColum - 1)) {
                        if (weekendSubmitedData[empRosterDate] == undefined) {
                            weekendSubmitedData[empRosterDate] = employeeWeekendList[rowId]
                        }

                    }

                })


                var rosterSlotData = {
                    objSlot: formatSlotSubmiteddata,
                    objWeekend: weekendSubmitedData,
                    objHoliday: holidaySubmitedData,
                    dept: dept
                };

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: 'roster-slot-data',
                    data: {
                        allData: JSON.stringify(rosterSlotData)
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }

                });
            }


            function editSlots(id) {
                const editSpecificSlot = Array.from(document.getElementsByClassName('tableData' + id));
                editSpecificSlot.forEach(item => {
                    item.style.display = 'none';
                });

                const updateSpecificSlot = Array.from(document.getElementsByClassName('tableEdit' + id));
                updateSpecificSlot.forEach(itemUpdate => {
                    itemUpdate.style.display = 'block';
                });
            }


            function rosterSlotAdd(e) {
                e.preventDefault();
                var slotNo = $('#slotNo').val();
                var slotFrom = $('#rosterSlotFrom').val();
                var slotTo = $('#rosterSlotTo').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: 'add-roster-slot',
                    data: {
                        dept: dept,
                        slotNo: slotNo,
                        slotFrom: slotFrom,
                        slotTo: slotTo
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            }


            function updateSlots(id, rowId) {
                var slotNo = $(".slotRow" + rowId).find("select[name=slotNo]").val();
                var slotFrom = $(".slotRow" + rowId).find("input[name=rosterSlotFrom]").val();
                var slotTo = $(".slotRow" + rowId).find("input[name=rosterSlotTo]").val();


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: 'upate-roster-slot/' + id,
                    data: {
                        slotNo: slotNo,
                        slotFrom: slotFrom,
                        slotTo: slotTo
                    },
                    success: function (response) {
                        window.location.reload();
                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        console.log(errorMessage);
                    }
                });
            }

        </script>


        <script>
            var startDate = `<?php echo $sdate ?>`;
            var endDate = `<?php echo $edate ?>`;
            var weekDay = <?php echo json_encode($day_array) ?>;
            var periodDate = <?php echo json_encode($aDays) ?>;
            var mLimit = <?php echo $max_weekend ?>;

            $(function () {
                var isCustomToAdmin = false;
                var clickedDate;
                var isOk = false;
                var customDateAry = new Array();

                //format SetOfDate
                var setOfDate = new Array();
                var j = 0;
                var tmpAry = new Array();
                for (var i = 0; i < periodDate.length; i++) {
                    var datex = new Date(periodDate[i]);
                    var dayN = datex.getDay();
                    tmpAry[tmpAry.length] = periodDate[i];

                    if (dayN == 6 || i == (periodDate.length - 1)) {
                        setOfDate[j] = tmpAry;
                        tmpAry = new Array();
                        j++;
                    }
                }

                $('input.leave_check:checkbox').click(function () {
                    clickedDate = $(this);
                    var parentRow = $(this).parents("tr");
                    var tbody = $(this).parents("tbody");
                    var str = parentRow.find('td:nth-child(2) input.roster_date:hidden').val();	//select date

                    var indexAtPeriodDate = $.inArray(str, periodDate);
                    var aryIndex = getIndex(str, setOfDate);   //get [' index', 'inner index']

                    var countS = 0;
                    var index1 = aryIndex[0];
                    var innerIndex = aryIndex[1];
                    var selectedSet = setOfDate[index1];
                    var previousSet = setOfDate[index1 - 1];
                    var nextSet = setOfDate[index1 + 1];
                    var lengthSelectedSet = (selectedSet.length - 1);

                    for (var k = 0; k < selectedSet.length; k++) {
                        var id = selectedSet[k];
                        var sId = "input." + id + ":checkbox";
                        var dateChecked = tbody.find(sId).is(":checked");

                        if (dateChecked) {
                            if ((k == 0 && dateChecked && previousSet != undefined)) {
                                var countprv = 0;
                                var countIn = 1;

                                for (var t = 0; t < mLimit; t++) {
                                    var chk = "#check" + (indexAtPeriodDate - (t + 1 + innerIndex));
                                    if (tbody.find(chk).is(":checked")) {
                                        countprv++;
                                    } else {
                                        break;
                                    }
                                }

                                for (var i = 1; i < mLimit; i++) {

                                    var id = selectedSet[i];
                                    var sId = "input." + id + ":checkbox";
                                    var innerChecked = tbody.find(sId).is(":checked");

                                    if (innerChecked) {
                                        countIn++;
                                    } else {
                                        break;
                                    }
                                }

                                var sum = countprv + countIn;
                                console.log("sum:" + sum);
                                if (sum <= mLimit) {
                                    countprv = 0;
                                }

                                console.log("prv:" + countprv);
                                countS += countprv;

                            } else if (k == lengthSelectedSet && dateChecked && nextSet != undefined) {
                                var countnxt = 0;
                                var countIn = 1;

                                for (var t = 0; t < mLimit; t++) {
                                    var chk = "#check" + (indexAtPeriodDate + (t + 1 + (lengthSelectedSet - innerIndex)));
                                    if (tbody.find(chk).is(":checked")) {
                                        countnxt++;
                                    } else {
                                        break;
                                    }
                                }
                                for (var i = (lengthSelectedSet - 1); i > (lengthSelectedSet - mLimit); i--) {

                                    var id = selectedSet[i];
                                    var sId = "input." + id + ":checkbox";
                                    var innerChecked = tbody.find(sId).is(":checked");

                                    if (innerChecked) {
                                        countIn++;
                                    } else {
                                        break;
                                    }
                                }

                                var sum = countnxt + countIn;
                                console.log("sum:" + sum);
                                if (sum <= mLimit) {
                                    countnxt = 0;
                                }

                                // console.log("nxt:"+countnxt);
                                countS += countnxt;
                            }

                            countS++;
                            if (countS > mLimit) {
                                $('#customModal').modal('show');
                                break;
                            }
                        }
                    }

                    var isChecked = $(this).is(":checked");
                    parentRow.find(":input.time_field").attr("hidden", isChecked);
                    parentRow.find(".holiText").attr("hidden", !isChecked);
                });


                $('#customOk').on('click', function () {
                    var reason = $('#customR').val();

                    if (reason.length < 10) {
                        alert("Please enter a valid reason(atleast 10 characters).");
                        return;
                    } else {
                        $('#customModal').modal('hide');
                        $('#customReason').val($('#customReason').val() + reason + "; ");
                        $('#toAdmin').val(true);
                        isOk = true;
                        isCustomToAdmin = true;
                    }
                });


                $('#customModal').on('hidden.bs.modal', function () {
                    if (!isOk) {
                        clickedDate.prop("checked", false);
                        clickedDate.parents("tr").find(":input.time_field").attr("hidden", false);
                        clickedDate.parents("tr").find(".holiText").attr("hidden", true);
                    }
                    isOk = false;
                });

            });


            function getIndex(str, setOfDate) {
                for (var i = 0; i < setOfDate.length; i++) {
                    var index = $.inArray(str, setOfDate[i]);
                    if (index != -1) {
                        var array = [i, index];
                        return array;
                    }
                }
            }
        </script>

    @endsection
@endsection
