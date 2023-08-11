@extends('index')
@section('title', '| Evaluation')
@section('wrapper')
@parent

{{-- @author: Akash Chandra Debnath
@Behviour: Evaluation details, previous evaluation history, new evaluation create --}}

@section('content-wrapper')
@parent
@section('content-header')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3>Evaluation</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active">Evaluation </li>
          </ol>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          @if ($errors->any())
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
              <strong>{{ $message }} </strong>
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

@php
  $status= array("P"=>"Permanent", "C"=>"Contractual", "T"=>"Probationary", "R"=>"Regular");
  $userStatus = $empInfo->status;
  $create ='create';
@endphp
<!--edit here-->
@section('row')
  <div class="row">
    @if(Auth::user()->can('evaluation-create') && Auth::user()->username != $empInfo->emp_id)
    <div class="col-12 d-flex mb-3">
      <a href="{{ url('evaluations/'.$create.'/'.$empInfo->emp_id) }}" class="btn btn-sm btn-info ml-auto">New Evaluation</a>
    </div>
    @endif
    <div class="col-md-3">
      <!-- Profile Image -->
      <div class="card card-primary card-outline">
        <div class="card-body box-profile">
          <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('EmployeePhoto/'.$empInfo->image) }}" alt="User profile picture" \>
          </div>
          <h4 class="profile-username text-center">{{ $empInfo->name }}</h4>
          <p class="text-muted text-center text-success">{{ $empInfo->userDesignation ? $empInfo->userDesignation->designation : ''}}</p>
        </div>
        <!-- /.card-body -->
      </div>
        <!-- /.card -->
    </div>


    <!-- /.col -->
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">

          <table class="table table-borderless table-info">
            <tr class="bg-gradient-olive">
              <td colspan="2">
                <h6 class="py-1 h6 m-0"><i class="fas fa-address-card"></i> Information</h6>
              </td>
            </tr>
            <tr>
              <td><b>Employee ID</b></td>
              <td>{{ $empInfo->emp_id }}</td>
            </tr>
            <tr>
              <td><b>Grade</b></td>
              <td>{{ $empInfo->grade ? $empInfo->grade->grade : 'Null' }}</td>
            </tr>
            <tr>
              <td><b>Operational Designation</b></td>
              <td>{{ $empInfo->userDesignation ? $empInfo->userDesignation->designation : '' }}</td>
            </tr>
            <tr>
              <td><b>Department</b></td>
              <td>{{ $empInfo->department ? $empInfo->department->dept_name : '' }}</td>
            </tr>

            <tr>
              <td><b>Current Status</b></td>
              @foreach ($status as $key => $value)
                @if ($userStatus == $key)
                  <td>{{ $value }}
                    @if($empInfo->status_time != '')
                      (On {{ $empInfo->status_time }})
                    @endif
                  </td>
                @endif
              @endforeach
            </tr>
          </table>


          <table class="table table-bordered">
            <tr class="bg-gradient-olive">
              <td colspan="3">
                <h6 class="py-1 h6 m-0"><i class="fas fa-clipboard"></i> Evaluation Details</h6>
              </td>
            </tr>
            <tr>
                <th>Evaluation Term</th>
                <th>Evaluation Form</th>
                <th>Evaluation Status</th>
            </tr>
            @if($allEvaluation=='[]')
              <td colspan="3" class="badge badge-danger w-50 mx-auto">Not Found</td>
            @else
              @foreach ($allEvaluation as $evaluation)
                <tr>
                  <td> <strong>{{ $evaluation->eve_from }}</strong>  to  <strong>{{ $evaluation->eve_to }}</strong></td>
                  <td> <a href="{{ url('evaluations/'. $evaluation->id.'/'.$empInfo->emp_id) }}" class="btn btn-info btn-sm">show</a> </td>
                  @if($evaluation->admin_id == '0')
                    <td class="text-warning"><strong>Manager in Progress</strong></td>
                  @else
                    <td class="text-success" style="color:green;"><strong>Finished</strong></td>
                  @endif
                </tr>
              @endforeach
            @endif
          </table>

          <!-- /.tab-pane -->

          <!-- /.tab-content -->
        </div><!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->

  </div>

@endsection
@endsection
@endsection
@endsection


@section('script')
@parent

<script>
  setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
  }, 3000);
</script>

@endsection
@endsection
