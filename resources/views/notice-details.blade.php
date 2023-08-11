@extends('index')
@section('title', '| Notice')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@ Beahaviour show details of notice and get edit and delete button to go through--}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Notice Detail</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"> Remark</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('notice') }}">Notice </a></li>
                    <li class="breadcrumb-item active">Notice Detail</li>
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
        <!-- leave request by year table -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-info ">
                   <div class="row">
                       <div class="col-md-8">
                            <p class="mb-0"><strong>Subject:</strong> {{ $noticeDetails->subject }}</p>
                       </div>
                      
                       
                        <p class="mb-0 ml-md-auto "><strong>Date:</strong> {{ $noticeDetails->notice_date }} @if(Auth::user()->can('notice-edit')) | &nbsp;<a href="{{ route('notice.edit', $noticeDetails->id ) }}" method="post" class="btn btn-sm btn-warning  ">Edit</a> &nbsp; @endif

                            @if(Auth::user()->can('notice-delete'))
                            <form action="{{ route('notice.destroy', $noticeDetails->id ) }}" method="post" >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete?')">Delete</button>
                            </form>
                            @endif
                        </p>    
                   </div>
                </div>
                <div class="card-body overflow-auto ">
                    {!! $noticeDetails->notice !!}
                </div>
                <!-- /.card-body -->
                <div class="card-footer bg-info">
                   {{-- {!! $noticeDetails->Links('pagination::bootstrap-4') !!} --}}
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!--leave request part  -->
    </div>


@endsection
<!-- end editing-->
@endsection
@endsection
@endsection


@endsection