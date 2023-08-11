@extends('index')
@section('title', '| Designation')

{{-- @author Akash Chandar Debnath
@Behaviour show all designations, can add, edit, update and delete specified designation --}}

@section('wrapper')
@parent
@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Designation List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item"><a href="#">Designation</a></li>
                    <li class="breadcrumb-item active">Designation List</li>
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
       <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="row">
                        <form action="{{ url('/designation') }}" method="GET">
                            <select name="dept" class="form-control"  onchange="this.form.submit()">
                                <option value="all" selected hidden> All Departments </option>
                                @foreach ($department as $dept )
                                    <option value="{{ $dept->dept_code }}" {{ $dept->dept_code == $deptCode ? 'selected' : '' }}>{{ $dept->dept_name }}</option>
                                @endforeach
                            </select>
                        </form>
                        @if(Auth::user()->can('designation-create'))
                            <button type="button" class="btn btn-warning ml-auto btn-sm" data-toggle="modal" data-target="#modal-default">
                                <span class=" fas fa-plus "> </span> Add New Designation
                            </button>
                        @endif
                    </div>


                    <!-- modal -->
                    @if(Auth::user()->can('designation-create'))
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title ">Add a new Designation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('designation.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                                <div class="row">
                                                    <div class="col-12">

                                                        <label for="dept" class="d-block">Department</label>
                                                        <select id="department-modal" name="dept_code" class="form-control ">
                                                            <option value="selected" hidden>-- Select Department --</option>
                                                            @foreach ($department as $dept )
                                                                <option value="{{ $dept->dept_code }}">{{ $dept->dept_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="title">Designation</label>
                                                        <input type="text" placeholder="Designation" id="title" name="designation" class="form-control">
                                                    </div>
                                                </div>

                                            <div class="row ">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-sm form-control" data-dismiss="modal">Close</button>
                                                </div>
                                                <div class="col-md-3 ml-auto">
                                                    <button type="submit" class="btn btn-success   btn-sm form-control">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @endif
                    <!--////modal--finish  -->
                </div>
                <div class="card-body overflow-auto">
                    <table class="table table-hover table-bordered selectpicker" data-live-search="true">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Designation</th>
                                @if (Auth::user()->can('designation-edit') || Auth::user()->can('designation-delete'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php  $i = $designation->currentPage()==1 ? 0 : ($designation->currentPage() -1 )*20  @endphp
                            @foreach ($designation as $des)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $des->designation }}</td>
                                <td>
                                    <div class="row d-flex justify-content-center">
                                        @if(Auth::user()->can('designation-edit'))
                                            <a onclick="getData({{ $des->id }})" class="btn  btn-warning btn-sm" data-toggle="modal" data-target="#editModal">

                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            </a>
                                        @endif
                                        @if(Auth::user()->can('designation-delete'))
                                            <form action="{{ route('designation.destroy', $des->id ) }}" method="post" class="ml-1" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete designation : {{ $des->designation }}?')"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                </svg> </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- modal -->
                    @if(Auth::user()->can('designation-edit'))
                        <div class="modal fade" id="editModal">
                            <div class="modal-dialog modal-dialog-centered ">
                                <div class="modal-content">
                                    <div class="modal-header bg-info">
                                        <h4 class="modal-title ">Edit Designation</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ url('update-designation') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="designationId" value="" id="designationId" />


                                                <div class="row">
                                                    <div class="col-12">

                                                        <label for="dept" class="d-block">Department</label>
                                                        <select id="dept_code" name="dept_code" class="form-control ">
                                                            <option value="selected" hidden>-- Select Department --</option>
                                                            @foreach ($department as $dept )
                                                                <option value="{{ $dept->dept_code }}">{{ $dept->dept_name }}</option>
                                                            @endforeach
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="title">Designation</label>
                                                        <input type="text" placeholder="Department" id="designation" name="designation" class="form-control">
                                                    </div>
                                                </div>

                                            <div class="row ">
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger btn-sm form-control" data-dismiss="modal">Close</button>



                                                </div>

                                                <div class="col-md-3 ml-auto">
                                                <button type="submit" class="btn btn-success   btn-sm form-control">Save Changes</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    @endif
                    <!--////modal--finish  -->
                </div>


            </div>
            <div class="card-footer overflow-auto ">
                {!! $designation->withQueryString()->Links('pagination::bootstrap-4') !!}
            </div>
        </div>
       </div>
   </div>
@endsection
<!-- end editing-->
@endsection
@endsection
@endsection


@section('add-script')

{{-- <script src="{{ asset('scripts/jquery.js') }}"></script> --}}
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>

    function getData(id) {
        $('#designationId').val(id);
        $.ajax({
            type: "GET",
            url: "edit-designation/"+id,
            success: function(response){
                console.log(response.designation.dept_code)
                $('#dept_code').val(response.designation.dept_code).attr('selected', true);
                $('#designation').val(response.designation.designation);
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback
                console.log(errorMessage) ;
            }
        });
    }

    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000);

</script>


@endsection
@endsection
