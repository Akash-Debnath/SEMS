@extends('index')
@section('title', 'Roster ')
@section('wrapper')
@parent

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
        <div class="h-100 d-flex align-items-center justify-content-center">
            @if($message = Session::get('success'))
                <div id="successMsg" class="alert alert-success text-center">{{ $message }}</div>
            @elseif ($message = Session::get('fail'))
                <div id="failMsg" class="alert alert-danger text-center">{{ $message }}</div>
            @endif
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
    $slotNumber = count($rosterSlot);
@endphp

<div class="row">
    <!-- leave request by year table -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">

                {{-- main form --}}
                <form action="{{ url('set-roster') }}" method="POST" id="searchForm">
                    @csrf
                    <div class="col-12">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="dept_code" id="deptt" style="width: 100%;" onchange="this.form.submit()">
                                        <option selected hidden>--Department--</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->dept_code }}">{{$department->dept_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="r_type">Roster Type</label>
                                    <select class="form-control" name="roster" id="r_type" style="width: 100%;" onchange="this.form.submit()">
                                        <option selected hidden>--Select--</option>
                                        <option value="Y">Roster</option>
                                        <option value="N">Non-roster</option>
                                    </select>
                                </div>
                            </div>

                            @php
                            $sdate = date('Y-m-d');
                            $edate = date('Y-m-t');
                            @endphp

                            {{-- date form started --}}
                            {{-- <form action="" method="GET"> --}}
                                @csrf
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input class="form-control" type="date" value="{{ $sdate }}" name="from" id="from">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="from">To</label>
                                        <input class="form-control" type="date" value="{{ $edate }}" name="to" id="to">
                                    </div>
                                </div>
                                
                                    <div class="col-md-12 d-flex align-items-end ">
                                        <button type="submit" value="submit" name="submit" class="btn btn-sm btn-info ml-auto">Show</button>
                                    </div>
                               
                </form>

                    @if (!$slotNumber > 0)
                        <div class="col-12 ">
                            <label>Select Staff</label><span> *</span>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <select class="select2 select2-info" id="staff" multiple="multiple"
                                    data-placeholder="Select Staff" style="width: 100%;">
                                    @foreach ($employees as $employee)
                                        <option value="{{$employee->emp_id}}">{{$employee->emp_id}} - {{$employee->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div> 
                    @endif

                        <div class="col-md-6">

                            {{-- <button class="btn btn-info btn-sm form-control" type="button"
                                onclick="numDays()">show</button> --}}
                            <!-- /.form-group -->
                            {{-- <div class="row d-flex justify-content-end">
                                <div class="col-md-4">
                                    <input class="btn btn-info form-control" type="submit" value="submit"
                                        name="submit">
                                </div>
                            </div> --}}

                        </div>

                            {{-- </form> --}}
                            {{-- date form finish --}}
                        </div>
                    </div>
                {{-- main form finish --}}

            </div>
            <div class="card-body">
                @php  
                    $fromDate=$startdate; 
                    $toDate=$enddate; 
                @endphp
                    @if(($dept=="SY" && $roster=="Y") || ($dept=="CU" && $roster=="Y") || ($dept=="TE" && $roster=="Y") || ($dept=="CA" && $roster=="Y") || ($dept=="TR" && $roster=="Y"))
                        
                        @if (count($rosterSlot) == 0)
                            <div class="col-md-12 mb-2">
                                <button href="#rosterSlotModal" id="openBtn" data-toggle="modal"
                                class="btn btn-primary pull-right">Add Roster Slot</button>
                            </div>
                        @else    
                            <div class="row">
                                    <div class="col-12  overflow-auto ">
                                        <table class="table table-hover table-bordered  selectpicker " data-live-search="true">
                                            <thead>
                                                <tr>
                                                    @foreach ($rosterSlot as $key=>$array)
                                                        @php
                                                            $slotFrom = date("h:i a", strtotime($array->from));
                                                            $slotTo = date("h:i a", strtotime($array->to));
                                                        @endphp
                                                        <th>{{ $slotFrom. " to " .$slotTo }}</th>
                                                    @endforeach
            
                                                    <th>Holiday</th>
                                                    <th>Weekend</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $fromDateSlot = date( 'Y-m-d', $fromDate );
                                                $toDateSlot = date ( 'Y-m-d', $toDate);
                                            @endphp
                                            <tbody>
                                                @for( $i = $fromDateSlot; $i <= $toDateSlot; )
                                                    @php
                                                    $thisDate = date('d F, Y(l)',strtotime($i));
                                                    // $slotNumber = count($rosterSlot);

                                                    // $i = date( 'Y-m-d', $i );
                                                    @endphp

                                                    {{-- $nexDate = date("Y-m-d", strtotime($idate." +1 day")); --}}
                                                    <tr>
                                                        <td colspan="{{ $slotNumber }}"><i>{{ $thisDate }}</i></td>
                                                    </tr>
            
                                                    {{-- <tr>
                                                        <td colspan='".count($rosterSlot)."'><b>".$idate."</b>(<i>".date("l",strtotime($idate))."</i>) &nbsp;&nbsp;&nbsp;&nbsp; to &nbsp;&nbsp;&nbsp;&nbsp; <b>".$nexDate."</b>(<i>".date("l",strtotime($nexDate))."</i>)
                                                        </td>
                                                    <tr><td colspan='".count($rosterSlot)."'><b>".date('j M, Y', strtotime($idate))."</b> (<i>".date("l",strtotime($idate))."</i>) --}}
                                            
                                                    <tr class='rowTr'>
                                            
                                                        @foreach ($rosterSlot as $slotNo=>$array)
                                                            @php
                                                            $from = date("h:i a",strtotime($array->from));
                                                            $to = date("h:i a",strtotime($array->to));
                                                            $key = $from." ".$to;
                                                            @endphp
                                                            {{-- <td class='topTips' title='<b>{{ $from }}</b> to <b>{{ $to }}</b>'> --}}
                                                            <td class='topTips' title='<b>{{ $from }}</b>'>
                                                
                                                
                                                                {{-- @if(isset($rosterData[$key][$idate]) && count($rosterData[$key][$idate])> 0)
                                                                    @php
                                                                        $staffs = $rosterData[$key][$idate];
                                                                    @endphp --}}
                                                    
                                                                    {{-- @foreach ($employees as $obj)  
                                                                        @php                                  
                                                                            // $chk = $obj->is_incharge == "Y" ? "checked" : "";
                                                                        @endphp
                                                    
                                                                        <div data-emp_id='{{$obj->emp_id}}' data-slot='{{ $slotNo }}' data-date=' {{ $i }}'>
                                                                            <input type='radio' class='radioButton'> 
                                                                            <label>{{ $obj->name }}</label> &nbsp; 
                                                                            <button type='button' class='staffDel btn btn-default btn-xs' '>
                                                                                <span class='glyphicon glyphicon-minus'></span>
                                                                            </button>
                                                                        </div>
                                                                    @endforeach --}}

                                                                {{-- @endif --}}
                                                                
                                                                @php
                                                                    $dtfrom = $i." ".$array->from;
                                                                    $dtto = strtotime($i." ".$array->from) > strtotime($i." ".$array->to) ? $thisDate." ".$array->to : $i." ".$array->to;
                                                                @endphp
                                                    
                                                                <select class='staffPicker selectpicker' data-live-search='true' data-date='{{ $i }}' data-slot=' {{ $array->slot_no }}' data-from=' {{ $dtfrom }}' data-to='{{ $dtto }}'>
                                                                <option value=''>---Select---</option>
                                                                @foreach ($employees as $emp)
                                                                {{-- @foreach ($staffArray as $emp_id=>$name) --}}
                                                                    {{-- @if(in_array($emp_id,$rosterStatus)) --}}
                                                                        <option value='{{$emp->emp_id}}'>{{ $emp->name }}</option>
                                                                    {{-- @endif --}}
                                                                @endforeach
                                                                </select>
                                                    
                                                            </td>
                                                            @endforeach
                                                    
                                                            <td>
                                                    
                                                                {{-- @if(isset($holidayData[$idate]) && count($holidayData[$idate])> 0)
                                                    
                                                                @php
                                                                    $staffs = $holidayData[$idate];
                                                                @endphp
                                                    
                                                                @foreach ($staffs as $key => $obj)
                                                    
                                                                <div data-emp_id='".$key."' data-slot='holiday' data-date='$idate'>
                                                                <label>".$obj."</label> &nbsp; 
                                                                <button type='button' class='staffDel btn btn-default btn-xs' '>
                                                                    <span class='glyphicon glyphicon-minus'></span>
                                                                </button></div>
                                                    
                                                                @endforeach
                                                                @endif --}}

                                                                {{-- @foreach ($employees as $obj)  
                                            
                                                                    <div data-emp_id='{{$obj->emp_id}}' data-slot='{{ $slotNo }}' data-date=' {{ $i }}'>
                                                                        <input type='radio' class='radioButton'> 
                                                                        <label>{{ $obj->name }}</label> &nbsp; 
                                                                        <button type='button' class='staffDel btn btn-default btn-xs' '>
                                                                            <span class='glyphicon glyphicon-minus'></span>
                                                                        </button>
                                                                    </div>
                                                                @endforeach --}}


                                                                <select class='staffPicker selectpicker' data-live-search='true' data-date='{{ $i }}' data-slot='holiday' data-from='{{ $i }}' data-to='{{ $i }}'>
                                                                    <option value=''>---Select---</option>
                                                                    @foreach ($employees as $emp)
                                                                        {{-- @foreach ($staffArray as $emp_id=>$name) --}}
                                                                        {{-- @if(in_array($emp_id,$rosterStatus)) --}}
                                                                            <option value='{{$emp->emp_id}}'>{{ $emp->name }}</option>
                                                                        {{-- @endif --}}
                                                                    @endforeach
                                                                </select>
                                                    
                                                            </td>
                                                            <td class='tokens'>
                                                                {{-- @if(isset($weekendData[$idate]) && count($weekendData[$idate]) >0)
                                                                    @foreach ($weekendData[$idate] as $emp_name)
                                                                        <div class='token'>{{ $emp_name }}</div><br>
                                                                    @endforeach
                                                                @endif --}}
                                                            </td>
                                                        </td>
                                                    </tr>
                                            
                                                    @php
                                                        $i = date("Y-m-d",strtotime($i." +1 day"));
                                                    @endphp

                                                @endfor
                                            </tbody>
                                        </table>
                                </div>
                                <div class="ml-auto">
                                    <button type="submit" id="saveBtn" class="btn btn-sm btn-info">Set Roster</button>
                                </div>
                            </div>
                        @endif

                            <!-- Roster Slot Setter Modal -->
                            <div class="modal fade" id="rosterSlotModal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">x</button>
                                            <h3 class="modal-title">Roster Slot List</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h5 class="text-center">Department: {{ $dept }}</h5>
                                            <form id='rosterSlotForm' name='rosterSlotForm' class='' method="post" action="">
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
                                                    @foreach ($rosterSlot as $ary)

                                                        @php
                                                            $from = date("h:i a", strtotime($ary->from));
                                                            $to = date("h:i a", strtotime($ary->to));
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                            <div class='tableEdit hidden'>
                                                            <select class='slotNo selectpicker form-control btn-sm' name='slotNo' data-width='100%'>
                                                            @for($i=1; $i<=10; $i++)
                                                                @if($i == $ary->slot_no) 
                                                                <option value="{{ $i }}" selected >{{ $i }}</option>
                                                                @else
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                                @endif
                                                            @endfor
                                                            </select></div>

                                                            </td><td>
                                                            <div class='tableEdit hidden bootstrap-timepicker'>                   			     	
                                                                    <input type='text' class='rosterSlotFrom form-control' name='rosterSlotFrom' value='{{$from}}' placeholder='hh:mm:ss'>
                                                                </div>

                                                            </td><td>
                                                            <div class='tableEdit hidden bootstrap-timepicker'>                   			     	
                                                                    <input type='text' class='rosterSlotTo form-control' name='rosterSlotTo' value ='{{$to}}' placeholder='hh:mm:ss'>
                                                                </div>

                                                            </td><td class='text-center'>
                                                            <div class='tableData'><a class='rosterSlotEdit btn btn-warning btn-xs' data-id='{{ $ary->id }}'>Edit</a> | <a class='rosterSlotDelete btn btn-danger btn-xs' data-id='{{ $ary->id }}' >Delete</a></div>
                                                            {{-- <div class='tableEdit hidden'><input class='updateRosterSlot btn btn-primary btn-xs' data-id='{{$ary->id}}' value='Update'></div> --}}

                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <tr id='rosterRow'>

                                                        <td><select class='selectpicker form-control btn-sm'
                                                                    name='slotNo' id='slotNo' data-width='100%'>
                                                                @for($i=1; $i<=10; $i++)
                                                                    <option value='{{ $i }}' >{{ $i }}</option>
                                                                @endfor
                                                            </select></td>
                                                        <td><div class='bootstrap-timepicker'>
                                                                <input type='text' class='form-control' id='rosterSlotFrom'
                                                                    name='rosterSlotFrom' placeholder='hh:mm:ss'>
                                                            </div></td>
                                                        <td><div class='bootstrap-timepicker'>
                                                                <input type='text' class='form-control' id='rosterSlotTo'
                                                                    name='rosterSlotTo' placeholder='hh:mm:ss'>
                                                            </div></td>
                                                        <td class="text-center"><input id='addRosterSlot' class='btn btn-primary btn-sm' value='Add' type='Submit'></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-primary">Cancel</button>
                                        </div>

                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                    @else
                        {{-- breadcumb to set roster slot for all --}}

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="card   ">
                                    <div class="card-header">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#same-time"
                                                    data-toggle="tab">Same Time for All day</a>
                                            </li>

                                            <li class="nav-item"><a class="nav-link" href="#diff-time"
                                                    data-toggle="tab">Custom Time for Different Day</a></li>
                                        </ul>
                                    </div>

                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="active tab-pane" id="same-time">
                                                <form action="{{ url('roster-set-same-time') }}" method="POST" enctype="multipart/form-data" id="sameTimeFormId">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="row">
                                                                <input type="hidden" name="type" value="same">
                                                                <input type="hidden" name="sdate" value="{{ $startdate }}">
                                                                <input type="hidden" name="edate" value="{{ $enddate }}">
                                                                <input type="hidden" name="dept_code" value="{{ $dept }}">
                                                                <input type="hidden" name="emp_ids" id="staffIds">
                                                                <div class="col-12">
                                                                    <label for="stime">Office Start Time</label>
                                                                    <input type="time" value="09:00:00" name="stime" id="stime"
                                                                        class="form-control">
                                                                </div>
                                                                <div class="col-12 mt-3">
                                                                    <label for="etime">Office End Time</label>
                                                                    <input type="time" value="18:00:00" name="etime" id="etime"
                                                                        class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        @php
                                                            $day_array = array("sun"=>"Sunday","mon"=>"Monday","tue"=>"Tuesday","wed"=>"Wednesday","thu"=>"Thursday","fri"=>"Friday", "sat"=>"Saturday");
                                                            $counter = 0;
                                                        @endphp

                                                        <div class="col-md-6 ">
                                                            <h6 class=" text-center"><strong>Select Weekend Day(s)</strong></h6>
                                                            <div class="row d-flex justify-content-center">
                                                                <div class="col-md-5">
                                                                    <div class="row" id="listWeekends">
                                                                        @foreach ($day_array as $key=>$value)
                                                                            <div class="col-12">
                                                                                <input type="checkbox" name="weekend[]" value="{{$value}}"  onclick="moreWeekend(event)" data-id="{{$key}}">
                                                                                <label for="{{$key}}">{{$value}}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <button class="btn btn-sm btn-info">Set Roster</button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Weekend limit Modal --}}

                                            <div class="modal fade" id="requestModal" role="dialog"
                                                aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form id="requestModalForm" class='form-horizontal' action="{{ url('set-roster-more-weekend') }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="type" value="same">
                                                            <input type="hidden" name="sdate" value="{{ $startdate }}">
                                                            <input type="hidden" name="edate" value="{{ $enddate }}">
                                                            <input type="hidden" name="dept_code" value="{{ $dept }}">
                                                            <input type="hidden" name="emp_ids" id="staffIdsWeekend">
                                                            <input type="hidden" id="from_time" name="stime" value="09:00:00">
                                                            <input type="hidden" id="to_time" name="etime" value="18:00:00">

                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                        aria-hidden="true">&times;</button>
                                                                <h5 class="modal-title">Send Request</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>To select more than two weekends in a week slot, send a request
                                                                    to admin selecting those weekends. Otherwise Cancel it.</p>
                                                                <div class='col-xs-12'>
                                                                    <div class="form-group" id="modalSelect">
                                                                        <div class="row">
                                                                            @foreach ($day_array as $key=>$value)
                                                                                <div class="col-12">
                                                                                    <input type="checkbox" name="weekend[]" value="{{$value}}" >
                                                                                    <label for="{{$key}}">{{$value}}</label>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class='col-xs-12'>
                                                                    <div class="form-group">
                                                                        <label>Reason</label>
                                                                        <textarea id ="reason" name="reason" placeholder="Enter ..." rows="2" class="form-control"></textarea>
                                                                    </div>
                                                                </div>


                                                                <div class='clearfix'></div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-warning" id="sendRequest">Send	Request</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- END Weekend limit modal --}}

                                            {{-- Confirm Modal --}}
                                            <div class="modal fade" id="confirmModal" role="dialog"
                                                aria-labelledby="confirmModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                            <h4 class="modal-title">Send Request</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>To select weekends more than as usual in a week slot, a request will be sent
                                                                to admin. Otherwise <mark><b>Cancel</b></mark> it.</p>
                                                            <div class="form-group">
                                                                <label>Reason</label>
                                                                <textarea id ="confirmReason" placeholder="Enter valid reason for this weekend ..." rows="2" class="form-control"></textarea>
                                                            </div>
                                                            <div class='clearfix'></div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" id="confirmCancel" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-warning" id="confirmOk">Ok</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END Confirm Modal --}}

                                            <div class="tab-pane overflow-auto" id="diff-time">
                                                <form action="{{ url('roster-set-custom-time') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <input type="hidden" name="emp_ids" id="staffIdCustom">
                                                    <table class="table table-hover table-bordered  selectpicker"
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
                                                            <input type="hidden" name="sdate" value="{{ $startdate }}">
                                                            <input type="hidden" name="edate" value="{{ $enddate }}">
                                                            <input type="hidden" name="dept_code" value="{{ $dept }}">
                                                            @for ( $i = $fromDate; $i <= $toDate; $i = $i + 86400 )
                                                                @php
                                                                    $thisDate = date( 'Y-m-d', $i );
                                                                    $day = date('l', $i);
                                                                @endphp
                                                                <tr>                                                                         
                                                                    <td style="vertical-align : middle;text-align:center;"> 
                                                                        <input type="checkbox" id="myCheck" class="leave_check" name='leave_chk[]'> 
                                                                    </td>
                                                                    <td> {{ $thisDate }} <input type="hidden" name="date[]" value="{{ $thisDate }}" class="roster_date"></td>
                                                                    <td> {{ $day }}</td>
                                                                    {{-- <div id="customTime"> --}}
                                                                        {{-- <td class="customTime"> <input type="time" name="stime[]" value="09:00:00" class="form-control"> </td>
                                                                        <td class="customTime"> <input type="time" name="etime[]" value="18:00:00"  class="form-control"> </td> --}}
                                                                        {{-- <td id="weekendData" colspan="2" style="vertical-align:middle;text-align:center; color:rgb(14, 116, 14)">Weekend</td> --}}

                                                                    <td><span class='bootstrap-timepicker'><input type='text' name='stime[]' value='$stime' readonly class='time_field stime cstime'></span><span class='holiText text-danger' hidden><b>Weekend</b></span></td>
                                                                    <td><span class='bootstrap-timepicker'><input type='text' name='etime[]' value='$etime' readonly class='time_field etime cetime'></span><span class='holiText text-danger' hidden><b>Weekend</b></span></td>

                                                                    {{-- </div> --}}

                                                                    {{-- <div id="weekendData" class="d-none">
                                                                        <td colspan="2" style="vertical-align:middle;text-align:center; color:rgb(14, 116, 14)">Weekend</td>
                                                                    </div> --}}
                                                                </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                    <div class="ml-auto">
                                                        <button type="submit" class="btn btn-sm btn-info">Set Roster</button>
                                                    </div>
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
            {{-- breadcumb finish --}}


            {{-- <div class="card-footer ml-auto">
                <button class="btn btn-sm btn-info">Set Roster</button>
            </div> --}}

        </div>
    </div>
    <!--leave request part  -->
    @php
    $ros = new stdClass();
    $wek = new stdClass();
    
    $fromDateSlot = date( 'Y-m-d', $fromDate );
    $toDateSlot = date ( 'Y-m-d', $toDate);
    
    for($i=$fromDateSlot; $i<=$toDateSlot; ) {
        $ros->$i = new stdClass();
        $wek->$i = new stdClass();

        // $i = $i + 86400;
        $i = date("Y-m-d",strtotime($i." +1 day"));
    }

    // foreach ($rosterData as $fromTo =>$ary){
    //     foreach ($ary as $date=>$AryOfObj){
    //         $data = new stdClass();
    //         foreach ($AryOfObj as $obj){
    //             $data->from = $obj->stime;
    //             $data->to = $obj->etime;
    //             $data->staff[]=  $obj->emp_id;
    //         }
    //         $slotTime = date("H:i:s", strtotime(substr($fromTo, 0,8)));
    //         $slotNo;
    //         foreach ($rosterSlot as $sn=>$ary){
    //             if($slotTime == $ary['from']){
    //                 $slotNo = $sn;
    //                 break;
    //             }
    //         }

    //         $ros->$date->$slotNo = $data;
    //         $ros->$date->weekend = isset($weekendData[$date])? $weekendData[$date] : array();
    //         if(isset($holidayData[$date])){
    //         $ros->$date->holiday = [
    //             'from' => $date,
    //             'to' => $date,
    //             'staff' => array_keys($holidayData[$date])
    //         ];
    //     }
    //         //$ros[$date]['weekend'] = isset($weekendData[$date])? $weekendData[$date] : array();
    //     }
    // }

    // foreach ($weekendData as $date=>$ary){
    //     $data = new stdClass();
    //     foreach ($ary as $eid=>$name){
    //         $data->$eid = $name;
    //     }
    //     $wek->$date = $data;
    // }

    //print_r($wek);
    //echo "<pre>";
    //print_r($ros);
    //echo "</pre>";
@endphp
</div>




@endsection
<!-- end editing-->
@endsection
@endsection
@endsection


@section('script')
@parent

<script>
    $(function () {

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })


        $('#staff').change(function(e) {
           $('#staffIds').val($(e.target).val());
        }); 


        $('#staff').change(function(e) {
        $('#staffIdCustom').val($(e.target).val());
        }); 


        $('#staff').change(function(e) {
        $('#staffIdsWeekend').val($(e.target).val());
        }); 


        // $("#rosterSlotEmployee").change(function(){
        // var selectedEmployee = $(this).children("option:selected").text();
        // // var nonSelectedEmployee = !$(this).children("option:selected").text();
        // // alert(nonSelectedEmployee[0]);
        // if(selectedEmployee!=""){
        //     alert('UnSelected');
        // }
        // $('#selectedEmpList').val(selectedEmployee);
        // });

    })


    // var selected = [];
    // var noselected = [];

    // $(document).on('click', '#rosterSlotEmployee', function (){
    //     $.each($('#rosterSlotEmployee option'), function (key, value) {

    //         if (!$(this).prop('selected')) {
    //             noselected[key] = $(this).text();
    //             // alert($(this).text());
    //             console.log('Non-selected ', noselected);
    //             $('#NonSelectedEmpList').val(noselected);

    //         } else {
    //             selected[key] = $(this).text();
    //             //alert($(this).val());
    //             $('#selectedEmpList').val(selected);

    //         }
    //     });
    // });


    $('#rosterSlotEmployee').on('change', function(){

    var idsArray = new Array();
    var str = "";
    var i=0;

    $("#rosterSlotEmployee :selected").each(function () {
        if($(this).val() == 'all'){
            $('#rosterSlotEmployee').selectpicker('deselectAll');
            $('#rosterSlotEmployee').selectpicker('val', 'all');
        }
    });

    $("#rosterSlotEmployee :selected").each(function () {
        if($(this).val() == 'all'){
            $("#rosterSlotEmployee option").each(function () {
                if($(this).val() != 'all'){
                    idsArray[i] = $(this).val();
                    i++;
                }
            });
        } else {
            idsArray[i] = $(this).val();
            str += "<div class='token'>"+$(this).text()+"</div>";
            i++;
        }

    });


    // $(".staffIds").val(idsArray.join(','));

    str = "<div class='col-md-9'>"+str+"</div>";
    $(".tokens").html(str);
    });



    function moreWeekend(e){
        
        var form = $("#sameTimeFormId");
        // alert($(this).attr("selectWeekend"));
        var checkboxes = $("input:checkbox", form);
        var x = checkboxes.filter(':checked').length;
        let currentCheckValue = e.target.value;
        $('#requestModalForm input[type=checkbox]').each(function(){
            if ( this.value == currentCheckValue){
                this.setAttribute("checked", "checked");
            }
        });
        if (x > 2){
            console.log(document.querySelector('#listWeekends'));
            $(e.target).prop("checked", false);
            $('#requestModal').modal('show');
        }
    }


    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000); 

    // const editContact = document.querySelector('#checkBtn');
    // const intialDivContact = document.querySelectorAll('.customTime');
    // const editableDivContact = document.querySelector('#weekendData');

    // editableDivContact.style.display = 'none';
    // editContact.addEventListener('click', () => {
        
    //     if(intialDivContact.style.display === 'none'){
    //         intialDivContact.style.display = 'block';
    //         editableDivContact.style.display = 'none';
    //     }else {
    //         intialDivContact.style.display = 'none';
    //         editableDivContact.style.display = 'block';
    //     }
    // });
</script>


<script type="text/javascript">
	$(document).ready(function(e) {

		var start = "<?php echo $fromDate?>";
		var end = "<?php echo $toDate?>";
		var selDept = "<?php echo $dept?>";
		var staffs = '<?php echo json_encode($employees); ?>';
		var mLimit = 2;
		var reason;

		var dataObj = '<?php echo json_encode($ros)?>';
		var weekendObj = '<?php echo json_encode($wek)?>';
		dataObj.toAdmin = false;

		// console.log(dataObj);
		//alert(dataObj);

		//generate data object with date keys
		var setOfDate = new Array();
		var tmpAry = new Array();
		startDate = new Date(start);
		endDate = new Date(end);

		while(startDate <= endDate){

			var dayN = startDate.getDay();
			var dt = startDate.toISOString().slice(0,10);

			tmpAry[tmpAry.length] = dt;

			if(dayN == 6 || (startDate.getTime() === endDate.getTime())){
				setOfDate[setOfDate.length] = tmpAry;
				tmpAry = new Array();
			}

			var newDate = startDate.setDate(startDate.getDate() + 1);
			startDate = new Date(newDate);
		}



		$('#leaveDate, #leaveStart, #leaveEnd').datepicker({
			format: 'yyyy-mm-dd'
		});
		$('#leaveDate').on('changeDate', function(ev){
			$(this).datepicker('hide');
		});


		//$(".tips").tipsy({html: true, gravity: 'e',delayOut:10,clsStyle: 'blue'});
		//$(".topTips").tipsy({html: true, gravity:'s', delayOut:10, clsStyle: 'blue'});
		//$(".leftTips").tipsy({html: true, gravity:'e', delayOut:10,clsStyle: 'blue',css: {"max-width": 300+"px"}});

		$(".staffPicker").change(function(){
			var emp_id = $(this).val();
			if(emp_id=="") return;

			var from = $(this).attr('data-from');
			var to = $(this).attr('data-to');
			var date = $(this).attr('data-date');
			var slot = $(this).attr('data-slot');

			if(dataObj[date] == undefined){
				var staff = [emp_id];
				var aObj = new Object();
				aObj.toAdmin = false;
				aObj[slot] = {'from':from, 'to':to, 'staff':staff};
				dataObj[date] = aObj;
			}else {

				var aObj =  dataObj[date];

				if(aObj[slot] == undefined){
					var staff = [emp_id];
					var slotObj = {'from':from, 'to':to, 'staff':staff};
					aObj[slot] = slotObj;

				}else{
					slotObj = aObj[slot];
					var staff =  slotObj.staff;

					var index = $.inArray(emp_id, staff);
					if(index == -1){
						staff.push(emp_id);
					}else{
						return;
					}
					slotObj.staff = staff;
				}
			}

			// remove from RmoveList
			slotObj = aObj[slot];


			if(slotObj.removeStaff !== undefined  && slotObj.removeStaff.length>0){
				var removeStaff = slotObj.removeStaff;

				var index = removeStaff.indexOf(emp_id);
				if (index >= 0) {
					removeStaff.splice( index, 1 );
				}
			}

			// Add weekend list
			var newObj = jQuery.extend(true, {}, staffs);
			//var aObj =  dataObj[date];

			for(slotKey in aObj){
				slotObj = aObj[slotKey];
				var staff =  slotObj.staff;

				for(key in staff){
					delete newObj[staff[key]];
				}
			}
			//dataObj
			weekendObj[date] = newObj;
			aObj.weekend = newObj;

			var parentTr = $(this).parents('.rowTr');
			appendWeekend(parentTr, date);
			
			if(slot === 'holiday') {

				var html = "<div data-date='"+date+"' data-slot='holiday' data-emp_id='"+emp_id+"'><label>"+staffs[emp_id]+"</label> &nbsp; \
		<button type='button' class='staffDel btn btn-default btn-xs' >\
      		<span class='glyphicon glyphicon-minus'></span>\
        </button></div>";

			} else {

				var html = "<div data-date='"+date+"' data-slot='"+slot+"' data-emp_id='"+emp_id+"'><input type='radio' class='radioButton' name='"+date+":"+slot+"'><label>"+staffs[emp_id]+"</label> &nbsp; \
		<button type='button' class='staffDel btn btn-default btn-xs' >\
      		<span class='glyphicon glyphicon-minus'></span>\
        </button></div>";

			}

			

			$(this).before(html);
			$(this).val("");
			console.log(dataObj);
		});

		$(document).on("click",".staffDel",function(){

			if(confirm("Do you want to delete?")) {

				var parentDiv = $(this).parent();
				var emp_id = parentDiv.attr("data-emp_id");
				var date = parentDiv.attr("data-date");
				var slot = parentDiv.attr("data-slot");

				// delete staff Id from object
				var aObj =  dataObj[date];
				var slotObj = aObj[slot];
				var staff =  slotObj.staff;
				var index = staff.indexOf(emp_id);
				if (index >= 0) {
					staff.splice( index, 1 );
				}


				//delete from database
				if(slotObj.removeStaff == undefined){
					slotObj.removeStaff = new Array();
				}
				var removeStaff = slotObj.removeStaff;
				var index = $.inArray(emp_id, removeStaff);
				if(index == -1){
					removeStaff.push(emp_id);
				}

				// Add weekend list
				var newObj = jQuery.extend(true, {}, staffs);

				for(slotKey in aObj){
					slotObj = aObj[slotKey];
					var staff =  slotObj.staff;

					for(key in staff){
						delete newObj[staff[key]];
					}
				}
				weekendObj[date] = newObj;
				aObj.weekend = newObj;

				var parentTr = $(this).parents('tr.rowTr');
				parentDiv.remove();
				appendWeekend(parentTr, date);

			}
		});

		$(document).on("click",".radioButton",function(){
			var parentDiv = $(this).parent();
			var emp_id = parentDiv.attr("data-emp_id");
			var date = parentDiv.attr("data-date");
			var slot = parentDiv.attr("data-slot");

			var aObj =  dataObj[date];
			var slotObj = aObj[slot];
			slotObj.inCharge = emp_id;

			//console.log(dataObj);

		});

		$('button#saveBtn').click(function(){

			/*var toAdmin = checkValidity();

			 if(toAdmin){
			 $('#confirmModal').modal('show');
			 }else{
			 sendData();
			 }*/

			sendData();

		});

		function checkValidity(){

			for(empId in staffs){

				for(k in setOfDate){
					var count = 0;
					var kx = parseInt(k);
					var innerSet = setOfDate[kx];
					var prvSet = setOfDate[kx-1];
					var nxtSet = setOfDate[kx+1];

					for(key in innerSet){

						var dateVal = innerSet[key];
						var weekend = weekendObj[dateVal];
						var isWeekend = (weekend[empId] != undefined);

						if(!$.isEmptyObject(weekend) && isWeekend){
							//weekend

							if(key==0 && prvSet != undefined){
								//var prvFlag = true;
								var countprv = 0;
								var countIn = 0;

								for(var t=0; t<mLimit; t++){
									//prev Set
									var x = (prvSet.length - (1+t));
									if(x < 0)
										break;

									var dateVal2 = prvSet[x];
									var weekend2 = weekendObj[dateVal2];

									var isPrvWeekend = (weekend2[empId] != undefined);

									if(isPrvWeekend){
										countprv++;
									}else {
										break;
									}
								}

								for(var i=0; i<mLimit; i++){
									//inner Set
									var dateVal3 = innerSet[i];
									if(dateVal3 == undefined){
										break;
									}

									var weekend3 = weekendObj[dateVal3];
									var isInnerWeekend = (weekend3[empId] != undefined);

									if(isInnerWeekend){
										countIn++;
									}else {
										break;
									}
								}

								var sum = countprv+countIn;
								if(sum <= mLimit){
									countprv=0;
								}

								count += countprv;

							} else if( key == (innerSet.length-1) && nxtSet != undefined){
								//next set
								var countnxt = 0;
								var countIn = 0;

								for(var t=0; t<mLimit; t++){
									//Next Set
									if(t >= nxtSet.length)
										break;
									var dateVal4 = nxtSet[t];
									var weekend4 = weekendObj[dateVal4];

									var isNxtWeekend = (weekend4[empId] != undefined);

									if(isNxtWeekend){
										countnxt++;
									}else {
										break;
									}
								}

								for(var i= (innerSet.length-1); i>(innerSet.length-1-mLimit); i--){
									//inner Set
									if(i<0)
										break;
									var dateVal5 = innerSet[i];
									var weekend5 = weekendObj[dateVal5];
									var isNxtWeekend = (weekend5[empId] != undefined);

									if(isNxtWeekend){
										countIn++;
									}else {
										break;
									}
								}

								var sum = countnxt+countIn;
								if(sum <= mLimit){
									countnxt=0;
								}
								count += countnxt;
							}

							count++;

							if(count > mLimit){
								dataObj.toAdmin = true;
								return true;
							}
						}

					}

				}//setOfDate
			}//empID

			return false;
		}

		$('button#confirmOk').on('click', function(){

			var txt = $(this).parents('.modal-content').find('#confirmReason').val();

			if(txt.length<10){
				alert("Please enter a valid reason(in atleast 10 words).");
				return;
			}else{
				$('#confirmModal').modal('hide');
				reason = txt;

				sendData();
			}
		});

		$('#confirmModal').on('hidden.bs.modal', function(){

			$(this).find('#confirmReason').val('');
		});

		//Roster Slot Related
		$('#rosterSlotFrom, #rosterSlotTo, .rosterSlotFrom, .rosterSlotTo').timepicker({
			defaultTime: false,
			showMeridian: false,
			minuteStep: 5,
			showSeconds: true,
			disableFocus: true,
			modalBackdrop: true,
			template: 'dropdown'
		});

		$.validator.addMethod("time", function(value, element) {
			return this.optional(element) || /^(([0-1]?[0-9])|([2][0-3])):([0-5]?[0-9])(:([0-5]?[0-9]))?$/i.test(value);
		}, "Please enter a valid time.");

		$("#rosterSlotForm").validate({
			rules: {
				slotNo: {
					required: true,
				},
				rosterSlotFrom: "required time",
				rosterSlotTo: "required time",
			},
			submitHandler : function(event) {
				//var it = $(this);
				var rosterSlotModal = $('#rosterSlotModal');
				var slotNo = rosterSlotModal.find('#slotNo').val();
				var from = rosterSlotModal.find('#rosterSlotFrom').val();
				var to = rosterSlotModal.find('#rosterSlotTo').val();
				$.ajax({
					type:"POST",
                    url : " ",
					data: {slotNo:slotNo,rosterSlotFrom:from,rosterSlotTo:to},
					dataType:"json",
					success:function(response) {
						if(response.status) {

							var part1 = "<tr><td>\
                          		                    <div class ='tableData'>"+slotNo+"</div><div class='tableEdit hidden'>\
                          	                            <select class='slotNo selectpicker form-control btn-sm' name='slotNo' data-width='100%'>";

							var option ="";
							for(var i=1; i<=10; i++) {
								if(i == slotNo)	option += "<option value='"+i+"' selected >"+i+"</option>";
								else option += "<option value='"+i+"'>"+i+"</option>";
							}

							var part2 = "</select></div></td>\
                                    		<td>\
                      			                <div class='tableData'>"+from+"</div>\
                                    		    <div class='tableEdit hidden bootstrap-timepicker'>\
                                    		        <input type='text' class='rosterSlotFrom form-control' name='rosterSlotFrom' value='"+from+"' placeholder='hh:mm:ss'>\
                                    		    </div>\
                                    		</td>\
                                    		<td>\
                                        		<div class='tableData'>"+to+"</div>\
                                        		<div class='tableEdit hidden bootstrap-timepicker'>\
                                        			<input type='text' class='rosterSlotTo form-control' name='rosterSlotTo' value ='"+to+"' placeholder='hh:mm:ss'>\
                                        		</div>\
                                    		</td>\
                                    		<td class='text-center'>\
                                    		<div class='tableData'>\
                                        		<a class='rosterSlotEdit btn btn-warning btn-xs' data-id='"+response.insert_id+"' >Edit</a> | <a class='rosterSlotDelete btn btn-danger btn-xs' data-id='"+response.insert_id+"' >Delete</a></div>\
                                        		<div class='tableEdit hidden'><input type class='updateRosterSlot btn btn-primary btn-xs' data-id='"+response.insert_id+"' value='Update'></div>\
                                    		</td>\
                                    		</tr>";
							var myRow = part1 + option + part2;

							$("#rosterRow").before(myRow);
							$('.slotNo').selectpicker('refresh');
							rosterSlotModal.find('#rosterSlotFrom').val("");
							rosterSlotModal.find('#rosterSlotTo').val("");
							//rosterSlotModal.find('#SlotNo option:selected').prop("selected", false);


							$('.rosterSlotDelete').unbind("click").bind("click",function(){
								bindDeleteEvent(this);
							});

							$('.updateRosterSlot').unbind("click").bind("click",function(){
								bindUpdateEvent(this);
							});

							$('.rosterSlotFrom, .rosterSlotTo').timepicker({
								defaultTime: false,
								showMeridian: false,
								minuteStep: 5,
								showSeconds: true,
								disableFocus: true,
								modalBackdrop: true,
								template: 'dropdown'
							});

						} else {
							alert(response.msg);
							return;
						}
					}
				});
			}
		});

		$('.rosterSlotDelete').unbind("click").bind("click",function(){
			bindDeleteEvent(this);
		});

		var parentRow;
		$("#rosterSlotModal").on("click",'.rosterSlotEdit',function(){
			parentRow = $(this).parent().parent().parent();

			parentRow.find('.tableData').addClass('hidden');
			parentRow.find('.tableEdit').removeClass('hidden');

			return;
		});

		$('#rosterSlotModal').on('hidden.bs.modal', function () {
			$(this).find('.tableData').removeClass('hidden');
			$(this).find('.tableEdit').addClass('hidden');

			$(this).find('#rosterSlotFrom').val("");
			$(this).find('#rosterSlotTo').val("");
		});

		$('.updateRosterSlot').unbind("click").bind("click",function(){
			bindUpdateEvent(this);
		});

		function sendData(){
			//console.log(dataObj);
			$.ajax({
				type:"POST",
                url : " ",
				data:{"dataObj" : JSON.stringify(dataObj), 'weekendObj':JSON.stringify(weekendObj), 'selDept':selDept, 'reason':reason},
				dataType:"json",
				success:function(response) {
					if(response.status) {
						window.location.href = "";
					} else {
						alert(response.msg);
						return;
					}
				}
			});
		}

		function bindUpdateEvent(it){

			parentRow = $(it).parent().parent().parent();
			var rosterId = $(it).attr('data-id');
			var slotNo = parentRow.find('.slotNo').val();
			var from = parentRow.find('.rosterSlotFrom').val();
			var to = parentRow.find('.rosterSlotTo').val();

			$.ajax({
				type:"POST",
                url :"",
				data:{rosterId:rosterId,
					slotNo:slotNo,
					rosterSlotFrom:from,
					rosterSlotTo:to},
				dataType:"json",
				success:function(response) {
					if(response.status) {
						parentRow.find("td:nth-child(1) .tableData").text(slotNo);
						parentRow.find("td:nth-child(2) .tableData").text(from);
						parentRow.find("td:nth-child(3) .tableData").text(to);

						$('#rosterSlotModal').find('.tableData').removeClass('hidden');
						$('#rosterSlotModal').find('.tableEdit').addClass('hidden');
					} else {
						alert(response.msg);
						return;
					}
				}
			});
		}

		function bindDeleteEvent(it){
			var rosterId = $(it).attr('data-id');

			$.ajax({
				type:"POST",
                url : "",
				data:{},
				dataType:"json",
				success:function(response) {
					if(response.status) {
						$(it).parents('tr').remove();
					} else {
						alert(response.msg);
						return;
					}
				}
			});
		}
		function appendWeekend(parentTr, date) {
			//console.log(parentTr);
			newObj = weekendObj[date];
			var str = "";
			for(key in newObj){
				str += "<div class='token'>"+newObj[key]+"</div><br>";
			}
			parentTr.find('.tokens').html(str);
		}

	});

</script>


@endsection

@endsection