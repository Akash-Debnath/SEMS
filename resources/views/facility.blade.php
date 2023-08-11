@extends('index')
@section('title', '| Facility')
@section('wrapper')
@parent


{{-- @author Akash Chandar Debnath
@Behaviour show all facilities, can add, edit, update and delete specified facility --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Facility List</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                    <li class="breadcrumb-item"><a href="#">Facility</a></li>
                    <li class="breadcrumb-item active">Facility List</li>
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
            @if(Auth::user()->can('facility-create'))
                <div class="card-header d-flex justify-content-end">
                    <button type="button" class="btn btn-warning ml-auto btn-sm " data-toggle="modal" data-target="#modal-default">
                        <span class=" fas fa-plus "> </span> Add New Facility
                    </button>


                    <!-- modal -->
                    <div class="modal fade" id="modal-default">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Add Facility</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('facility.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="col-12">
                                                <label for="facility">Facility</label>
                                                <input type="text" placeholder="Enter.." id="facility" name="facility" class="form-control">
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-12">
                                                <label class="d-block" for="desc">Description</label>
                                                <textarea class="form-control" placeholder="Write description..." name="description" id="desc" cols="30" rows="3"></textarea>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="  col-3 col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm form-control" data-dismiss="modal">Close</button>
                                            </div>

                                            <div class=" col-md-3 col-5 ml-auto">
                                            <button type="submit" class="btn btn-info btn-sm form-control">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!--////modal--finish  -->
                </div>
            @endif

            <div class="card-body">
                <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Facility</th>
                            <th>Description</th>
                            @if (Auth::user()->can('facility-edit') || Auth::user()->can('facility-delete'))
                                <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php  $i = $facilities->currentPage()==1 ? 0 : ($facilities->currentPage() -1 )*20  @endphp
                        @foreach ($facilities as $f )
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $f->facility }}</td>
                                <td>{{ $f->description }}</td>
                                <td>
                                    <div class="row d-flex justify-content-center ">
                                        @if(Auth::user()->can('facility-edit'))
                                            <a class="btn  btn-warning btn-sm" onclick="getData({{ $f->id }})" data-toggle="modal" data-target="#editModal"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffffff" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg></a>
                                        @endif
                                        @if(Auth::user()->can('facility-delete'))
                                            <form action="{{ route('facility.destroy', $f->id ) }}" method="post"  >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm ml-1" onclick="return confirm('Are you sure want to delete facility : {{ $f->facility }}?')"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
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
                @if(Auth::user()->can('facility-edit'))
                    <div class="modal fade" id="editModal">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header bg-info">
                                    <h4 class="modal-title ">Edit Facility</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('update-facility') }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="facilityId" value="" id="facilityId" />

                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="facility">Facility</label>
                                                    <input type="text" id="f" name="facility" class="form-control">
                                                </div>
                                            </div>



                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="d-block" for="desc">Description</label>
                                                    <textarea class="form-control" id="description" name="description" cols="30" rows="3"></textarea>
                                                </div>
                                            </div>

                                        <div class="row d-flex justify-content-between">
                                            <div class="col-md-2 ">
                                                <button type="button" class="btn btn-danger btn-sm form-control" data-dismiss="modal">Close</button>

                                            </div>

                                            <div class="col-md-3 ">
                                                <button type="submit" class="btn btn-success btn-sm mt-2 mt-md-0 form-control" >Save Changes</button>
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
            <div class="card-footer overflow-auto ">
                {!! $facilities->Links('pagination::bootstrap-4') !!}
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

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>

    function getData(id) {
        $('#facilityId').val(id);
        $.ajax({
            type: "GET",
            url: "edit-facility/"+id,
            success: function(response){
                $('#f').val(response.facilities.facility);
                $('#description').val(response.facilities.description);
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
