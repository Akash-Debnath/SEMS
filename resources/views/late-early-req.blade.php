@extends('index')
@section('title', '| Late/Early Request')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Late Early Request</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                    <li class="breadcrumb-item"><a href="#">Attendance Requests</a></li>
                    <li class="breadcrumb-item active">Late Early Request</li>
                </ol>
            </div>
        </div>
        <div class="h-100 d-flex align-items-center justify-content-center">
            @if($errors->any())
                <div id="failMsg" class="alert alert-danger text-center">{{ implode('', $errors->all(':message')) }}</div>
            @elseif ($message = Session::get('success'))
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

<div class="row d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card card-primary">
            <div class="card-header">
                <h4 class=" text-center mb-0">Send request for early/late office time</h4>
            </div>
            <div class="card-body">
                <form action="{{url('late-early-req-send')}}" class="p-1" method="POST">
                    @csrf
                    <div class="e-request-form">
                        <div class="row">
                            <div class="col-12">
                                <h6> <strong> Request For</strong>   </h6>
                                <div class="check" id="request">
                                    <div class="form-check">
                                        <label class="form-check-label"> <input class="form-check-input" name="late" value="R" type="checkbox"> Will be late to come in office</label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label"><input class="form-check-input" name="early" value="R" type="checkbox">Have to go early from office </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label"><input class="form-check-input" name="absent" value="R" type="checkbox">Absent for official work outside</label>

                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label"> <input class="form-check-input" name="special" value="R" type="checkbox">Special absent</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <label for="date">Date</label>
                            <input type="date" name="date" value="{{ date('Y-m-d') }}" id="date" class="form-control bg-transparent">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="reason">Reason</label>
                            <textarea name="reason" id="reason" cols="30" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-info btn-sm btn-block">Send Auto Mail to Manager</button>
                        </div>
                    </div>
                </form>
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
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(function() {
        bsCustomFileInput.init();
        $('#date').flatpickr();         //For date field customization
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>
@endsection
@endsection
