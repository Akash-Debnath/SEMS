@extends('index')
@section('title', '| Attachment')

{{-- @author Akash Chandra Debnath
@Behviour Edit attachment- get details of attachment date, subject, department, content body and files then post request if need to update --}}

@section('wrapper')
@parent
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
                    <li class="breadcrumb-item"><a href="#">Remark </a></li>
                    <li class="breadcrumb-item"><a href="{{ route('attachment.index') }}">Attachment</a></li>
                    <li class="breadcrumb-item active">Edit Attachment </li>
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
<div class="row d-flex justify-content-center ">
    <div class="col-md-12">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('attachment.update', $attachment->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="date">Date</label>
                                <input type="date" name="message_date" value="{{ $attachment->message_date }}" id="date" class="form-control js-date-field bg-transparent">
                            </div>
                            <div class="col-md-6">
                                <label for="subject">Subject</label>
                                <input type="text" placeholder="Subject" id="subject" name="subject" class="form-control" value="{{ $attachment->subject }}">
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <label for="to">To</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <div class="form-group">
                                    <select id="dept" class="form-control" name="message_to">
                                        <option value="" selected hidden> Search by Department </option>
                                        <option></option>
                                    </select>

                                </div>
                            </div>
                            @php
                               $receivers = array_map('intval',explode(',',$attachment->custom_recipient))
                            @endphp
                            <div class="col-md-6 mt-md-0 mt-4">
                                <select id="emp" class="form-control select2" multiple="multiple" name="custom_recipient[]">
                                    @foreach ($employeeSearch as $searchEmp)
                                        @foreach ($receivers as $reciever)                                            
                                            <option value="{{  $searchEmp->id }}" {{$reciever == $searchEmp->id ?'selected':'' }}>{{ $searchEmp->id }} - {{$searchEmp->name }}</option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <label for="summernote">Message</label>
                                <textarea class="form-control" id="summernote" name="message" col="10" row="6">
                                    {!! $attachment->message !!}
                                 </textarea>
                            </div>
                        </div>
                    </div>
                    @php $i = 0; @endphp
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 form-group">
                                <div class="control-group" id="fields">
                                    <label class="control-label" for="field1"> Attached Files ({{ count($attachment->attachFiles) }})</label><hr>
                                    <div class="controls">
                                        @foreach($attachment->attachFiles as $f) 
                                        <p id="removeFile">{{ ++$i}}. {{$f->original_name}} &nbsp;<a href="" class="btn btn-danger btn-xs remove" onclick="deleteFile(event, {{ $f->id }})"> Remove</a></p>
                                        @endforeach
                                        <div class="entry input-group upload-input-group">
                                            <input class="form-control" name="filename[]" type="file">
                                            <button class="btn btn-upload btn-info btn-add" type="button"> <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-3">
                        <div class="row  d-flex justify-content-end">
                            <div class="col-md-2  ">
                                <button class="btn btn-sm btn-danger btn-block "> Cancel</button>
                            </div>
                            <div class="col-md-2 mt-2 mt-md-0">
                                <button class="btn btn-sm btn-info btn-block ">Done</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>
<!-- ./row -->

@endsection
@endsection
@endsection
@endsection



<!-- extra js section -->
@section('script')
@parent

<script>
    $(function(){
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Date field customization
        $('.js-date-field').flatpickr();

        //summernote
        $('#summernote').summernote()

    })


    $(function() {
        $(document).on('click', '.btn-add', function(e) {
            e.preventDefault();

            var controlForm = $('.controls:first'),
                currentEntry = $(this).parents('.entry:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);

            newEntry.find('input').val('');
            controlForm.find('.entry:not(:last) .btn-add')
                .removeClass('btn-add').addClass('btn-remove')
                .removeClass('btn-success').addClass('btn-danger')
                .html('<span class="fa fa-trash"></span>');
        }).on('click', '.btn-remove', function(e) {
            $(this).parents('.entry:first').remove();

            e.preventDefault();
            return false;
        });
    });

    // let removeItem = document.getElementById('removeFile');
    // console.log(removeItem);
    // removeItem.style.display='none';

    function deleteFile(e, id)
    {
        e.preventDefault();
        var base_url = $('meta[name="base-url"]').attr('content');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            url: base_url+'/delete-attachment-file/'+id,
            data: {
                // id : id,
            },
            success: function(response) {
                // window.location.reload();
                console.log('File Deleted Successfully!');
            },
            error: function(jqXhr, textStatus, errorMessage) {
                console.log(errorMessage);
            }
        });
    }


</script>

@endsection
@endsection