@extends('index')
@section('title', '| Employee Create')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Create new employee [employee_id can't be duplicate] --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Employee Detail</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Employee  </a></li>
                    <li class="breadcrumb-item"><a href="#">All</a></li>
                    <li class="breadcrumb-item active">Employee Detail</li>
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

<div class="row d-flex justify-content-center">
    <div class="col-12">
        <div class="card card-primary card-outline">
            <form class="border p-4 " action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mt-1">
                    <div class="row">
                        <div class="col-md-6 mx-auto rounded bg-info">
                            <h5 class=" text-center text-color-info mb-0 py-2">Basic Information</h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Name<span class="text-danger">*</span></label>
                        <input type="text" placeholder="Name" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="col-md-6">
                        <label for="permission">Role<span class="text-danger">*</span></label>
                        <select id="role" name="roles[]" class="form-control select2" multiple="multiple" required>
                            {{-- <option selected hidden>--Select Role--</option> --}}
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <label for="emp_id">Employee ID<span class="text-danger">*</span></label>
                        <input type="text" placeholder="Employee ID" class="form-control" name="emp_id" id="emp_id" required>
                    </div>

                    <div class="col-md-6 mt-md-0 mt-3">
                        <label for="grade">Grade</label>
                        <select id="grade" name="grade" class="form-control">
                            <option selected hidden>--Select--</option>
                            @foreach ($employeeGrade as $empGrade)
                            <option value="{{ $empGrade->id }}">{{ $empGrade->grade }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>




                <div class="row">
                    <div class="col-md-6">
                        <label for="dept">Department<span class="text-danger">*</span></label>
                        <select id="dept" name="dept_code" class="form-control" required>
                            <option selected hidden>--Select--</option>
                            @foreach ($employeeDept as $empDept)
                            <option value="{{ $empDept->dept_code }}">{{ $empDept->dept_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-md-0 mt-3">
                        <label for="opt_des">Operational Designation<span class="text-danger">*</span></label>
                        <select id="opt_des" name="designation" class="form-control" required>
                            <option selected hidden>--Select--</option>
                            @foreach ($employeeDesignation as $empDesignation)
                            <option value="{{$empDesignation->id}}">{{ $empDesignation->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <label for="date">Joining Date<span class="text-danger">*</span></label>
                        <input class="form-control dateField bg-transparent" type="date" id="date" name="jdate" placeholder="dd/mm/yyyy" required>
                    </div>

                    @php
                        $status = array("P"=>"Permanent", "c"=>"Contractual", "T"=>"Probationary", "R"=>"Regular");
                    @endphp

                    <div class="col-md-6 mt-md-0 mt-3">
                        <label for="c_stat">Current Status<span class="text-danger">*</span></label>
                        <select id="c_stat" class="form-control" name="status" required>
                            <option selected hidden>--Select--</option>
                            @foreach ($status as $key => $value)
                                <option vcalue="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-6">
                        <label for="login">Office Login Time</label>
                        <input class="form-control js-time-field bg-transparent" type="time" id="login" name="office_stime" placeholder="hh:mm:ss">
                    </div>

                    <div class="col-md-6 mt-md-0 mt-3">
                        <label for="logout">Office Logout Time</label>
                        <input class="form-control js-time-field bg-transparent" type="time" id="logout" name="office_etime" placeholder="hh:mm:ss">
                    </div>
                </div>



                <div class="container-fluid  rounded mt-5">
                    <div class="row">
                        <div class="col-md-6 mx-auto rounded bg-info">
                            <h5 class=" text-center text-color-info mb-0 py-2">Contact Information</h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 ">
                        <label for="mobile">Mobile</label>
                        <input class="form-control" placeholder="Mobile" type="text" id="mobile" name="mobile">
                    </div>

                    <div class="col-md-6 mt-md-0 mt-3">
                        <label for="h_phone">Home Phone</label>
                        <input class="form-control" placeholder="Home Phone" type="text" id="h_phone" name="phone">
                    </div>
                </div>



                <div class="row">
                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Email" class="form-control" id="email" name="email">
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 ">
                        <label for="p_address">Present Address</label>
                        <textarea class="form-control" placeholder="Present Address" id="p_address" name="present_address" cols="30" rows="2"></textarea>
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 ">
                        <label for="perma_address">Permanent Address</label>
                        <textarea class="form-control" placeholder="Present Address" name="permanent_address" id="perma_address" cols="30" rows="2"></textarea>
                    </div>
                </div>





                <div class="container-fluid mt-5">
                    <div class="row">
                        <div class="col-md-6 mx-auto rounded  bg-info">
                            <h5 class=" text-center text-color-info mb-0 py-2 ">Educational Information</h5>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label for="l_achive">Last Achievement</label>
                        <input type="text" placeholder="Last Achievement" name="last_edu_achieve" class="form-control" id="l_achive">
                    </div>
                </div>


                <div class="container-fluid mt-5">
                    <div class="row">
                        <div class="col-md-6 mx-auto rounded  bg-info">
                            <h5 class=" text-center text-color-info mb-0 py-2">Personal Information</h5>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <label for="dob">Date of Birth</label>
                        <input class="form-control dateField bg-transparent" type="date" id="date" name="dob" placeholder="dd/mm/yyyy">
                    </div>

                    @php
                        $blood_group = array("A+"=>"A (+ve)", "A-"=>"A (-ve)", "B+"=>"B (+ve)", "B-"=>"B (-ve)", "O+"=>"O (+ve)", "O-"=>"O (-ve)", "AB+"=>"AB (+ve)", "AB-"=>"AB (-ve)" );
                    @endphp

                    <div class="col-md-4 mt-md-0 mt-3">
                        <label for="b_grp">Current Status</label>
                        <select id="b_grp" name="blood_group" class="form-control">
                            <option value="" selected hidden> --Blood Group-- </option>
                            @foreach ($blood_group as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    @php $gender = array("M" => "Male", "F"=>"Female"); @endphp

                    <div class="col-md-4 mt-md-0 mt-3">
                        <label for="grnder">Gender</label>
                        <select id="gender" name="gender" class="form-control">
                            <option value="" selected hidden> --Gender-- </option>
                            @foreach ($gender as $key=>$value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>



                <div class="row">
                    <div class="col-12 ">

                        <label for="u_image" class="d-block">Upload Image</label>
                        <input type="file" placeholder="Upload Image" class=" border-none" id="u_image" name="image">
                        <img src="" alt="your image">

                    </div>
                </div>



                <div class="row mt-5">
                    <div class="col-md-2 mx-auto">
                        <button class="btn btn-lg btn-success btn-block">Done </button>
                    </div>
                </div>

            </form>
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
    //Date and time field cutomization
    $(function() {
        bsCustomFileInput.init();
        $('.dateField').flatpickr();    
        $('.js-time-field').flatpickr({
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: false,
            defaultHour: 12
        });
    });

    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000);

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
@endsection
@endsection
