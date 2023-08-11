@extends('index')
@section('title', '| Employee List')
@section('wrapper')
    @parent

    {{-- @author: Akash Chandra Debnath
    @Behaviour: Show all employees, can see individual employee profile --}}

    @section('content-wrapper')
        @parent
        @section('content-header')

            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>Employee List</h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Employee</a></li>
                                <li class="breadcrumb-item"><a href="#">All</a></li>
                                <li class="breadcrumb-item active">Employee List</li>
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
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-header py-2">

                                    <div class="container-fluid p-0">
                                        <div class="row">
                                            <div class="col-md-3 col-12">
                                                <form action="">
                                                    <select id="employee" class=" form-control select2"
                                                            style="width: 100%;"
                                                            onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                                                        <option value="" selected hidden> Search by ID or name</option>
                                                        @foreach ($employeeSearch as $e )
                                                            <option value="employees/{{ $e->emp_id }}">{{ $e->emp_id }}
                                                                - {{ $e->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </div>
                                            @if(Auth::user()->can('employee-create'))
                                            <div class="col-md-3 ml-auto mt-md-0 mt-3">
                                                <a class="btn btn-warning btn-md btn-block "
                                                   href="{{ route('employees.create') }}"> <span
                                                        class=" fas fa-plus "> </span> Add New Employee</a>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body overflow-auto">
                                    <table class="table table-hover table-bordered selectpicker"
                                           data-live-search="true">
                                        <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Status</th>
                                            <th>Joining Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i = $employees->currentPage() == 1 ? 0 : ($employees->currentPage() - 1) * 20 ?>
                                        @foreach ($employees as $index => $emp)
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $emp->emp_id }}</td>
                                                <td>
                                                    <a href="{{ route('employees.show', $emp->emp_id) }}">{{ $emp->name }}</a>
                                                </td>
                                                <td>{{ $emp->department ? $emp->department->dept_name:'' }}</td>
                                                <td>{{ $emp->userDesignation ? $emp->userDesignation->designation:'' }}</td>
                                                @if($emp->status == 'P')
                                                    <td>Permanent</td>
                                                @elseif($emp->status == 'R')
                                                    <td>Regular</td>
                                                @elseif($emp->status == 'C')
                                                    <td>Contractual</td>
                                                @elseif($emp->status == 'T')
                                                    <td>Probationary</td>
                                                @endif
                                                <td>{{ $emp->jdate }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer overflow-auto ">
                                    {!! $employees->withQueryString()->Links('pagination::bootstrap-4') !!}
                                </div>
                            </div>
                            <!-- end editing-->
                        </div>
                    </div>
                    </div>

                @endsection
            @endsection
        @endsection
    @endsection

    @section('add-script')
        <script>
            setTimeout(function () {
                $('#successMsg').fadeOut('slow');
                $('#failMsg').fadeOut('slow');
            }, 3000);
        </script>
    @endsection
@endsection
