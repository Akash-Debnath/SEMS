@extends('index')
@section('title', '| Today Employee')
@section('wrapper')
    @parent

    {{-- @author:Tahrim Kabir
@Edited: Akash Chandra Debnath [script add, code formatting]
@Behaviour: To show current date present employee list at a glance or can search department-wise --}}

@section('content-wrapper')
    @parent
@section('content-header')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Today's Employee</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                        <li class="breadcrumb-item"><a href="#">Employee</a></li>
                        <li class="breadcrumb-item active">Today's Employee</li>
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
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <!-- searchbox via select -->
                        <div class="col-md-3">
                            <form action="">
                                <select id="dept" class="select2 form-control " style="width: 100%;"
                                    data-placeholder="Select Department">
                                    <option value="" selected> Search by department </option>
                                    @foreach ($dept as $d)
                                        <option data-state="{{ $d->dept_code }}" value="{{ $d->dept_code }}">
                                            {{ $d->dept_name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </div>

                        <div class="col-md-3">
                            <select id="emp" class="select2 form-control " style="width: 100%;"
                                data-placeholder="Select Staff">
                                <option value="" selected> Search by Staff or Id </option>
                                @foreach ($employee as $e)
                                    <option value="{{ $e->emp_id }}">{{ $e->emp_id }}--{{ $e->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hover table-bordered table-responsive-sm selectpicker"
                        data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Office Time</th>
                                <th>In Time </th>

                            </tr>
                        </thead>
                        <tbody id="staff">
                            @php
                                $found = false;
                                $i = 1;
                                $date = date('Y-m-d');
                            @endphp

                            @foreach ($employee as $e)
                                @php   $stime=array();    @endphp
                                <tr data-state="{{ $e->Department ? $e->Department->dept_code : '' }}">
                                    @foreach ($e->iorecordDate as $r)
                                        @php array_push($stime,strtotime($r->stime)); @endphp
                                    @endforeach
                                    @if (!empty($stime))
                                        <td>{{ $i }}</td>
                                        <td>{{ $e->emp_id }} </td>
                                        <td>{{ $e->name }}</td>
                                        <td>{{ $e->Department ? $e->Department->dept_name : '' }}</td>
                                        <td>{{ $e->userDesignation ? $e->userDesignation->designation : '' }}</td>
                                        <td>
                                            
                                            {{-- @foreach ($e->nonSlotedByDate as $non)
                                                @if ($non->ddate == $date)
                                                    @php $found=true; @endphp
                                                    {{ date('h:i:s a', strtotime($non->start_time)) }}
                                                @else
                                                    @php $found=false; @endphp
                                                @endif
                                            @endforeach --}}
                                                @if ($e->roster == 'Y')
                                                    @foreach ($e->rostering as $r)
                                                        @php $start = date('Y-m-d',strtotime($r->stime)) @endphp
                                                        @if ($start == date('Y-m-d'))
                                                            {{ date('h:i:s a', strtotime($r->stime)) }} 
    
                                                        @endif
                                                    @endforeach
                                                @elseif($e->roster == 'N')
                                                    {{ date('h:i:s a', strtotime($defaultTime->stime)) }}
                                                @endif
                                            
                                        </td>
                                        <td>
                                        {{-- @if($found == false) --}}
                                            @if ($e->roster == 'N')
                                                @if ($defaultWeekend->option_value == 'N')
                                                    @if (min($stime) <= strtotime($defaultTime->stime . '+ 15 minutes'))
                                                        <span class="text-info">{{ date('h:i:s a', min($stime)) }}</span>
                                                    @else
                                                        <span class="text-danger">{{ date('h:i:s a', min($stime)) }}</span>
                                                    @endif
                                                @else
                                                    <span class="txt-blue">{{ date('h:i:s a', min($stime)) }}</span>
                                                @endif
                                            @elseif($e->roster == 'Y')
                                                @php $haveRS = false; @endphp
                                                @foreach ($e->rostering as $r)
                                                    @php  $start = date('Y-m-d',strtotime($r->stime));  @endphp
                                                    @if ($start == date('Y-m-d'))
                                                        @php  $startTime = date('h:i:s a', strtotime($r->stime)) @endphp
                                                        @if (min($stime) <= strtotime($startTime))
                                                            <span
                                                                class="text-info">{{ date('h:i:s a', min($stime)) }}</span>
                                                            @php $haveRS = true; @endphp
                                                        @else
                                                            @php $haveRS = false; @endphp
                                                        @endif
                                                    @else
                                                    @endif
                                                @endforeach
                                                @if ($haveRS == false)
                                                    <span class="txt-blue">{{ date('h:i:s a', min($stime)) }}</span>
                                                @endif
                                            @endif
                                        {{-- @endif --}}
                                        </td>
                                    @endif

                                </tr>
                                @php $i=$i+1; @endphp
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="card-footer overflow-auto ">
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
@endsection
@endsection
@endsection



@section('script')
@parent
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
<script>
    var $selectState = $('#dept'),
        $selectDistrict = $('#staff'),
        $options = $selectDistrict.find('tr');

    $selectState.on('change', function() {
        $selectDistrict.html($options.filter('[data-state="' + this.value + '"]'));
    }).trigger('change');
</script>

@endsection
@endsection
