@extends('index')
@section('title', '| Late Early Pending Requests')
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
        @if($message = Session::get('success'))
            <div class="alert alert-success text-center">{{ $message }}</div>
        @elseif ($message = Session::get('fail'))
            <div class="alert alert-success text-center">{{ $message }}</div>
        @endif
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
                        <h5 class="mb-0 text-center ">
                            Approval Request: 1
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
            <div class="col-md-3">
                <div class="card">

                    <div class="card-body gap-card-header">
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0">
                                   0021
                                </p>
                                <a href="http://">abc</a>
                                <p class="mb-0">abc</p>
                                <p class="mb-0">abc</p>
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
                                    <div class="col-5"> <label for="type">Date</label></div>
                                    <div class="col-7"><p class="mb-0" id="type"><b>:&nbsp;</b></p></div>
                                </div>
                                {{-- <p class="mb-0"><b>Leave Type:</b> Will be late to come in office</b></p> --}}
                                <div class="row">
                                    <div class="col-5"> <label for="from">In Time</label></div>
                                    <div class="col-7"><p class="mb-0" id="from"><b>:&nbsp;</b></p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5"> <label for="from">Out Time</label></div>
                                    <div class="col-7"><p class="mb-0" id="to"><b>:&nbsp;</b></p></div>
                                </div>
                                <div class="row ">
                                    <div class="col-5"> <label for="reason">Reason</label></div>
                                    <div class="col-7"><p class="mb-0" id="reason"><b>:&nbsp;</b></p></div>
                                </div>

                            </div>

                        </div>
                        <div class="row ">

                            <div class="col-12 d-flex">
                                <a href="" class="btn  btn-sm btn-primary">Approve</a>
                                <a href="" class="btn  btn-sm btn-warning ml-auto">Refuse</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
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
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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