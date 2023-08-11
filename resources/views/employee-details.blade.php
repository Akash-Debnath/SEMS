@extends('index')
@section('title', '| Employee Profile')
@section('wrapper')
    @parent

    {{-- @author: Akash Chandra Debnath
@Behaviour: Show logged/selected user profile, request for late/early request, evaluation, grade update, status show/change, edit
            contact, educational, experience, personal info for general employee & full info edit by admin/management privileger,
            archive, lock or delete employee, facility show, edit, update or delete. --}}

@section('content-wrapper')
    @parent
@section('content-header')

    @php
    $today = date('Y-m-d');
    $status = ['P' => 'Permanent', 'C' => 'Contractual', 'T' => 'Probationary', 'R' => 'Regular'];
    $s = $empInfo->status;
    @endphp

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">User Profile</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="w-100 alert alert-success alert-dismissible fade show" id="successMsg" role="alert">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="close" role="alert" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @elseif ($message = Session::get('fail'))
                        <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg" role="alert">
                            <strong>
                                {{ $message }}
                            </strong>
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
        <div class="col-md-8 mx-auto">
            @if ($empInfo->resignation_date != null)
                <div class="text-center pb-3">
                    <strong class="text-danger">Resignation Date
                        : {{ $empInfo->resignation_date }}</strong>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <!-- divrofile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if (!is_null(Auth::user()->employeeInfo->image) &&
                            !file_exists(public_path() . '/EmployeePhoto' . Auth::user()->employeeInfo->image))
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('EmployeePhoto/' . $empInfo->image) }}" alt="User profile picture" \>
                        @else
                            <img src="{{ asset('EmployeePhoto/default.png') }}" class="img-circle elevation-2"
                                alt="No Image">
                        @endif
                    </div>
                    {{-- @php var_dump($empInfo);@endphp --}}
                    <h3 class="profile-username text-center">{{ $empInfo->name }}</h3>
                    <p class="text-muted text-center">{{ $empInfo->userDesignation ? $empInfo->userDesignation->designation : '' }}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <strong><i class="fas fa-book mr-1"></i>{{ $empInfo->last_edu_achieve }}</strong>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                    <p class="text-muted">{{ $empInfo->present_address }}</p>
                    <hr>
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Last Login</strong>
                    <p class="text-muted">
                        <span class="tag tag-danger">2 Days Ago</span>
                    </p>
                    <hr>
                    <strong><i class="fas fa-pencil-alt mr-1"></i> Work Life</strong>

                    {{-- @php
                                $date1 = $empInfo->jdate;
                                $date2 = date('d-m-y h:i:s'); //dd($date1);

                                $diff = abs(strtotime($date2) - strtotime($date1));

                                $years = floor($diff / (365*60*60*24));
                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                // dd($months);


                                // printf("%d years, %d months, %d days\n", $years, $months, $days); dd($years);
                                @endphp --}}

                    @php
                        $start = $empInfo->jdate;
                        $date1 = new DateTime($start);
                        $date2 = new DateTime('today');
                        $diff = $date2->diff($date1);
                    @endphp

                    <p class="text-muted">
                        {{ $diff->format('%y years %m months %d days') }}
                    </p>
                    <hr>
                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                    <p class="text-muted">Smart Employee Management System, is an advanced software solution designed to 
                        streamline and automate various aspects of employee management within organizations. </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link " href="#information">Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('late-early-req') }}">Late/Early request</a>
                        </li>
                        @if(Auth::user()->can('employee-self-evaluation') && Auth::user()->username == $empInfo->emp_id)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('evaluation-details', $empInfo->emp_id) }}">Evaluation</a>
                            </li>
                        @elseif (Auth::user()->can('employee-evaluation'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('evaluation-details', $empInfo->emp_id) }}">Evaluation</a>
                            </li>
                        @endif
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <table class="table table-borderless table-info">
                        <tr class="bg-gradient-olive">
                            <td colspan="2">
                                <div class="py-2 h6 m-0"><i class="fas fa-user"></i> Information</div>
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Employee ID</strong></td>
                            <td>{{ $empInfo->emp_id }}</td>
                        </tr>

                        <tr>
                            <td><strong>Grade</strong></td>
                            <td>{{ $empInfo->grade ? $empInfo->grade->grade : 'None' }} &nbsp; &nbsp;  @if (Auth::user()->can('employee-delete'))
                                <a href="" class="btn  btn-warning btn-xs " data-toggle="modal" data-target="#grade"> change </a> @endif
                            </td>
                        </tr>

                        <tr>
                            <td><strong>Operational Designation</strong></td>
                            <td>{{ $empInfo->userDesignation ? $empInfo->userDesignation->designation : '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Department</strong></td>
                            <td>{{ $empInfo->department ? $empInfo->department->dept_name : '' }}</td>
                        </tr>

                        <tr>
                            <td><strong>Joining Date</strong></td>
                            <td>{{ $empInfo->jdate }}</td>
                        </tr>

                        <tr>
                            <td><strong>Current Status</strong></td>
                            @foreach ($status as $key => $value)
                                @if ($s == $key)
                                    <td>{{ $value }}
                                        @if ($empInfo->status_time != '')
                                            (On {{ $empInfo->status_time }})
                                        @endif
                                        <a href="" class="btn  btn-warning btn-xs " data-toggle="modal"
                                            data-target="#oldStatus">Old Status </a>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    </table>

                    <table class="table table-borderless table-info">
                        <tr class="bg-gradient-olive">
                            <td colspan="2">
                                <div class="py-2 h6 m-0"><i class="fas fa-mail-bulk"></i> Contact
                                    Information
                                    @if (Auth::user()->can('employee-profile-edit'))
                                        <button class="btn btn-default btn-xs" id="editContactBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tbody id="editContactByEmployee">
                            <tr>
                                <td><strong>Mobile</strong></td>
                                <td>{{ $empInfo->mobile }}</td>
                            </tr>
                            <tr>
                                <td><strong>Home Phone</strong></td>
                                <td>{{ $empInfo->phone }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ $empInfo->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Present Address</strong></td>
                                <td>{{ $empInfo->present_address }}</td>
                            </tr>
                            <tr>
                                <td><strong>Permanent Address</strong></td>
                                <td>{{ $empInfo->permanent_address }}</td>
                            </tr>
                        </tbody>


                        {{-- It is the editable fields of employee --}}
                        <form action="{{ url('edit-employee-info') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <tbody id="editableContact">
                                <tr>
                                    <td>Mobile</td>
                                    <td>
                                        @csrf
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <input type="text" class="form-control" id="" name="mobile"
                                                    value="{{ $empInfo->mobile }}">
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Home phone</td>
                                    <td>
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <input type='text' name="phone" class='form-control'
                                                    value='{{ $empInfo->phone }}'>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Present Address</td>
                                    <td>
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <input type='text' class='form-control' name="present_address"
                                                    value='{{ $empInfo->present_address }}'>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Permanent Address</td>
                                    <td>
                                        <div class='row'>
                                            <div class='col-md-12'>
                                                <input type='text' class='form-control' name="permanent_address"
                                                    value='{{ $empInfo->permanent_address }}'>
                                            </div>

                                        </div>
                                    </td>
                                    <td>
                                        <div class='col-md-2'>
                                            <button type='submit' class='btn btn-md btn-info form-control edit-emp'><i
                                                    class='fas fa-check mx-auto'></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </form>
                        {{-- Edit part of employee end --}}


                    </table>

                    <table class="table table-info table-borderless">
                        <tr class="bg-gradient-olive">
                            <td colspan="2">
                                <div class="py-2 h6 m-0"><i class="fas fa-school"></i> Educational
                                    Information
                                    @if (Auth::user()->can('employee-profile-edit'))
                                        <button class="btn btn-default btn-xs" id="editEducationBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tbody id="editEducationByEmployee">
                            <tr>
                                <td><strong>Last Achievement</strong></td>
                                <td>{{ $empInfo->last_edu_achieve }}</td>
                            </tr>
                        </tbody>
                        @if (Auth::user()->can('employee-profile-edit'))
                            <form action="{{ url('edit-employee-info') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tbody id="editableEducation">
                                    <tr>
                                        <td><strong>Last Achievement</strong></td>
                                        <td>
                                            <form>
                                                <div class='row'>
                                                    <div class='col-md-12'>
                                                        <input type='text' class='form-control'
                                                            name="last_edu_achieve"
                                                            value='{{ $empInfo->last_edu_achieve }}'>
                                                    </div>
                                                </div>

                                            </form>
                                        </td>
                                        <td>
                                            <div class='col-md-2'>
                                                <button type='submit'
                                                    class='btn btn-md btn-info form-control edit-emp'><i
                                                        class='fas fa-check mx-auto'></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        @endif
                    </table>

                    <table class="table table-borderless table-info">
                        <tr class="bg-gradient-olive">
                            <td colspan="2">
                                <div class="py-2 h6 m-0">Experience
                                    @if (Auth::user()->can('employee-profile-edit'))
                                        <button class="btn btn-default btn-xs" id="editExperienceBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </button>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        <tbody id="editExperienceByEmployee">
                            <tr>
                                <td><strong>Please Update your experience</strong></td>
                                <td>{{ $empInfo->experience }}</td>
                            </tr>
                        </tbody>

                        {{-- Edit experience by employee --}}
                        @if (Auth::user()->can('employee-profile-edit'))
                            <form action="{{ url('edit-employee-info') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <tbody id="editableExperience">
                                    <tr>
                                        <td>Last Achievement</td>
                                        <td>
                                            <form>
                                                <div class='row'>
                                                    <div class='col-md-12'><input type='text' name="experiance"
                                                            class='form-control' value='{{ $empInfo->experience }}'>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <div class='col-md-2'>
                                                <button type='submit'
                                                    class='btn btn-md btn-info form-control edit-emp'><i
                                                        class='fas fa-check mx-auto'></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        @endif
                        {{-- End edit experience by employee --}}
                    </table>

                    <table class="table table-borderless table-info emp_edit">
                        <tr class="bg-gradient-olive">
                            <td colspan="2">
                                <div class="py-2 h6 m-0">Personal Information
                                    @if (Auth::user()->can('employee-profile-edit'))
                                        <button class="btn btn-default btn-xs" id="editPersonalInfoBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <tbody id="editPersonalInfoByEmployee">
                            <tr>
                                <td><strong>Date of Birth</strong></td>
                                <td>{{ $empInfo->dob }}</td>
                            </tr>
                            <tr>
                                <td><strong>Blood Group</strong></td>
                                <td>{{ $empInfo->blood_group }}</td>
                            </tr>
                            <tr>
                                <td><strong>Gender</strong></td>
                                @if ($empInfo->gender == 'M')
                                    <td>Male</td>
                                @else
                                    <td>Female</td>
                                @endif
                            </tr>
                        </tbody>

                        {{-- Edit Personal Information by employee --}}
                        @if (Auth::user()->can('employee-profile-edit'))
                            <form action="{{ url('edit-employee-info') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <tbody id="editablePersonalInfo">
                                    <tr>
                                        <td>Date of Birth</td>
                                        <td>
                                            <div class='row'>
                                                <div class='col-md-12'>
                                                    <input type='date' class='form-control dateField bg-transparent'
                                                        name="dob" value='{{ $empInfo->dob }}' name='dob' />
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Blood Group</td>
                                        <td>
                                            <div class='row'>
                                                @php
                                                    $blood = ['A+' => 'A(+)', 'A-' => 'A(-)', 'B+' => 'B(+)', 'B-' => 'B(-)', 'O+' => 'O(+)', 'O-' => 'O(-)', 'AB+' => 'AB(+)', 'AB-' => 'AB(-)'];
                                                @endphp
                                                <div class='col-md-12'>
                                                    <select name="blood_group" class='form-control' style="padding: 0;">
                                                        <option selected hidden>--Select--</option>
                                                        @foreach ($blood as $key => $value)
                                                            <option value='{{ $key }}'
                                                                {{ $empInfo->blood_group == $key ? 'selected' : '' }}>
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gender</td>
                                        <td>
                                            <div class='row'>
                                                @php
                                                    $gender = ['M' => 'Male', 'F' => 'Female'];
                                                @endphp
                                                <div class='col-md-12'>
                                                    <select name="gender" class='form-control'>
                                                        @foreach ($gender as $key => $value)
                                                            <option value='{{ $key }}'
                                                                {{ $empInfo->gender == $key ? 'selected' : '' }}>
                                                                {{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                        </td>
                                        <td>
                                            <div class='col-md-2'>
                                                <button type='submit' class='btn btn-sm btn-info '>
                                                    <i class='fas fa-check mx-auto'></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </form>
                        @endif
                        {{-- Edit end Personal Information by employee --}}
                    </table>

                    <div class="gap mt-4">
                        <div class="row ">
                            <div class="col-12">
                                <button class="btn btn-sm btn-success">Integrate Gmail A/C</button>
                            </div>
                        </div>
                        <div class="row  ">
                            <div class="col-md-6">
                                <div class="btn-group-sm">
                                    @if (Auth::user()->can('employee-archive'))
                                        <a class="btn btn-warning btn-xs" href="#">

                                            <form action="{{ url('archive-employee', $empInfo->emp_id) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="archive" value="Y" hidden>
                                                <button type="submit" class="btn btn-warning btn-xs"
                                                    onclick="return confirm('Are you sure want to archive employee - {{ $empInfo->name }}?')">
                                                    <i class="fas fa-folder">
                                                    </i> Archive
                                                </button>
                                            </form>
                                        </a>
                                    @endif

                                    @if (Auth::user()->can('employee-lock'))
                                        <a class="btn btn-info btn-xs" href="#">

                                            <form action="" method="post">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-info btn-xs"
                                                    onclick="return confirm('Are you sure want to lock employee - {{ $empInfo->name }}?')">
                                                    <i class="fas fa-lock-open">
                                                    </i> Lock
                                                </button>
                                            </form>
                                        </a>
                                    @endif
                                    @if (Auth::user()->can('employee-delete'))
                                        <a class="btn btn-danger btn-xs">
                                            <form action="{{ route('employees.destroy', $empInfo->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Are you sure want to delete employee - {{ $empInfo->name }}?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 d-flex mt-2 mt-md-0">
                                <div class="btn-group-sm ml-md-auto ml-0">
                                    @if (Auth::user()->can('employee-edit'))
                                        <a class="btn btn-warning btn-sm"
                                            href="{{ route('employees.edit', $empInfo->id) }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
                                    {{-- @if (Auth::user()->can('employee-edit')) --}}
                                    <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#facility">
                                        <i class="fas fa-paperclip"> </i> Facilities
                                    </a>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- facility modal -->
                    <div class="modal fade" id="facility">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Facilities Occupied</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @if (Auth::user()->can('employee-edit') && Auth::user()->username != $empInfo->id) 
                                <div class="modal-body">
                                        <div class="row my-1">
                                            <div class="col-12">
                                                <button class="btn btn-info btn-sm" data-toggle="modal"
                                                    data-target="#addfacility">Add Facility
                                                </button>
                                            </div>
                                        </div>
                                @endif
                                    <table class="table table-bordered ">
                                        <thead>
                                            <th>Facility</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Remark</th>
                                            @if (Auth::user()->can('employee-edit')) 
                                                <th>Action</th>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @foreach ($faci as $fac)
                                                <tr>
                                                    <td>{{ $fac->facility }}</td>
                                                    <td>{{ $fac->from_date }}</td>
                                                    <td>{{ $fac->to_date }}</td>
                                                    <td>{{ $fac->remark }}</td>
                                                    @if (Auth::user()->can('employee-edit') && Auth::user()->username != $empInfo->id) 
                                                        <td class="d-flex">
                                                            <button class="btn btn-sm btn-warning"
                                                                onclick="getData({{ $fac->id }})" data-toggle="modal"
                                                                data-target="#edit_facility">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                                    height="13" fill="currentColor"
                                                                    class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                                    <path fill-rule="evenodd"
                                                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                                </svg>
                                                            </button>
                                                            <form action="{{ url('facility-delete', $fac->id) }}"
                                                                method="post" class="ml-1">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure want to delete facility : {{ $fac->facility }}?')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                                        height="13" fill="currentColor"
                                                                        class="bi bi-archive" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--////modal--finish  -->


                    <!-- grade modal -->
                    <div class="modal fade" id="addfacility">
                        <div class="modal-dialog modal-dialog-centered " style="max-width: 800px;">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Add Facility</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <form action="{{ url('add-facility') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hiddden" name="emp_id" value="{{ $empInfo->emp_id }}"
                                                hidden />
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="facility">Facility</label>
                                                    <select class="select2 form-control" name="facility" id="facility">
                                                        <option selected hidden>Select facility</option>
                                                        @foreach ($facility as $f)
                                                            <option value="{{ $f->facility }}">{{ $f->facility }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="from">From</label>
                                                    <input type="date" name="from_date" id="from"
                                                        class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="to">To</label>
                                                    <input type="date" name="to_date" id="to"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="remark">Remark</label>
                                                    <textarea name="remark" id="remark" cols="30" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-block btn-sm">
                                                        Close
                                                    </button>
                                                </div>
                                                <div class="col-md-2 mt-2 mt-md-0">
                                                    <button type="submit" class="btn btn-success btn-block btn-sm">Add
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--////modal--finish  -->


                    {{-- edit facility --}}
                    <div class="modal fade" id="edit_facility">
                        <div class="modal-dialog modal-dialog-centered " style="max-width: 800px;">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Edit Facility</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <form action="{{ url('update-facility') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hiddden" name="facilityId" id="facilityId" hidden />
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="facility">Facility</label>
                                                    <select class="select2 form-control" name="facility" id="facile">
                                                        <option selected hidden>Select facility</option>
                                                        @foreach ($facility as $f)
                                                            <option value="{{ $f->facility }}">{{ $f->facility }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="from">From</label>
                                                    <input type="date" name="from_date" id="date_from"
                                                        class="form-control js-date-field bg-transparent"
                                                        placeholder="dd/mm/yyyy">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="to">To</label>
                                                    <input type="date" name="to_date" id="date_to"
                                                        class="form-control js-date-field bg-transparent"
                                                        placeholder="dd/mm/yyyy">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="remark">Remark</label>
                                                    <textarea name="remark" id="remarks" cols="30" rows="3" class="form-control"></textarea>
                                                </div>
                                            </div>

                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-block btn-sm">
                                                        Close
                                                    </button>
                                                </div>
                                                <div class="col-md-2 mt-2 mt-md-0">
                                                    <button type="submit" class="btn btn-success btn-block btn-sm">Add
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    {{-- edit facility --}}



                    <!-- grade modal -->
                    <div class="modal fade" id="grade">
                        <div class="modal-dialog modal-dialog-centered " style="max-width: 400px;">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Grade Information</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered mx-auto" style="width:85%;">
                                        <thead>
                                            <th style="max-width: 60px;">Grade</th>
                                            <th>Person</th>
                                            @if (Auth::user()->can('employee-grade-set'))
                                                <th>Action</th>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @foreach ($employeeGrade as $empGrade)
                                                @php
                                                    $g = $empInfo->grade_id;
                                                    $eg = $empGrade->id;
                                                    // $c  = count($empInfo->grade_id);
                                                @endphp
                                                <form action="{{ url('update-grade', $empInfo->emp_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <tr>
                                                        <input type="hidden" name="grade_id"
                                                            value="{{ $empGrade->id }}" hidden>
                                                        <td><input type="text" name="grade" id=""
                                                                value="{{ $empGrade->grade }}"
                                                                style="max-width: 55px;border: none;" readonly></td>
                                                        <td>3</td>
                                                        @if (Auth::user()->can('employee-grade-set'))
                                                            @if ($g == $eg)
                                                                <td>
                                                                    <i class="fa fa-check-square btn btn-success btn-sm ml-2"
                                                                        aria-hidden="true"></i>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <button type="submit"
                                                                        class="btn btn-warning btn-sm ml-2">
                                                                        set
                                                                    </button>
                                                                </td>
                                                            @endif
                                                        @endif
                                                    </tr>
                                                </form>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if (Auth::user()->can('employee-grade-add'))
                                    <div class="modal-footer ">

                                        <div class="col-12 ">
                                            <form action="{{ url('add-grade') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mx-auto" style="width:85%;">
                                                    <div class="row">
                                                        <div class="col-md-8 ">
                                                            <input type="number" name="grade" id="grade"
                                                                min="1" max="50" class="form-control"
                                                                placeholder="Add a new Grade">
                                                        </div>
                                                        <div class="col-md-4 mt-2 mt-md-0">
                                                            <button type="submit"
                                                                class="btn btn-primary btn-info btn-md btn-block">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                @endif
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--////modal--finish  -->

                    <!-- status modal -->
                    <div class="modal fade" id="oldStatus">
                        <div class="modal-dialog modal-dialog-centered " style="max-width:500px; ">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Status Information</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered ">
                                        <thead>
                                            <th>Status</th>
                                            <th>Date</th>
                                            @if(Auth::user()->can('employee-status-delete'))
                                            <th class="text-center">Action</th>
                                            @endif
                                        </thead>
                                        <tbody>
                                            @foreach ($stat as $s)
                                                @php
                                                    $st = $s->status;
                                                @endphp
                                                <tr>
                                                    @foreach ($status as $key => $value)
                                                        @if ($st == $key)
                                                            <td>{{ $value }}</td>
                                                        @endif
                                                    @endforeach
                                                    <td>{{ $s->date }}</td>
                                                    @if(Auth::user()->can('employee-status-delete'))
                                                    <td>
                                                        <div class="row d-flex justify-content-center">
                                                            <form action="{{ url('delete-status', $s->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm"
                                                                    onclick="return confirm('Are you sure want to delete status : {{ $value }}?')">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                        height="16" fill="currentColor"
                                                                        class="bi bi-archive" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                        {{-- </div> --}}
                                                    </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @if(Auth::user()->can('employee-status-add'))
                                <div class="modal-footer  d-flex justify-content-center">
                                    <div class="col-12 ">
                                        <form action="{{ url('add-status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="emp_id" value="{{ $empInfo->emp_id }}"
                                                hidden />
                                            <div class="row">
                                                <div class="col-md-5 ">
                                                    <select class="form-control" name="status" style="width: 100%;">
                                                        <option selected hidden>--Select status--
                                                        </option>
                                                        @foreach ($status as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-5 mt-2 mt-md-0">
                                                    <input type="text" name="date" id=""
                                                        value="{{ $today }}" class="form-control">
                                                </div>
                                                <div class="col-md-2 mt-2 mt-md-0">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-info btn-md btn-block">
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                @endif
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--////modal--finish  -->
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
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('.dateField').flatpickr(); //Date filed customization

    })
</script>
@endsection


@section('add-script')

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
    function getData(id) {
        // console.log(id);
        $('#facilityId').val(id);
        $.ajax({
            type: "GET",
            url: "edit-facility/" + id,
            success: function(response) {
                console.log(response);
                $('#facile').val(response.facilitydata.facility);
                $('#date_from').val(response.facilitydata.from_date);
                $('#date_to').val(response.facilitydata.to_date);
                $('#remarks').val(response.facilitydata.remark);
            },
            error: function(jqXhr, textStatus, errorMessage) { // error callback
                console.log(errorMessage);
            }
        });
    }
</script>
{{-- edit contact --}}
<script>
    const editContact = document.querySelector('#editContactBtn');
    const intialDivContact = document.querySelector('#editContactByEmployee');
    const editableDivContact = document.querySelector('#editableContact');

    editableDivContact.style.display = 'none';
    editContact.addEventListener('click', () => {

        if (intialDivContact.style.display === 'none') {
            intialDivContact.style.display = 'block';
            editableDivContact.style.display = 'none';
        } else {
            intialDivContact.style.display = 'none';
            editableDivContact.style.display = 'block';
        }
    });


    const editEducation = document.querySelector('#editEducationBtn');
    const intialDivEdu = document.querySelector('#editEducationByEmployee');
    const editableDivEdu = document.querySelector('#editableEducation');

    editableDivEdu.style.display = 'none';
    editEducation.addEventListener('click', () => {

        if (intialDivEdu.style.display === 'none') {
            intialDivEdu.style.display = 'block';
            editableDivEdu.style.display = 'none';
        } else {
            intialDivEdu.style.display = 'none';
            editableDivEdu.style.display = 'block';
        }
    });


    const editExp = document.querySelector('#editExperienceBtn');
    const intialDivExp = document.querySelector('#editExperienceByEmployee');
    const editableDivExp = document.querySelector('#editableExperience');

    editableDivExp.style.display = 'none';
    editExp.addEventListener('click', () => {

        if (intialDivExp.style.display === 'none') {
            intialDivExp.style.display = 'block';
            editableDivExp.style.display = 'none';
        } else {
            intialDivExp.style.display = 'none';
            editableDivExp.style.display = 'block';
        }
    });


    const editPI = document.querySelector('#editPersonalInfoBtn');
    const intialDivPI = document.querySelector('#editPersonalInfoByEmployee');
    const editableDivPI = document.querySelector('#editablePersonalInfo');

    editableDivPI.style.display = 'none';
    editPI.addEventListener('click', () => {

        if (intialDivPI.style.display === 'none') {
            intialDivPI.style.display = 'block';
            editableDivPI.style.display = 'none';
        } else {
            intialDivPI.style.display = 'none';
            editableDivPI.style.display = 'block';
        }
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);

    //Date field customization
    $(function() {
        $('.js-date-field').flatpickr();
    })
</script>
@endsection
@endsection
