@extends('index')
@section('title', 'Late Early pending requests')
@section('wrapper')
    @parent
    {{-- @section('preloader')
@parent
@endsection

@section('main-header')
@parent
@endsection

@section('main-sidebar')
@parent
@endsection --}}

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
                        <li class="breadcrumb-item"><a href="#">Req_pending</a></li>
                        <li class="breadcrumb-item active">Pending Request</li>
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
@if(Auth::user()->can('missing-attendance-approval-approve-refuse'))
        {{-- Approval Request --}}
        <div class="col-12  ">
            <div class="card card-info">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0 text-center ">
                                Approval Request: {{$approve->count()}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- to print emp card --}}
        <div class="col-12 mb-5">
            <div class="row d-flex justify-content-center">
                @foreach ($employee as $e)
                    @foreach ($approve as $a)
                        @if ($e->emp_id == $a->emp_id)
                            {{-- start from here --}}
                            <div class="col-md-3">
                                <div class="card">

                                    <div class="card-body gap-card-header">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="mb-0">
                                                    {{ $a->emp_id }}
                                                </p>
                                                <a href="http://">{{ $e->name }}</a>
                                                <p class="mb-0">{{ $e->userDesignation->designation }}</p>
                                                <p class="mb-0">{{ $e->Department->dept_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 bg-info">
                                                <p class="mb-0  text-center">Leave Brief Info</p>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12 ">
                                                <div class="row">
                                                    <div class="col-5 d-flex justify-content-end"> <label for="from">In
                                                            Time</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="from"><b>:&nbsp;</b>{{ $a->in }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label for="from">Out
                                                            Time</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="to"><b>:&nbsp;</b>{{ $a->out }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label
                                                            for="reason">Reason</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="reason"><b>:&nbsp;</b>{{ $a->reason }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label
                                                            for="type">Date</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="type"><b>:&nbsp;</b>{{ $a->date }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}




                                            </div>

                                        </div>
                                        <div class="row  ">

                                            <div class="col-12 d-flex justify-content-center">
                                                <a href={{ asset('approve-att-req/' . $a->id) }}
                                                    class="btn  btn-sm btn-primary ">Approve</a>

                                            
                                                <a href={{asset('delete-missing-attendance/'.$a->id)}}
                                                    class="btn  btn-sm btn-warning ml-2">Refuse</a>
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
@if(Auth::user()->can('missing-attendance-verification-approve-refuse'))
        {{-- Verification Request --}}
        <div class="col-12 ">
            <div class="card card-info">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-0 text-center ">
                                Verification Request: {{$verify->count()}}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- to print emp card --}}
        <div class="col-12 mb-5">
            <div class="row d-flex justify-content-center">
                @foreach ($employee as $e)
                    @foreach ($verify as $v)
                        @if ($e->emp_id == $v->emp_id)
                            {{-- start from here --}}
                            <div class="col-md-3">
                                <div class="card">

                                    <div class="card-body gap-card-header">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="mb-0">
                                                    {{ $v->emp_id }}
                                                </p>
                                                <a href="http://">{{ $e->name }}</a>
                                                <p class="mb-0">{{ $e->userDesignation->designation }}</p>
                                                <p class="mb-0">{{ $e->Department->dept_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 bg-info">
                                                <p class="mb-0  text-center">Leave Brief Info</p>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-12 ">

                                                <div class="row">
                                                    <div class="col-5 d-flex justify-content-end"> <label for="from">In
                                                            Time</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="from"><b>:&nbsp;</b>{{ $v->in }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label for="from">Out
                                                            Time</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="to"><b>:&nbsp;</b>{{ $v->out }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label
                                                            for="reason">Reason</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="reason"><b>:&nbsp;</b>Will be late to
                                                            come in office</p>
                                                    </div>
                                                </div>
                                                <div class="row ">
                                                    <div class="col-5 d-flex justify-content-end"> <label
                                                            for="type">Date</label></div>
                                                    <div class="col-7">
                                                        <p class="mb-0" id="type">
                                                            <b>:&nbsp;</b>{{ $v->date }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}



                                            </div>
                                        </div>
                                        <div class="row ">

                                            <div class="col-12 d-flex justify-content-center">
                                                <a href={{ asset('verify-att-req/' . $v->id) }}
                                                    class="btn  btn-sm btn-primary ">Verify</a>
                                           
                                                <a href={{asset('delete-missing-attendance/'.$v->id)}} class="btn  btn-sm btn-warning  ml-2">Refuse</a>
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

    </div>



@endsection
<!-- end editing-->
@endsection
@endsection
@endsection

@section('script')
@parent
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection


<!-- jquery for search bar purposes -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


@endsection
