@extends('index')
@section('title', '| Note')

{{-- @author Akash Chandra Debnath
@ Beahaviour show all notes in list, can add, view, edit, delete note ---}}

@section('wrapper')
    @parent
    @section('content-wrapper')
        @parent
        @section('content-header')

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Note List</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                <li class="breadcrumb-item"><a href="#">Note</a></li>
                                <li class="breadcrumb-item active">Note List</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @if ($errors->any())
                                <div class="w-100 alert alert-warning alert-dismissible fade show" id="successMsg"
                                     role="alert">
                                    <strong>{{ implode('', $errors->all(':message')) }}</strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif ($message = Session::get('success'))
                                <div class="w-100 alert alert-success alert-dismissible fade show" id="successMsg"
                                     role="alert">
                                    <strong>{{ $message }}</strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @elseif ($message = Session::get('fail'))
                                <div class="w-100 alert alert-warning alert-dismissible fade show" id="failMsg"
                                     role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                    <button type="button" class="close" role="alert" data-dismiss="alert"
                                            aria-label="Close">
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
                        <div class="col-12">
                            <div class="card card-primary">
                                @if(Auth::user()->can('note-create'))
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button" class="btn btn-warning ml-auto btn-sm" data-toggle="modal"
                                                data-target="#modal-default">
                                            <span class=" fas fa-plus "> </span> Add Note
                                        </button>

                                        <!-- modal -->
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog modal-dialog-centered ">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title ">Add a New Note</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('note.store') }}" method="POST"
                                                            enctype="multipart/form-data">
                                                            @csrf

                                                            <div class="gap">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label for="date">Date</label>
                                                                        <input type="date" placeholder="dd/mm/yyyy" id="date" name="date" class="form-control js-date-field bg-transparent">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label for="subject">Subject</label>
                                                                        <input type="text" placeholder="subject"
                                                                            id="subject"
                                                                            name="subject" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <label class="d-block" for="desc">Note</label>
                                                                        <textarea class="form-control" name="note" id="note"
                                                                                cols="30" rows="3"></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row  ">
                                                                    <div class="col-12 d-flex justify-content-between">
                                                                        <button type="button" class="btn btn-danger"
                                                                                data-dismiss="modal">Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-success">Save
                                                                            Changes
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                        <!--////modal--finish  -->
                                    </div>
                                @endif
                                <div class="card-body">
                                    <table class="table table-hover table-bordered  selectpicker"
                                           data-live-search="true">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Date</th>
                                            <th>Subject</th>
                                            @if (Auth::user()->can('note-view') || Auth::user()->can('note-create') || Auth::user()->can('note-delete'))
                                                <th class="text-center">Action</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $j = $notes->currentPage() == 1 ? 0 : ($notes->currentPage() - 1) * 20; ?>
                                        @foreach ($notes as $note)
                                            <td>{{ ++$j }}</td>
                                            <td>{{ $note->date }}</td>
                                            <td>{{ $note->subject }}</td>
                                            <td>
                                                <div class="row d-flex justify-content-center">
                                                    <!-- to view -->
                                                    @if(Auth::user()->can('note-view'))
                                                        <a class="btn btn-sm btn-success" onclick="showData({{ $note->id }})"
                                                        data-toggle="modal"
                                                        data-target="#view">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                                <path
                                                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <!-- to edit -->
                                                    @if(Auth::user()->can('note-edit'))
                                                        <a type="button" class="btn btn-sm btn-info ml-1  "
                                                        data-toggle="modal"
                                                        onclick="getData({{ $note->id }})" data-target="#edit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                fill="currentColor" class="bi bi-pencil-square"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                                <path fill-rule="evenodd"
                                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                    <!-- to delete -->
                                                    @if(Auth::user()->can('note-delete'))
                                                        <form action="{{ route('note.destroy', $note->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm ml-1"
                                                                    onclick="return confirm('Are you sure want to delete this note?')">
                                                                <svg
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16"
                                                                    fill="currentColor" class="bi bi-archive"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                        </tbody>
                                    </table>

                                    <!-- modal -->
                                    @if(Auth::user()->can('note-edit'))
                                        <div class="modal fade" id="edit">
                                            <div class="modal-dialog modal-dialog-centered ">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title ">Edit Note</h4>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ url('update-note') }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="noteId" value="" id="noteId"/>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="date">Date</label>
                                                                    <input type="date" placeholder="Enter.." id="from" name="date" class="form-control js-date-field bg-transparent">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="subject">Subject</label>
                                                                    <input type="text" placeholder="Enter.." id="sub" name="subject" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label class="d-block" for="desc">Note</label>
                                                                    <textarea class="form-control" name="note" id="details" cols="30" rows="3"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="row  ">
                                                                <div class="col-12 d-flex justify-content-between">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close </button>
                                                                    <button type="submit" class="btn btn-success">  Save Changes </button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endif
                                    <!--////modal--finish  -->

                                    <!-- modal -->
                                    @if(Auth::user()->can('note-view'))
                                        <div class="modal fade" id="view">
                                            <div class="modal-dialog modal-dialog-centered ">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-info">
                                                        <h4 class="modal-title ">Show Note</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="gap">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label for="date">Date</label>
                                                                    <input type="text" placeholder="Enter.." id="fromView" class="form-control" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="subject">Subject</label>
                                                                    <input type="text" placeholder="Enter.." id="subView" class="form-control" readonly>
                                                                </div>
                                                            </div>
        
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <label class="d-block" for="desc">Note</label>
                                                                    <textarea class="form-control" id="detailsView" cols="30" rows="3" readonly></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-2 ml-auto">
                                                                    <button type="button"  class="btn btn-danger btn-sm form-control" data-dismiss="modal">Close </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    @endif
                                    <!--////modal--finish  -->
                                </div>
                                <div class="card-footer overflow-auto ">
                                    {!! $notes->Links('pagination::bootstrap-4') !!}
                                </div>
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
            $(function () {
                $('.js-date-field').flatpickr();    //Date field customization
            });

            function getData(id) {
                $('#noteId').val(id);
                $.ajax({
                    type: "GET",
                    url: "edit-note/" + id,
                    success: function (response) {
                        $('#from').val(response.notes.date);
                        $('#sub').val(response.notes.subject);
                        $('#details').val(response.notes.note);
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        console.log(errorMessage);
                    }
                });
            }


            function showData(id) {
                $('#noteId').val(id);
                $.ajax({
                    type: "GET",
                    url: "edit-note/" + id,
                    success: function (response) {
                        $('#fromView').val(response.notes.date);
                        $('#subView').val(response.notes.subject);
                        $('#detailsView').val(response.notes.note);
                    },
                    error: function (jqXhr, textStatus, errorMessage) { // error callback
                        console.log(errorMessage);
                    }
                });
            }

            setTimeout(function () {
                $('#successMsg').fadeOut('slow');
                $('#failMsg').fadeOut('slow');
            }, 3000);

        </script>
    @endsection
@endsection
