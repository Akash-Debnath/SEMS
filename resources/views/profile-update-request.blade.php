@extends('index')
@section('title', '| Profile Update Request')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour show all request from individual employee want updated their profile, has approve and refuse action --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile Update Request</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Employee</a></li>
                    <li class="breadcrumb-item"><a href="#">All</a></li>
                    <li class="breadcrumb-item active">Profile Update Request </li>
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

<div class="col-12">
    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-bordered table-responsive-md table-responsive-xl">
                <thead>
                    <tr class="text-center">
                        <th>Sl No:</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Phone</th>
                        <th>Present Address</th>
                        <th>Permanent Address</th>
                        <th>Achievement</th>
                        <th>Experience</th>
                        <th>Date of Birth</th>
                        <th>Blood Group</th>
                        <th>Gender</th>
                        @if(Auth::user()->can('employee-profile-update-approve') || Auth::user()->can('employee-profile-update-reject'))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $i = 0; @endphp
                    @foreach ($updateRequests as $request)
                        <tr class="text-center">
                            <td>{{ ++$i }}</td>
                            <td>{{ $request->emp_id }}</td>
                            <td>{{ $request->employee ? $request->employee->name : '' }}</td>
                            <td>{{ $request->mobile }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>{{ $request->present_address }}</td>
                            <td>{{ $request->permanent_address }}</td>
                            <td>{{ $request->last_edu_achieve }}</td>
                            <td>{{ $request->experiance }}</td>
                            <td>{{ $request->dob }}</td>
                            <td>{{ $request->blood_group }}</td>
                            <td>{{ $request->gender }}</td>
                            @if(Auth::user()->can('employee-profile-update-approve') || Auth::user()->can('employee-profile-update-reject'))
                            <td>
                              @if(Auth::user()->can('employee-profile-update-approve'))  <button type="submit" class="btn btn-success btn-xs">Approve</button> @endif |  @if(Auth::user()->can('employee-profile-update-reject')) <button type="submit" class="btn btn-danger btn-xs">Reject</button> @endif
                            </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000); 
</script>
@endsection
@endsection