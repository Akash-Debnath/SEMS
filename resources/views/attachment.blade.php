@extends('index')
@section('title', '| Attachment')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Show all attachments --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Attachment Board</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark
                        </a></li>
                    <li class="breadcrumb-item"><a href="#">Attachment</a></li>
                    <li class="breadcrumb-item active">Attachment Board</li>
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

            @if(Auth::user()->can('attachment-create'))
                <div class="card-header">
                    <div class="common-card-header">
                        <button type="button" onclick="location.href ="; class="btn btn-info ml-auto" data-toggle="modal" data-target="#modal-default">
                            <a class="anchor-btn" href="{{ route('attachment.create') }}"><span class=" fas fa-plus "> </span> Add New Attachment</a>
                        </button>
                    </div>
                </div>
            @endif

            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-hover table-bordered  selectpicker" data-live-search="true">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Subject</th>
                            <th>From</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $attachments->currentPage() == 1 ? 0 : ($attachments->currentPage() - 1) * 20 ?>
                        @foreach ($attachments as $file )
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><a href="{{ route('attachment.show', $file->id) }}">{{ $file->subject }}</td>
                                <td>{{ $file->employee ? $file->employee->name : 'Not found' }}</td>
                                <td>{{ $file->message_date }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="card-footer overflow-auto ">
                {!! $attachments->Links('pagination::bootstrap-4') !!}
            </div>
            <div class="card-footer">
            </div>

        </div>
    </div>
    <!-- /.col-->
</div>


@endsection
<!-- end editing-->
@endsection
@endsection
@endsection



@section('add-script')
<script>
    setTimeout(function() {
    $('#successMsg').fadeOut('slow');
    $('#failMsg').fadeOut('slow');
    }, 3000); 
</script>
@endsection
@endsection