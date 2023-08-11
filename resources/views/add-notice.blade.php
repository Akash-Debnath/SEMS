@extends('index')
@section('title', '| Notice')
@section('wrapper')
@parent

{{-- @author Akash Chandra Debnath
@ Beahaviour add new notice , fields: date, subject, content body ---}}

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
                    <li class="breadcrumb-item"><a href="#">Remark</a></li>
                    <li class="breadcrumb-item"><a href="#">Notice </a></li>
                    <li class="breadcrumb-item active">Notice Board </li>
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
            <div class="card-header">

            </div>
            <div class="card-body">
                <form action="{{ route('notice.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="date">Date</label>
                                <input type="date" id="date" placeholder="dd/mm/yyyy" name="notice_date" class="form-control dateField bg-transparent">
                            </div>
                            <div class="col-md-6 mt-md-0 mt-3">
                                <label for="subject">Subject</label>
                                <input type="text" placeholder="Subject" id="subject" name="subject" class="form-control">
                            </div>
                        </div>
                    </div>

   
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <label for="summernote">Message</label>
                                <textarea class="form-control" id="summernote" name="notice" col="10" row="5">Place <em>some</em> <u>text</u> <strong>here</strong></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid mt-3">
                        <div class="row  d-flex justify-content-end">
                            <div class="col-md-2  ">
                                <button class="btn btn-sm btn-danger btn-block ">
                                    Cancel</button>
                            </div>
                            <div class="col-md-2 mt-2 mt-md-0">
                                <button type="submit" class="btn btn-sm btn-info btn-block ">Done</button>
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


@section('script')
@parent
<script>
    $(function() {
        // Summernote
        $('#summernote').summernote()

        //Date Fielde cutomization
        $('.dateField').flatpickr();

        // CodeMirror
        CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
            mode: "htmlmixed",
            theme: "monokai"
        });
    })
</script>

<!-- custom file -->

<script>
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
</script>
@endsection
@endsection