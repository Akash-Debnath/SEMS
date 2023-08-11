@extends('index')
@section('title', '| Late/early Pending Requests')
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
                    <li class="breadcrumb-item"><a href="#">Req_pending</a></li>
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
    @php $appr = array();  @endphp
  {{-- @if(Auth::user()->can('lateEarly-approval-approve-refuse'))   --}}
{{-- Approval Request --}}
    <div class="col-12  ">
        <div class="card card-info">
           <div class="card-header">
               <div class="row">
                   <div class="col-12">
                       <h5 class="mb-0 text-center ">
                        Approval Request: {{$ac}} @php $appr = array();  @endphp
                       </h5>
                   </div>
               </div>
           </div>
        </div>
    </div>
{{-- to print emp card --}}
    <div class="col-12 mb-5">
        <div class="row d-flex justify-content-center">
            

            {{-- start from here --}}
            @foreach($employee as $e) 
       @foreach($approve as $a)
        @if($e->emp_id == $a->emp_id)
        {{-- start from here --}}
        <div class="col-md-3">
            <div class="card">
              
                <div class="card-body gap-card-header">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-0">
                                {{$a->employee->emp_id}} 
                               </p >
                                <a href="#"> {{$e->name}}  </a>
                                <p class="mb-0"> {{$e->userDesignation->designation}} </p>
                                <p class="mb-0">{{$e->department->dept_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-info">
                            <p class="mb-0  text-center">Leave Brief Info</p>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <p class="mb-0"><b>Leave Type:</b>@if($a->late_req=="R") {{"Will be late to come in office"}}@elseif($a->absent_req == 'R'){{"Absent for official work outside"}}@elseif($a->early_req == 'R'){{"Have to go early from office"}}@elseif($a->special_req == 'R'){{"Special absent"}}@endif</b></p>
                               <p class="mb-0"><b>Date:</b>{{$a->date}}</p> @php array_push($appr,$a->id);  @endphp
                               <p class="mb-0 moretext{{$a->id}}" style="display:none;" ><b>Reason:</b> {{$a->reason}}  </p><a class="moreless-button{{$a->id}}" href="#">Read more</a>
                               
                        </div>
                        
                    </div>
                    <div class="row ">
                    <div class="col-12 d-flex justify-content-center">
                     {{-- <div class="col-4 "> --}}
                        <a href={{asset("approve-late/".$a->id)}} class="btn  btn-sm btn-primary ">Approve</a>
                    {{-- </div> --}}
                    {{-- <div class="col-4 "> --}}
                        <a href={{asset("delete-late-early-request/".$a->id)}} class="btn  btn-sm btn-warning ml-2">Refuse</a>
                     {{-- </div> --}}
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
{{-- @endif --}}

@if(Auth::user()->can('lateEarly-verification-approve-refuse'))  
{{-- Verification Request --}}
<div class="col-12 ">
    <div class="card card-info">
       <div class="card-header">
           <div class="row">
               <div class="col-12">
                   <h5 class="mb-0 text-center ">
                    Verification Request: {{$ve}}
                   </h5>
               </div>
           </div>
       </div>
    </div>
</div>
{{-- to print emp card --}}
<div class="col-12 mb-5">
    <div class="row d-flex justify-content-center">
       @foreach($employee as $e) 
       @foreach($verify as $v)
        @if($e->emp_id == $v->emp_id)
        {{-- start from here --}}
        <div class="col-md-3">
            <div class="card">
              
                <div class="card-body gap-card-header">
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-0">
                                {{$v->employee->emp_id}} 
                               </p >
                                <a href="#"> {{$e->name}}  </a>
                                <p class="mb-0"> {{$e->userDesignation->designation}} </p>
                                <p class="mb-0">{{$e->department->dept_name}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 bg-info">
                            <p class="mb-0  text-center">Leave Brief Info</p>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-12 ">
                            <p class="mb-0"><b>Leave Type:</b>@if($v->late_req=="R") {{"Will be late to come in office"}}@elseif($v->absent_req == 'R'){{"Absent for official work outside"}}@elseif($v->early_req == 'R'){{"Have to go early from office"}}@elseif($v->special_req == 'R'){{"Special absent"}}@endif</b></p>
                               <p class="mb-0"><b>Date:</b>{{$v->date}}</p>
                               <p class="mb-0"><b>Reason:</b> {{$v->reason}}</p>
                               
                        </div>
                        
                    </div>
                    <div class="row ">
                    
                        <div class="col-12 d-flex justify-content-center">
                        <a href={{asset("verify-late/".$v->id)}} class="btn  btn-sm btn-primary ">Verify</a> 
                     

                    
                        <a  class="btn  btn-sm btn-warning ml-2" href={{asset("delete-late-early-request/".$v->id)}}>Refuse</a>
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
<script src="{{asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);


    // read more js
  var approve = @JSON($appr);
  for(let i =0; i<=approve.length; i++){
    $('.moreless-button'+approve[i]).click(function() {
  $('.moretext'+approve[i]).slideToggle();
  if ($('.moreless-button'+approve[i]).text() == "Read more") {
    $(this).text("Read less")
  } else {
    $(this).text("Read more")
  }
});

  }
  
</script>


@endsection


<!-- jquery for search bar purposes -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


@endsection