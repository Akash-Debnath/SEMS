@extends('index')
@section('title', '| Reset Password')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Change password --}}

@section('content-wrapper')
@parent
@section('content-header')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h5>Password</h5> --}}
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active">Change Password</li>
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
<div class="row d-flex justify-content-center ">
    <div class="col-md-5 mx-md-auto">
        <div class="card card-info">
            <div class="card-header ">
               <h6 class="mb-0 text-center">Change Password</h6>
            </div>
            <div class="card-body">
               <form action="{{ url('new-password-set') }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <div class="col-12">
                       <label for="current">Current Password</label>
                       <input type="password" name="current_password" id="" class="form-control" required>
                   </div>

                   <div class="col-12">
                        <label for="current">New Password</label>
                        <input type="password" name="new_password" id="" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label for="current">Re-type New Password</label>
                        <input type="password" name="new_password_confirmation" id="" class="form-control" required>
                    </div>
                    <div class="col-12 d-flex">
                        <button type="submit" class="btn btn-sm btn-info ml-auto">Save</button>
                    </div>
               </form>
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
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    });

    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);

</script>
@endsection


@endsection