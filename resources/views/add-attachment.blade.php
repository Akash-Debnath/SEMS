@extends('index')
@section('title', '| Attachment')

{{-- @author Akash Chandra Debnath
@Behaviour add new attachment- date , subject, department, employee select and write content with multiple file attach --}}

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
                    <li class="breadcrumb-item"><a href="#">Attachment </a></li>
                    <li class="breadcrumb-item active">Attachment Board </li>
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
                <form action="{{ route('attachment.store') }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                  @csrf
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="date">Date</label>
                                <input type="date" id="date" name="message_date" class="form-control js-date-field bg-transparent" placeholder="dd/mm/yyyy">
                            </div>
                            <div class="col-md-6 mt-2 mt-md-0">
                                <label for="subject">Subject</label>
                                <input type="text" placeholder="Subject" id="subject" name="subject" class="form-control">
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
                                    <select id="dept" class="form-control ">
                                        <option value="" selected disabled> Search by Department </option>
                                        @foreach ($employeeDept as $empDept)
                                            <option name="message_to" value="$empDept->dept_code">{{ $empDept->dept_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-4">
                                <select id="emp" name="custom_recipient[]" class="select2" multiple="multiple" data-placeholder="Select ID or name" style="width: 100%;">
                                    @foreach ($employeeSearch as $searchEmp)
                                        <option value="{{  $searchEmp->id }}">{{ $searchEmp->id }} - {{$searchEmp->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <label for="summernote">Message</label>
                                <textarea class="form-control" id="summernote" name="message" col="10" row="6"> Place <em>some</em> <u>text</u> <strong>here</strong>
                                 </textarea>
                            </div>
                        </div>
                    </div>


                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12 form-group">
                                <div class="control-group" id="fields">
                                    <label class="control-label" for="field1"> Upload File </label>
                                    <div class="controls">
                                        <div class="entry input-group upload-input-group">
                                            {{-- <input class="form-control" name="fields[]" type="file"> --}}
                                            <input class="form-control" name="filename[]" type="file">
                                            <button class="btn btn-upload btn-info btn-add" type="button">
                                                <i class="fa fa-plus"></i>
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




<!-- extra js section -->
@section('script')
@parent

<script>
    $(function() {
        // Summernote
        $('#summernote').summernote()

        //Date filed customization
        $('.js-date-field').flatpickr();

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

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })
</script>
 

@endsection
@endsection