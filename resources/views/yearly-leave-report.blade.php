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
                    <h4>All Leave Taken by Employee</h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Leave</a></li>
                        <li class="breadcrumb-item"><a href="#">All_leave</a></li>
                        <li class="breadcrumb-item active">All Leave Taken by Employee </li>
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
                <div class="card-header ">
                    <form action="{{ route('emp.show') }}" class="" id="form" method="post">
                        @csrf

                        <div class="row gap-5">

                            {{-- {{route('emp.show')}} --}}
                            <div class="col-md-3 mt-md-0 mt-2 ">


                                <select name="dept[]" id="dept" class="select2" multiple="multiple"
                                    data-placeholder="Select Department" style="width: 100%;">


                                    @foreach ($dept as $d)
                                        <option data-state="{{ $d->dept_code }}" value="{{ $d->dept_code }}">
                                            {{ $d->dept_name }}</option>
                                    @endforeach

                                </select>




                            </div>

                            <div class="col-md-3 mt-md-0 mt-2 ml-auto">


                                <select name="emp[]" id="staff" class="select2" multiple="multiple"
                                    style="width: 100%;" data-placeholder="Select Staff">
                                </select>

                            </div>
                            <div class="col-md-2 mt-md-0 mt-2 ml-auto">

                                <button class="btn btn-info form-control" type="submit" name="search"> <span
                                        class="fas fa-search"></span> Search</button>
                            </div>
                        </div>

                    </form>


                </div>
                <div class="card-body overflow-auto ">
                    <table class="table table-bordered table-hover ">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Leave Type</th>
                                <th colspan="15" class="text-center"> year</th>
                            </tr>
                            <tr class="text-center">

                                <?php $from=date('2008-01-01'); $to=date('Y-m-d'); $startTime=strtotime( $from );
                                        $endTime=strtotime( $to ); 
                                        
                                        $year = array();
                                        for($i = $endTime; $i >= $startTime; $i = $i - (86400*366)){
                                            $thisDate = date('Y',$i);
                                           $a = array_push($year,date('Y',$i));
                                            ?>
                                <th>
                                    <?php echo $thisDate;
                                    ?>
                                </th>
                                <?php 
                                            }
                                            ?>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $e)
                                <tr>
                                    <td colspan="@php print_r(count($year)+1) @endphp" class="bg-info">{{ $e->name }}
                                    </td>
                                </tr>
                                @foreach ($option as $o)
                                    <tr class="text-center">
                                        <td>{{ $o->option_value }}</td>

                                        @foreach ($year as $y)
                                            @php $period = array(); @endphp
                                            <td>
                                                @foreach ($e->leave as $l)
                                                    @if ($o->option_code == $l->leave_type &&
                                                        $y == date('Y', strtotime($l->leave_start)) &&
                                                        $l->admin_approve_date != null &&
                                                        $l->m_approved_date != null)
                                                        {{-- {{$l->period}} --}}
                                                        @php array_push($period,$l->period) @endphp
                                                    @endif
                                                @endforeach

                                                @php print_r(array_sum($period)); @endphp

                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->

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

    $('#dept').on('change', function() {
        var selectedDptItem = $('#dept').val();
        $('#staff').empty();
        let _token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "GET",
            url: "multiple-department-employees",
            data: {
                dptList: selectedDptItem
            },
            dataType: 'json',
            encode: true,
            success: function(response) {

                var employeeOptions = "";

                response.employeeData.forEach(function(item) {
                    employeeOptions += `<option  value="` + item.emp_id + `" >` + item.name + `</option>`;
                })
                $('#staff').append(employeeOptions)
            },
            error: function(jqXhr, textStatus, errorMessage) { // error callback 
                console.log(errorMessage);
            }
        });
    })
</script>
@endsection
@endsection
