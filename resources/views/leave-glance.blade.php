@extends('index')
@section('title', '| Leave')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Leave at a Glance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Leave</a></li>
                    <li class="breadcrumb-item"><a href="#">Leave-list</a></li>
                    <li class="breadcrumb-item active">Leave </li>
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
        <div class="card card-primary">
            <div class="card-header ">

                <form action="{{route('search')}}"  method="post">
                    @csrf
                    <div class="container-fluid">
                        <div class="row gap-5">
                            <div class="col-md-3">

                                <select id="year" class="form-control" name="year">
                                    <option value="" selected hidden> Leave In </option>
                                    <?php $from=date('2009-01-01'); $to=date('Y-m-d'); $startTime=strtotime( $from );
                                        $endTime=strtotime( $to );


                                        for($i = $startTime; $i <= $endTime; $i = $i + (86400*366)){
                                            $thisDate = date('Y',$i);?>
                                    <option>
                                        <?php echo $thisDate; ?>
                                    </option>
                                    <?php
                                            }
                                            ?>

                                </select>

                            </div>

                            <div class="col-md-3 mt-md-0 mt-2 ml-auto">
                                <select class="form-control select2" name="department[]" style="width: 100%;" multiple data-placeholder='Department'>
                                    @foreach($department as $d)
                                    <option value="{{$d->dept_code}}">{{$d->dept_name}}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-3 mt-md-0 mt-2 ml-auto">
                                <select class="form-control select2" name="type[]" style="width: 100%;" multiple data-placeholder="Leave Type">

                                    @foreach($option as $lt)
                                    <option value="{{$lt->option_code}}">{{$lt->option_value}}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="col-md-2 mt-md-0 mt-2 ml-auto">

                                {{-- <button class="btn btn-info form-control"> <span class="fas fa-search"></span>
                                    Search</button> --}}
                                <input class="btn btn-warning form-control" type="submit" value="search" name="search">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body   d-flex justify-content-center">

                <div class="col-12 overflow-auto">
                    <table class="table table-bordered table-hover leave-glance">
                        <thead class="text-center">
                            <th>ID</th>
                        <th>Name</th>
                        @foreach($leave_type as $lt)
                        <th>{{$lt->option_value}}</th>
                        @endforeach

                        </thead>

                        <tbody>

                           @foreach($dept as $d)
                           <tr>
                             <td colspan="@php echo count($leave_type)+2; $j=0; @endphp" class="bg-info">{{$d->dept_name}} @foreach($d->employee as $e) @if($e->archive=='N') @php $j=$j+1; @endphp @endif  @endforeach [ {{$j}} ]</td>

                           </tr>

                           @foreach($d->employee as $e)
                           @if($e->archive =='N')
                           <tr >
                            <td class="text-center">{{$e->emp_id}}</td>
                            <td class="text-center">{{$e->name}}</td>
                             @foreach($leave_type as $lt)
                             @php $days = array(); @endphp
                             <td class="text-center"> @foreach($leave as $l)
                                   @if($l->emp_id == $e->emp_id && $lt->option_code==$l->leave_type)
                                   {{-- {{$l->leave_type}} --}}
                                   @php array_push($days,$l->period); @endphp
                                   @endif

                                  @endforeach

                                  @php print_r(array_sum($days)); @endphp

                            </td>
                             @endforeach
                           </tr>
                           @endif
                           @endforeach

                           @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
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
