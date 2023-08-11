@extends('index')
@section('title', '| Upload')
@section('wrapper')
@parent

@section('content-wrapper')
@parent
@section('content-header')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>Upload Attendance Information</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                        <li class="breadcrumb-item"><a href="#">Upload</a></li>
                        <li class="breadcrumb-item active">Upload Attendance Information</li>
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
        <div class="col-md-6 col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4 class="mb-0 text-center">Add Attendance Manually</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('upload.store') }}" class="" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <label for="cause">Cause</label>
                                <div class=" form-group" id="cause" name="reason">
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio1" name="reason"
                                            value="Forgot to punch">
                                        <label for="customRadio1" class="custom-control-label mb-0">Forgot to punch</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" id="customRadio2" name="reason"
                                            checked="" value="Loss of finger's outer skin by peeling">
                                        <label for="customRadio2" class="custom-control-label mb-0 ">Loss of finger's outer
                                            skin by peeling</label>
                                    </div>

                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12">




                                <label>Department</label>
                                {{-- <p id="get_session"></p> --}}

                                <select class="form-control select2" name="dept" style="width: 100%;" id='dept'
                                    required>
                                    <option selected="selected">Select Department</option>
                                    @foreach ($dept as $d)
                                        <option data-state="{{ $d->dept_code }}" value="{{ $d->dept_code }}">
                                            {{ $d->dept_name }}</option>
                                    @endforeach
                                </select>



                            </div>
                        </div>



                        <div class="row">
                            <div class="col-12">
                                <label for="staff">Staff</label>

                                <select class="form-control select2" style="width: 100%;" id='staff' name="staff"
                                    data-placeholder='Select staff' required>
                                    {{-- <option selected="selected">Select Staff</option> --}}

                                    @foreach ($employee as $e)
                                        <option data-state="{{ $e->dept_code }}" value="{{ $e->emp_id }}">
                                            {{ $e->name }}</option>
                                    @endforeach
                                </select>

                            </div>


                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="date">Date</label>
                                {{-- placeholder="dd/mm/yyyy" --}}
                                <input class="form-control js-date-field bg-transparent" value="{{date('Y-m-d')}}"
                                    type="date" id="date" name="date" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="login">Login Time</label>
                                <input class="form-control js-time-field bg-transparent" placeholder="00:00:00"
                                    type="time" id="date" name="in" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <label for="logout">Logout Time</label>
                                <input class="form-control js-time-field bg-transparent" placeholder="00:00:00"
                                    type="time" id="logout" name="out" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">

                                <input class="btn-block btn btn-info btn-sm" type="submit" id="logout">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        @if(Auth::user()->can('upload-attendancefile'))
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4 class="mb-0 text-center">Upload Attendance File</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('attendance_file.report') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <label for="att">Select Text File</label>
                                <div class="form-group">
                                    <!-- <label for="customFile">Custom File</label> -->

                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input" id="customFile1">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-block btn-info">Upload Attendance
                                    File</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h4 class="mb-0 text-center">Upload Training Attendance File</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('training_attendance') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">

                                <label for="att">Select Text File</label>
                                <div class="form-group">
                                    <!-- <label for="customFile">Custom File</label> -->

                                    <div class="custom-file">
                                        <input type="file" name="training_file" class="custom-file-input"
                                            id="customFile">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-sm btn-block btn-info">Upload Training Attendance File</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    $(function() {
        bsCustomFileInput.init();

        //Date and time field customization
        $('.js-date-field').flatpickr();
        $('.js-time-field').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
            defaultHour: 12
        });
    });


    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);

    var $selectDept = $('#dept'),
        $selectStaff = $('#staff'),
        $options = $selectStaff.find('option');

    $selectDept.on('change', function() {
        $selectStaff.html($options.filter('[data-state="' + this.value + '"]'));
    }).trigger('change');
</script>
@endsection


@endsection
