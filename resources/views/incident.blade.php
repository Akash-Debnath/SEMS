@extends('index')
@section('title', '| Incident')

{{-- @author Akash Chandra Debnath
@Behaviour show incidents by year, add, edit, update, delete incident --}}

@section('wrapper')
@parent
@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>List of Incidents</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark</a></li>
                    <li class="breadcrumb-item"><a href="#">Incident</a></li>
                    <li class="breadcrumb-item active">List of Incidents </li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if($errors->any())
                <div class="w-100 alert alert-warning alert-dismissible fade show" id="successMsg" role="alert">
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
     <div class="col-12">
        <div class="card">
            <div class="card-header">
        
                @php
                $already_selected_year = date('Y');
                $start_year = 2009;
                @endphp

                <div class="common-card-header">
                    <div class="form-group">
                        <form action="{{ url('incident') }}" method="GET">
                            <select id="year" name="date_year" class="form-control" onchange="this.form.submit()">
                                <option value="" selected hidden> --Select Year-- </option>
                                @foreach(range($already_selected_year, $start_year) as $year)
                                 <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}> {{ $year }}</option>
                                @endforeach       
                            </select>
                        </form>
                    </div>
                    @if(Auth::user()->can('incident-create'))
                        <div class="form-group ml-auto">
                            <button type="button" class="btn btn-info   " data-toggle="modal" data-target="#modal-default1">
                                <span class=" fas fa-plus "> </span> Add Incident
                            </button>
            
                            <!-- modal -->
                            <div class="modal fade" id="modal-default1">
                                <div class="modal-dialog modal-dialog-centered ">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title ">Add an Incident</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                            
                                            <form action="{{ route('incident.store') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="from">From</label>
                                                        <input type="date" name="date" placeholder="dd/mm/yyyy" class="form-control js-date-field bg-transparent" id="to">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="to">To</label>
                                                        <input type="date" placeholder="dd/mm/yyyy" class="form-control js-date-field bg-transparent" id="to">
                                                    </div>
                                                </div>
                                            
                        
                                            
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="desc">Description</label>
                                                        <textarea class="form-control" id="desc" name="description" cols="30" rows="3" placeholder="Write here..."></textarea>
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
                            <!--////modal--finish  -->
                        </div>
                    @endif
                </div>
        
            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered table-responsive-sm selectpicker" data-live-search="true">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Date</th>
                            <th>Description</th>
                            @if(Auth::user()->can('incident-edit') || Auth::user()->can('incident-delete'))
                                <th class="text-center">Action</th>
                            @endif
                        </tr>
                    </thead>
                    {{-- @if($incident=='')
                        <td colspan="4"class="badge badge-warning w-50 mx-auto">Data not found for this year!</td>
                    @else --}}
                        <tbody>
                            <?php $j = $incident->currentPage() == 1 ? 0 : ($incident->currentPage() - 1) * 20 ?>
                            @foreach ($incident as $i )
                            <tr>
                                <td>{{ ++$j }}</td>
                                <td>{{ $i->date }}</td>
                                <td>{{ $i->description }}</td>
                                <td class=" "> 
                                    <div class="row d-flex justify-content-center">
                                        @if(Auth::user('incident-edit'))
                                            <a class="btn btn-warning editbtn btn-sm"  data-toggle="modal" data-target="#editModal" onclick="getData({{ $i->id }})"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                            </a>
                                        @endif 
            
                                        @if(Auth::user()->can('incident-delete'))
                                            <form action="{{ route('incident.destroy', $i->id ) }}" method="post" class="ml-1" >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete?')"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                                    <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                </svg> </button> 
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>   
                            @endforeach
                        </tbody>
                    {{-- @endif --}}
                </table>
        
                <!--Edit modal -->
                @if(Auth::user()->can('incident-edit'))
                    <div class="modal fade" id="editModal">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title ">
                                        <h4>Edit Incident</h4>
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('update-incident') }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="incidentId" value="" id="incidentId" />
                                    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="from">From</label>
                                                    <input type="date" class="form-control js-date-field bg-transparent" id="date" name="date" >
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="to">To</label>
                                                    <input type="date" class="form-control js-date-field bg-transparent" id="date1" name="date1">
                                                </div>
                                            </div>
                                        
                    
                                    
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="desc">Description</label>
                                                    <textarea class="form-control" id="description" name="description" cols="30" rows="3"></textarea>
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
                <!--////Edit--modal--finish  -->
            </div>
            <div class="card-footer overflow-auto ">
                {!! $incident->Links('pagination::bootstrap-4') !!}
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
<script>

    function getData(id) {
        $('#incidentId').val(id);
        $.ajax({
            type: "GET",
            url: "edit-incident/"+id,
            success: function(response){
                $('#date').val(response.incident.date);
                $('#date1').val(response.incident.date);
                $('#description').val(response.incident.description);
            },
            error: function (jqXhr, textStatus, errorMessage) { 
                console.log(errorMessage) ;
            }
        });
    }

    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000); 


    //Date field customization
    $(function(){
        $('.js-date-field').flatpickr();
    });

</script>
@endsection
@endsection