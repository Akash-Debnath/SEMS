@extends('index')
@section('title', '| Roster Pending')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Show all holiday request if anyone wants weekend more than as usual, there've approve/refuse option --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5>Roster Pending Request</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                    <li class="breadcrumb-item"><a href="#">Roster pending</a></li>
                    <li class="breadcrumb-item active">Roster Request</li>
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
    {{-- Approval Request --}}
    <div class="col-12  ">
        <div class="card card-info">
           <div class="card-header">
               <div class="row">
                   <div class="col-12">
                       <h6 class="mb-0 text-center">
                        Approval Request: {{$total}}
                       </h6>
                   </div>
               </div>
           </div>
        </div>
    </div>
    {{-- to print emp card --}}
    <div class="col-12 mb-5">
        <div class="row d-flex justify-content-center">
            

            @foreach($employees as $emp) 
                @foreach($pendings as $pending)
                    @if($emp->emp_id == $pending->sender_id)
                    {{-- start from here --}}
                    <div class="col-md-3">
                        <div class="card">
                        
                            <div class="card-body gap-card-header">

                                <div class="row">
                                    <div class="col-12">
                                            <p><a href="{{ route('employees.show', $emp->emp_id) }}"> {{$emp->name}}</a> has requested for adding weekends more than as usual.</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 bg-info">
                                        <p class="mb-0  text-center">Request Info</p>
                                    </div> 
                                </div>

                                <div class="row">
                                    {{-- <div class="col-12 "> --}}
                                       <div class="col-md-6 d-flex justify-content-end"><p class="mb-0"><b>From: </b></p></div> <div class="col-md-6">{{ $pending->sdate }}</div> 
                                       <div class="col-md-6 d-flex justify-content-end"> <p class="mb-0"><b>To: </b></p></div> <div class="col-md-6"> {{ $pending->edate }}</div>
                                        @foreach ($departments as $dept)
                                            @if ($dept->dept_code == $pending->dept_code)
                                            <div class="col-md-6 d-flex justify-content-end"> <p class="mb-0"><b>Department: </b></p></div><div class="col-md-6">{{ $dept->dept_name }}</div>
                                            @endif
                                        @endforeach
                                        <div class="col-md-6 d-flex justify-content-end"><p class="mb-0"><b>Staff(s) Id: </b></p></div><div class="col-md-6">{{ $pending->emp_id }}</div>
                                        <div class="col-md-6 d-flex justify-content-end"> <p class="mb-0"><b>Reason: </b></p></div><div class="col-md-6">{{ $pending->reason }} </div>
                                    {{-- </div>  --}}
                                </div>

                                <div class="row ">
                                    <div class="col-12 d-flex justify-content-center ">
                                        @if(Auth::user()->can('rosterSettings-approve'))
                                            <form action="{{ route('holiday-request.update', $pending->id) }}" method="post" >
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="admin_id" value="{{ Auth::user()->username }}" hidden>
                                                <button type="submit" class="btn  btn-sm btn-primary">Approve</button>
                                            </form>
                                        @endif
                                        @if(Auth::user()->can('rosterSettings-refuse'))
                                            <form action="{{ route('holiday-request.destroy', $pending->id) }}" method="post" class="ml-2" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ml-auto"  onclick="return confirm('Are you sure want to delete this request?')">Refuse</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ///end one card --}}
                    @endif
                @endforeach
            @endforeach
            {{-- ///end one card --}}
        </div>
    </div>
    {{-- //Approval Request --}}
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
        bsCustomFileInput.init();
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);

</script>
@endsection
@endsection