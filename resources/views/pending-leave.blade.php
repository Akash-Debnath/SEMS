@extends('index')
@section('title', '|  Requests')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Pending Request</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                    <li class="breadcrumb-item"><a href="#">Request pending</a></li>
                    <li class="breadcrumb-item active">Pending Request</li>
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
@if(Auth::user()->can('leave-approval-approve-refuse'))
    {{-- Approval Request --}}
    <div class="col-12  ">
        <div class="card card-info">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0 text-center ">
                            Approval Request: @php print_r(count($approval)); @endphp
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- to print emp card --}}
    <div class="col-12 mb-5">
        <div class="row d-flex justify-content-center">

            @foreach($approval as $a)
            @foreach($employee as $e)
             @if($e->emp_id == $a->emp_id)
            {{-- start from here --}}
            <div class="col-md-3">
                <div class="card">

                    <div class="card-body gap-card-header">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0">
                                  {{$a->emp_id}}
                                </p>
                                <a href="http://">{{$e->name}}</a>
                                <p class="mb-0">{{$e->userDesignation ? $e->userDesignation->designation : ''}}</p>
                                <p class="mb-0">{{$e->department ? $e->department->dept_name : ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 bg-info">
                                <p class="mb-0  text-center">Leave Brief Info</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="type">Leave Type</label></div>
                                    <div class="col-7"><p class="mb-0" id="type">
                                        @foreach($option as $o)
                                        @if($a->leave_type == $o->option_code)
                                        {{$o->option_value}}
                                        @endif
                                        @endforeach</p>    
                                    </div>
                                </div>
                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}
                                <div class="row">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">from</label></div>
                                    <div class="col-7 "><p class="mb-0" id="from">{{$a->leave_start}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">To</label></div>
                                    <div class="col-7"><p class="mb-0" id="to">{{$a->leave_end}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="day">Day</label></div>
                                    <div class="col-7"><p class="mb-0" id="day">{{$a->period}}</p></div>
                                </div>

                            </div>

                        </div>
                        <div class="row ">

                            <div class="col-12 d-flex d-flex justify-content-center">
                                <a type="button" href={{ "view-leave/". $a->emp_id."/".$a->id."/".$a->leave_start}} class="btn  btn-sm btn-primary">Request Details</a>
                                <a type="button" href={{ "view-leave-list/". $a->emp_id."/".$a->leave_start}} class="btn  btn-sm btn-warning ml-2">Leave List</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- ///end one card --}}
            @endif
            @endforeach
        @endforeach
        </div>
    </div>
    {{-- //Approval Request --}}
@endif

@if(Auth::user()->can('leave-verification-verify-refuse'))
    {{-- Verification Request --}}
    <div class="col-12 ">
        <div class="card card-info">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0 text-center ">
                            Verification Request: @php print_r(count($verify)); @endphp
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- to print emp card --}}
    <div class="col-12 mb-5">
        <div class="row d-flex justify-content-center">

            @foreach($verify as $v)
            @foreach($employee as $e)
             @if($e->emp_id == $v->emp_id)
            {{-- start from here --}}
            <div class="col-md-3">
                <div class="card">

                    <div class="card-body gap-card-header">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0">
                                    {{$v->emp_id}}
                                </p>
                                <a href="http://">{{$e->name}}</a>
                                <p class="mb-0">{{$e->userDesignation->designation}}</p>
                                <p class="mb-0">{{$e->Department ? $e->Department->dept_name : ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 bg-info">
                                <p class="mb-0  text-center">Leave Brief Info</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="type">Leave Type</label></div>
                                    <div class="col-7"><p class="mb-0" id="type">
                                        @foreach($option as $o)
                                        @if($v->leave_type == $o->option_code)
                                        {{$o->option_value}}
                                        @endif
                                        @endforeach</p></div>
                                </div>
                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}
                                <div class="row">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">from</label></div>
                                    <div class="col-7 "><p class="mb-0" id="from">{{$v->leave_start}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">To</label></div>
                                    <div class="col-7"><p class="mb-0" id="to">{{$v->leave_end}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="day">Day</label></div>
                                    <div class="col-7"><p class="mb-0" id="day">{{$v->period}}</p></div>
                                </div>

                            </div>
                        </div>
                        <div class="row ">

                            <div class="col-12 d-flex justify-content-center">
                                <a href={{ "view-leave-list/". $v->emp_id."/".$v->leave_start}} type="button" class="btn  btn-sm btn-primary">Leave List</a>
                                <a href={{ "view-leave/". $v->emp_id."/".$v->id."/".$v->leave_start}} type="button" class="btn  btn-sm btn-warning ml-2">Request Detail</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- ///end one card --}}
            @endif
            @endforeach
        @endforeach
        </div>
    </div>
    {{-- //Verification Request --}}
@endif

@if(Auth::user()->can('leave-cancellation-approve-refuse-head')||Auth::user()->can('leave-cancellation-approve-refuse-admin'))
     {{-- cancellation Request Request --}}
     <div class="col-12 ">
        <div class="card card-info">
            <div class="card-header">
                <div class="row">
                    <div class="col-12">
                        <h5 class="mb-0 text-center ">
                            cancellation  Request: @php print_r(count($cancel)); @endphp
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- to print emp card --}}
    <div class="col-12 mb-5">
        <div class="row d-flex justify-content-center">

        @foreach($cancel as $c)
           @foreach($employee as $e)
           @if($e->emp_id==$c->emp_id)
            {{-- start from here --}}
            <div class="col-md-3">
                <div class="card">

                    <div class="card-body gap-card-header">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0">
                                   {{$c->emp_id}}
                                </p>
                                <a href="http://">{{$e->name}}</a>
                                <p class="mb-0">{{$e->userDesignation->designation}}</p>
                                <p class="mb-0">{{$e->department ? $e->department->dept_name : ''}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 bg-info">
                                <p class="mb-0  text-center">Leave Brief Info</p>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="type">Leave Type</label></div>
                                    <div class="col-7"><p class="mb-0" id="type">
                                        @foreach($option as $o)
                                        @if($c->leave_type == $o->option_code)
                                        {{$o->option_value}}
                                        @endif
                                        @endforeach</p>    
                                    </div>
                                </div>
                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}
                                <div class="row">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">from</label></div>
                                    <div class="col-7"><p class="mb-0" id="from">{{$c->leave_start}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="from">To</label></div>
                                    <div class="col-7"><p class="mb-0" id="to">{{$c->leave_end}}</p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5 d-flex justify-content-end"> <label for="day">Day</label></div>
                                    <div class="col-7"><p class="mb-0" id="day">{{$c->period}}</p></div>
                                </div>

                            </div>
                        </div>
                        <div class="row ">

                            <div class="col-12 d-flex justify-content-center">
                                <a type="button" class="btn  btn-sm btn-primary">Leave List</a>
                                <a type="button" class="btn  btn-sm btn-warning ml-2" href={{ "view-leave/". $c->emp_id."/".$c->id."/".$c->leave_start}}>Request Detail</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            {{-- ///end one card --}}
            @endif
            @endforeach
        @endforeach
        </div>
    </div>
    {{-- //cancellation Request --}}
@endif
</div>



@endsection
<!-- end editing-->
@endsection
@endsection
@endsection

@section('script')
@parent
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection


<!-- jquery for search bar purposes -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


@endsection