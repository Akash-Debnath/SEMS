@extends('index')
@section('title', '| Attachment')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@Behaviour Shoow selected attachment details and can edit/delete through corresponding button --}}

@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Attachment Detail</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#"> Remark</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('attachment') }}">Attachment</a></li>
                    <li class="breadcrumb-item active">Attach Detail</li>
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

    <div class="row">
        <!-- leave request by year table -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header bg-info ">
                   <div class="row">
                       <div class="col-md-8">
                        <p class="mb-0"><strong>Subject:</strong> {{ $attachmentDetails->subject }}</p>
                       </div>
                        <p class="mb-0 ml-md-auto "><strong>Date:</strong> {{ $attachmentDetails->message_date }} | &nbsp; @if(Auth::user()->can('attachment-edit'))<a href="{{ route('attachment.edit', $attachmentDetails->id) }}" class="btn btn-sm btn-warning  ">Edit</a>&nbsp; @endif
                            @if(Auth::user()->can('attachment-delete'))
                                <form action="{{ route('attachment.destroy', $attachmentDetails->id ) }}" method="post" >
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete?')">Delete</button>
                                </form>
                            @endif
                        </p>
                   </div>
                   @php $i=0; @endphp
                </div>
                <div class="card-body overflow-auto ">
                   {!! $attachmentDetails->message !!}
                </div>
                
                <hr>
                <hr style="border-top: dotted 2px;"/>
              
                <br><br>
                <div>
                    <h6 style="margin-left:20px">Attached Files({{count($attachmentDetails->attachFiles)}}) </h6><hr>
                    @foreach($attachmentDetails->attachFiles as $f) 
                        <p style="margin-left:20px">{{ ++$i}}. {{$f->original_name}} &nbsp;<a href={{ asset('AttachmentFiles/' . $f->filename) }} attributes-list download="{{ $f->original_name }}" class="btn btn-primary btn-xs download">Download</a></p>
                    @endforeach
                </div>
                <div class="card-footer ">
                   {{-- pagination --}}
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