@extends('index')
@section('title', '| Job-Description')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Job Description Board</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark</a></li>
                    <li class="breadcrumb-item"><a href="#">Job Description</a></li>
                    <li class="breadcrumb-item active">Job Description Board </li>
                </ol>
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
            <!-- ./card-header -->
            <div class="card-body d-flex justify-content-center">
               <div class="col-12 overflow-auto">
                <table class="table table-bordered  table-hover">
                    <thead>
                        <tr>
                            <th>ID </th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Grade</th>
                            <th>Job Description</th>
                        </tr>
                    </thead>
                    <tbody>
                     <?php $i=0;  ?>   
                    @foreach($department as $d)
                        <tr class="bg-primary" role="alert">
                            <td colspan="5">
                                <h6 class="ml-1 mb-0">
                                {{-- {{$e->emp->dept_code}} --}}
                                {{$d->dept_name}}  <?php $c=array(); array_push($c,$i);  
                                
                              $length = count($c); $j=0;
                                 
                                ?>
                                 @foreach($employee as $e)
                        
                                 @if($e->dept_code == $d->dept_code) @php $j=$j+1; @endphp @endif
                                 @endforeach
                                 ({{$j}})
                                </h6> 
                               
                            </td>
                        </tr>
                      
                       @foreach($employee as $e)
                        
                         @if($e->dept_code == $d->dept_code)
                          
                        <tr data-widget="expandable-table" aria-expanded="true">
                          
                            <td>{{$e->emp_id}} </td> 
                            <td>{{$e->name}} </td>
                            <td>{{$e->userDesignation ? $e->userDesignation->designation : ''}}</td>
                            <td>{{$e->grade ? $e->grade->grade : 'not added'}}</td>
                            {{-- <td>{{$e->emp_id}} --}}
                          
                            <td>@if(!is_null($e->job_desc))<a href={{"files/".$e->job_desc->file_name}} class="btn btn-primary btn-xs " download>Download</a> @if(Auth::user()->can('jobdescription-change'))<i class="fas fa-angle-right"></i> <a class="btn btn-warning btn-xs download"  onclick="getData({{$e->job_desc->id}})"  data-toggle="modal" data-target="#change"  >Change </a>  @endif @else 
                                
not found &nbsp;&nbsp;@if(Auth::user()->can('jobdescription-upload'))<i class="fas fa-angle-right"></i>&nbsp;&nbsp; <a class="btn btn-primary btn-xs download" onclick="getData({{ $e->emp_id }}) " data-toggle="modal" data-target="#upload" >Upload</a> @endif
                                
                                @endif </td>
                            
                        </tr>
                        <?php $i++; ?>
                         @endif
                       
                        @endforeach
                        
                    @endforeach
                    </tbody>
                </table>
               </div>


                 <!-- modal -->
                 <div class="modal fade" id="upload">
                    <div class="modal-dialog modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                
                                <h4 class="modal-title ">Upload file </h4>
                              
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form action="{{route('job.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @method('PUT') --}}
                                    {{-- {{method_field('put')}} --}}

                                        <div class="row">
                                            <input type="text" class="form-control" id="empId" name="empId" hidden >
                                            <div class="col-12">
                                                <label for="file">File input   </label>
                                                <input type="file" class="form-control"  name="file" id="file">
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
                <!--////modal--finish  -->


                 <!-- modal -->
                <div class="modal fade" id="change">
                    <div class="modal-dialog modal-dialog-centered ">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                                
                                <h4 class="modal-title ">Edit  file  </h4>
                              
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                    
                                <form action="{{ url('job-update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    {{-- {{method_field('put')}} --}}

                                        <div class="row">
                                            <input type="text" id="Id" name="Id" class="form-control">
                                            
                                            <div class="col-12">
                                                <label for="files">File input   </label>
                                                <input type="file" class="form-control"  name="files" id="files">
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
                <!--////modal--finish  -->
                
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
@endsection
<!-- end editing-->
@endsection
@endsection
@section('add-script')
@parent
<script>
    function getData(id) {
    $('#empId').val(id);
    // console.log(id);

    
    $('#Id').val(id);
    console.log(id);

    $.ajax({
            type: "GET",
            url: "edit-jobdesc/"+id,
            success: function(response){
                // console.log(response.job_desc_files);
                $('#files').val(response.job_desc_files.file_name);
                // $('#emp_id').val(response.job_desc_files.emp_id);
                
            },
            error: function (jqXhr, textStatus, errorMessage) { // error callback 
                console.log(errorMessage) ;
            }
        });

}

</script>
@endsection
@endsection
@endsection