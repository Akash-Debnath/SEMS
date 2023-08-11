@extends('index')
@section('title', '| Notice')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Show all notices, add new notice and can get route to details, edit, delete through select specific notice --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Notice Board</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">Notice </a></li>
                    <li class="breadcrumb-item active">Notice Board</li>
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
    <div class="col-md-12">
        <div class="card card-outline card-info">
            @section('card-elem')
            @yield('card')
            @if(Auth::user()->can('notice-create'))
            <div class="card-header">
                <div class="common-card-header">
                    <button type="button" class="btn btn-info ml-auto " data-toggle="modal" data-target="#modal-default">
                        <a class="anchor-btn" href="{{ route('notice.create') }}"><span class=" fas fa-plus "> </span> Add New Notice</a>
                    </button>
                </div>
            </div>
            @endif
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-hover table-bordered table-responsive-sm selectpicker" data-live-search="true">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Notice No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $notices->currentPage() == 1 ? 0 : ($notices->currentPage() - 1) * 20 ?>
                        @foreach ($notices as $notice)
                        <tr>
                            <td>{{++$i}}</td>
                            <td><a href="{{ route('notice.show', $notice->id) }}">{{ $notice->subject }}</td>
                            <td>{{ $notice->notice_date }}</td>
                            <td> {{ $notice->id }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer overflow-auto ">
                {!! $notices->Links('pagination::bootstrap-4') !!}
            </div>
            <div class="card-footer">
            </div>
            @show
        </div>
    </div>
    <!-- /.col-->
</div>


@endsection
<!-- end editing-->
@endsection
@endsection
@endsection

<script>
    $(function() {
        bsCustomFileInput.init();
    });

    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000);
</script>

@endsection