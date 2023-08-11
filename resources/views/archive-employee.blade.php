@extends('index')
@section('title', '| Archive Employee')

{{-- @author Akash Chandra Debnath
@Behaviour All archives employee --}}

@section('wrapper')
@parent
@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Employee List</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Employee</a></li>
                    <li class="breadcrumb-item"><a href="#">All</a></li>
                    <li class="breadcrumb-item active">Employee List </li>
                </ol>
            </div>
        </div>
        @if($errors->any())
            <div id="failMsg" class="alert alert-danger text-center">{{ implode('', $errors->all(':message')) }}</div>
        @elseif($message = Session::get('success'))
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
<div class="card">
    <div class="card-body">
        <table class="table table-hover table-bordered table-responsive-sm selectpicker" data-live-search="true">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Joining Date</th>
                    <th>Resignation Date</th>
                </tr>
            </thead>
            <tbody>
                @php  $i = $employees-> currentPage()==1 ? 0 : ($employees-> currentPage()-1)*20  @endphp
                @foreach ($employees as $emp)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td><a href="{{ route('archive.show', $emp->emp_id) }}">{{ $emp->name }}</td>
                    <td>{{ $emp->department ? $emp->department->dept_name : '' }}</td>
                    <td>{{  $emp->userDesignation ? $emp->userDesignation->designation : '' }}</td>
                    <td>{{ $emp->jdate }}</td>
                    <td>{{ $emp->resignation_date }}</td>
                </tr>  
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-footer overflow-auto ">
        {!! $employees->Links('pagination::bootstrap-4') !!}
    </div>
</div>
@endsection
<!-- end editing-->
@endsection
@endsection
@endsection



<!-- modal -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title ">Employee Detail</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form class="border p-4 ">


                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-12">
                                <label for="name">Name</label>
                                <input type="text" placeholder="Name" class="form-control" id="name">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="emp_id">Employee ID</label>
                                <input type="text" placeholder="Employee ID" class="form-control" id="emp_id">
                            </div>

                            <div class="col-md-6">
                                <label for="grade">Grade</label>
                                <select id="grade" class="form-control">
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class=" container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="dept">Department</label>
                                <select id="dept" class="form-control">
                                    <option value="1">1</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="opt_des">Operational Designation</label>
                                <select id="opt_des" class="form-control">
                                    <option value="1">1</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="date">Date</label>
                                <input class="form-control" type="date" id="date">
                            </div>

                            <div class="col-md-6">
                                <label for="c_stat">Current Status</label>
                                <select id="c_stat" class="form-control">
                                    <option value="Software">Software</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="login">Office Login Time</label>
                                <input class="form-control" type="time" id="login">
                            </div>

                            <div class="col-md-6">
                                <label for="logout">Office Logout Time</label>
                                <input class="form-control" type="time" id="logout">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class=" container-fluid  rounded  bg-info  ">
                                <h3 class=" text-center text-color-info mb-0">Contact Information</h1>
                            </div>
                        </div>
                    </div>

                    <div class=" container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="mobile">Mobile</label>
                                <input class="form-control" placeholder="Mobile" type="text" id="mobile">
                            </div>

                            <div class="col-md-6">
                                <label for="h_phone">Home Phone</label>
                                <input class="form-control" placeholder="Home Phone" type="text" id="h_phone">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-12">
                                <label for="email">Email</label>
                                <input type="text" placeholder="Email" class="form-control" id="email">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 ">
                                <label for="p_address">Present Address</label>
                                <textarea class="form-control" placeholder="Present Address" id="p_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 ">
                                <label for="perma_address">Permanent Address</label>
                                <textarea class="form-control" placeholder="Present Address" id="perma_address" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class=" container-fluid  rounded  bg-info  ">
                                <h3 class=" text-center text-color-info mb-0">Educational Information</h1>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ">
                        <div class="row">
                            <div class="col-12">
                                <label for="l_achive">Last Achievement</label>
                                <input type="text" placeholder="Last Achievement" class="form-control" id="l_achive">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid  rounded  bg-info  ">
                        <div class="row">
                            <div class="col-12">
                                <h3 class=" text-center text-color-info mb-0">Personal Information</h1>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="dob">Date of Birth</label>
                                <input class="form-control" type="date" id="date">
                            </div>

                            <div class="col-md-4">
                                <label for="b_grp">Current Status</label>
                                <select id="b_grp" class="form-control">
                                    <option value="" selected hidden> --Blood Group-- </option>
                                    <option value="B(+)">B(+)</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="grnder">Gender</label>
                                <select id="gender" class="form-control">
                                    <option value="" selected hidden> --Gender-- </option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 ">

                                <label for="u_image" class="d-block">Upload Image</label>
                                <input type="file" placeholder="Upload Image" class=" border-none" id="u_image">


                                <img src="" alt="your image">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer  ">
                <div class="container-fluid">
                    <div class="row ">
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info ">Save changes</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--////modal--finish  -->
@endsection