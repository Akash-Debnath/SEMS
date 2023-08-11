@extends('index')
@section('title', '| Evaluation')
@section('wrapper')
@parent

{{-- @author: Akash Chandra Debnath
@Behaviour: Evaluation create form --}}

@section('content-wrapper')
@parent
@section('content-header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Evaluation Form</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Evaluation</li>
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
   <div class="col-12">
          
    <div class="row mt-3">
        <div class="col-12">
            <div class="card  card-info  ">
                <div class="card-header">
                    <h5 class="h5 display-5 text-center mb-0">EMPLOYEE PERFORMANCE EVALUATION</h5>
                </div>

                @php
                    $start = $evaluationInfo==null ? $empInfo->jdate : $evaluationInfo->employee->jdate;
                    $date1 = new DateTime($start);
                    $date2 = new DateTime('today');
                    $diff = $date2->diff($date1);
                @endphp

                <div class="card-body">
                <form action="{{ route('evaluation.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="tab-content">
                        <div class="active tab-pane" id="part1">
                        
                            <div class="gap">
                                <div class="row">
                                    <input type="hidden" name="emp_id" value="{{ $evaluationInfo==null ? $empInfo->emp_id : $evaluationInfo->employee->emp_id }}" class="form-control ">
                                    <div class="col-md-6">
                                        <label for="ename" class="text-nowrap mr-2">Employee Name</label>
                                        <input type="text" name="" value="{{ $evaluationInfo==null ? $empInfo->name : $evaluationInfo->employee->name }}" id="" class="form-control " disabled>
                                    </div>
                                    <div class="col-md-6 ">
                                        <label for="ename" class="text-nowrap mr-2">Job Title</label>
                                        <input type="text" name="" value="{{ $evaluationInfo==null ? $empInfo->userDesignation->designation : $evaluationInfo->employee->userDesignation->designation }}" id="" class="form-control" disabled>
                                    </div>

                                </div>

                        

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="ename" class="text-nowrap mr-2">Department</label>
                                        <input type="text" name="" value="{{ $evaluationInfo==null ? $empInfo->department->dept_name : $evaluationInfo->employee->department->dept_name }}" id="" class="form-control" disabled>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="ename" class="text-nowrap mr-2">Time with the Organization</label>
                                        <input type="text" name="" value="{{ $diff->format("%y years %m months %d days") }}" id="" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-left">
                                        <label for="ename" class="">Period of Evaluation</label>
                                    </div>
                                </div>
                               
                                <div class="row jumbotron m-0">
                                    <div class="col-md-6 ">
                                        @if($evaluationInfo==null) 
                                        <label for="ename" class="mr-2">From</label>
                                        <input type="date" name="eve_from" value="" id="sdate" class="form-control borderless dateField bg-white" placeholder="dd/mm/yyyy">
                                        @else
                                        <label for="ename">From</label>
                                        <input type="date" name="eve_from" value="{{ $evaluationInfo->eve_from }}" id="sdate" class="form-control borderless dateField bg-white">
                                        @endif
                                    </div>
                                   
                                    <div class="col-md-6">
                                        @if($evaluationInfo==null) 
                                        <label for="ename" class="mr-2">To</label>
                                        <input type="date" name="eve_to" value="" id="edate" class="form-control borderless dateField bg-white" placeholder="dd/mm/yyyy">
                                        @else
                                        <label for="ename">To</label>
                                        <input type="date" name="eve_to" value="{{ $evaluationInfo->eve_to }}" id="edate" class="form-control borderless dateField bg-white">
                                        @endif
                                    </div>
                                </div>

                                {{-- <div class="row">
                                    <div class="col-md-3 d-flex align-items-center justify-content-start justify-content-md-end">
                                        <label for="ename">Time in Current Position</label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="text" name="" value="Md. Habibur Rahman" id="" class="form-control" disabled>
                                    </div>
                                </div> --}}

                                @php
                                    $start = $evaluationInfo ? $evaluationInfo->eve_from : '0000-00-00';
                                    $date1 = new DateTime($start);
                                    $end = $evaluationInfo ? $evaluationInfo->eve_to : '0000-00-00';
                                    $date2 = new DateTime($end);
                                    $diff = $date2->diff($date1);
                
                                    $noOfYears = $diff->y;
                                    $month = $diff->m;
                                    $day = $diff->d;
                                @endphp

                                <div class="row jumbotron m-0">
                                    <div class="col-md-6">
                                       <strong class="d-block mb-2">Time in Current Position</strong> 

                                        <div class="btn-group">
                                            <label class="control-label normal " for="pos_year"> <select
                                                class="selectpicker" id="pos_year" data-width="auto" disabled>
                                                <option value="{{ $noOfYears }}">{{ $noOfYears }}</option>
                                            </select> Year(s) 
                                            </label>  <label class="control-label normal mx-4" for="pos_month">
                                                <select class="selectpicker" id="pos_month" data-width="auto" disabled>
                                                <option value="{{ $month }}">{{ $month }}</option>
                                            </select> Month(s) 
                                            </label> <label class="control-label normal" for="pos_day"> <select
                                                class="selectpicker" id="pos_day" data-width="auto" disabled>
                                                <option value="{{ $day }}">{{ $day }}</option>
                                            </select> Day(s)
                                            </label>
                                        </div>
                                    </div>
                                   


                                    <div class="col-md-6 mb-2">
                                        <label for="ename" class="mb-2">Employee Status</label>

                                        <div class="form-inline d-flex justify-content-between">
                                            <label class="radio-inline"><input class="mr-1" type="radio" name="status" value="T" {{ $evaluationInfo==null ? ($empInfo->status=="T" ? 'checked' : '') : ($evaluationInfo->employee->status =="T" ? 'checked' : '') }} disabled="" > Probationary</label><label class="radio-inline"><input class="mr-1" type="radio" name="status" value="C" {{ $evaluationInfo==null ? ($empInfo->status=="C" ? 'checked' : '') : ($evaluationInfo->employee->status=="C" ? 'checked' : '') }} disabled=""> Contractual</label><label class="radio-inline"><input class="mr-1" type="radio" name="status" value="R" {{ $evaluationInfo==null ? ($empInfo->status=="R" ? 'checked' : '') : ($evaluationInfo->employee->status=="R" ? 'checked' : '') }} disabled=""> Regular</label><label class="radio-inline"><input class="mr-1" type="radio" name="status" value="P" {{ $evaluationInfo==null ? ($empInfo->status=="P" ? 'checked' : '') : ($evaluationInfo->employee->status=="P" ? 'checked' : '') }} disabled> Permanent</label>
                                        </div>
                                    </div>
                                 
                                        
                                </div>


                             

                                @include('partials.eva-form')
                            </div>

                        </div>
            
            
                        <div class="tab-pane " id="part2">
                            <div class="gap">
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART II - PERFORMANCE FACTORS</h5>
                                </div>
                            </div>
                                {{-- (1) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>1. Knowledge, Skills, Abilities:</b>  Consider the degree to which the employee exhibits the required level of job knowledge and/or skills to perform the job and this employee's use of established techniques, materials and equipment as they relate to performance.</p>
                                </div>
                            </div>

                            @php
                                $points = array(1, 2, 3, 4, 5);
                            @endphp

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                        {{-- <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label ml-3" for="flexRadioDefault1"> --}}
                                        @php 
                                            $ksa = $evaluationInfo ? $evaluationInfo->ksa : '';
                                            foreach ($points as $val)
                                            {
                                            echo "<label class='radio-inline mx-4'> <input type='radio' name='ksa' value='$val' ";
                                            if($ksa == $val) echo " checked ";
                                            echo " /> $val</label>";
                                            }
                                        @endphp
                                        {{-- </label> --}}
                                        </div>
                                        
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="ksa_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="ksa_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->ksa_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(1) --}}

                                {{-- (2) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>2. Quality of Work:</b>  Does the employee complete assignments meeting quality standards? Consider accuracy, neatness, thoroughness and adherence to standards and safety rules.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            @php 
                                            $qlw = $evaluationInfo ? $evaluationInfo->qlw : '';
                                            foreach ($points as $val)
                                            {
                                            echo "<label class='radio-inline mx-4'> <input type='radio' name='qlw' value='$val' ";
                                            if($qlw == $val) echo " checked ";
                                            echo " /> $val</label>";
                                            }
                                        @endphp
                                        </div>
                                        
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="qlw_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="qlw_comments" id="" cols="30" rows="3" class="form-control">{{$evaluationInfo==null ? '' : $evaluationInfo->qlw_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(2) --}}

                            {{-- (3) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>3. Quantity of Work:</b>  Consider the results of this employee's efforts. Does the employee demonstrate the ability to manage several responsibilities simultaneously; perform work in a productive and timely manner; meet work schedules?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            @php 
                                            $qtw = $evaluationInfo ? $evaluationInfo->qtw : '';
                                            foreach ($points as $val)
                                            {
                                            echo "<label class='radio-inline mx-4'> <input type='radio' name='qtw' value='$val' ";
                                            if($qtw == $val) echo " checked ";
                                            echo " /> $val</label>";
                                            }
                                        @endphp
                                        </div>
                                        
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="qtw_f" min="1" max="5" step="0.1" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="qtw_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->qtw_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(3) --}}

                            {{-- (4) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>4. Work Habits:</b>  To what extent does the employee display a positive, cooperative attitude toward work assignments and requirements? Consider compliance with established work rules and organizational policies.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            @php 
                                            $wh = $evaluationInfo ? $evaluationInfo->wh : '';
                                            foreach ($points as $val)
                                            {
                                            echo "<label class='radio-inline mx-4'> <input type='radio' name='wh' value='$val' ";
                                            if($wh == $val) echo " checked ";
                                            echo " /> $val</label>";
                                            }
                                        @endphp
                                        </div>
                                        
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="wh_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="wh_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' :$evaluationInfo->wh_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(4) --}}

                            {{-- (5) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>5. Communication:</b>  Consider job related effectiveness in dealing with others. Does the employee express ideas clearly both orally and in writing, listen well and respond appropriately?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                        <div class="form-check">
                                            @php 
                                            $com = $evaluationInfo ? $evaluationInfo->com : '';
                                            foreach ($points as $val)
                                            {
                                            echo "<label class='radio-inline mx-4'> <input type='radio' name='com' value='$val' ";
                                            if($com == $val) echo " checked ";
                                            echo " /> $val</label>";
                                            }
                                        @endphp
                                        </div>  
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="com_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="com_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->com_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(5) --}}
                            </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane " id="part3">
                        <div class="gap">
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART III - BEHAVIORAL TRAITS</h5>
                                </div>
                            </div>
                                {{-- (1) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>1. Dependability:</b>  Consider the amount of time spent directing this employee. Does the employee monitor projects and exercise follow-through; adhere to time frames; is on time for meetings and appointments; and responds appropriately to instructions and procedures?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $dep = $evaluationInfo ? $evaluationInfo->dep : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='dep' value='$val' ";
                                        if($dep == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="dep_f" step="0.1" max="5" min="1" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="dep_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->dep_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(1) --}}

                            {{-- (2) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>2. Cooperation:</b>  How well does the employee work with co-workers and supervisors as a contributing team member? Does the employee demonstrate consideration of others; maintain rapport with others; help others willingly?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $coo = $evaluationInfo ? $evaluationInfo->coo : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='coo' value='$val' ";
                                        if($coo == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                    
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="coo_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="coo_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->coo_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(2) --}}

                            {{-- (3) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>3. Initiative:</b>  Consider how well the employee seeks and assumes greater responsibility, monitors projects independently, and follows through appropriately.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $ini = $evaluationInfo ? $evaluationInfo->ini : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='ini' value='$val' ";
                                        if($ini == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div> 
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="ini_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="ini_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->ini_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(3) --}}

                            {{-- (4) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>4. Adaptability:</b>  Consider the ease with which the employee adjusts to any change in duties, procedures, supervisors or work environment. How well does the employee accept new ideas and approaches to work, respond appropriately to constructive criticism and to suggestions for work improvement?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check ">
                                        @php 
                                        $ada = $evaluationInfo ? $evaluationInfo->ada : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='ada' value='$val' ";
                                        if($ada == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                    
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="ada_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="ada_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->ada_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(4) --}}

                            {{-- (5) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>5. Judgment:</b>  Consider how well the employee effectively analyzes problems, determines appropriate action for solutions, and exhibits timely and decisive action; thinks logically.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $jud = $evaluationInfo ? $evaluationInfo->jud : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='jud' value='$val' ";
                                        if($jud == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" step="0.1" min="1" max="5" name="jud_f" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="jud_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->jud_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(5) --}}

                            {{-- (6) --}}
                        <div class="row">
                            <div class="col-12">
                                <p class="mb-0"> <b>6. Attendance:</b>  Consider number of absences, use of annual and sick leave in accordance with Genuity Systems Ltd. policy.</p>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                    @php 
                                    $att = $evaluationInfo ? $evaluationInfo->att : '';
                                    foreach ($points as $val)
                                    {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' class='evaluation-factor' name='att' value='$val' ";
                                        if($att == $val) echo " checked ";
                                        echo " /> $val</label>";
                                    }
                                    @endphp
                                    </div>
                                    
                            </div>

                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                <label for="ci">Custom Value:</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" step="0.1" min="1" max="5" name="att_f" id="">
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                            <div class="col-md-10">
                                <textarea name="att_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->att_comments }}</textarea>
                            </div>
                        </div>
                        {{-- //(6) --}}

                        {{-- (7) --}}
                        <div class="row">
                        <div class="col-12">
                            <p class="mb-0"> <b>7. Punctuality: </b>  Consider work arrival and departure in accordance with departmental and Company Policy.

                            </p>
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                            <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                    @php 
                                    $pun = $evaluationInfo ? $evaluationInfo->pun : '';
                                    foreach ($points as $val)
                                    {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='pun' value='$val' ";
                                        if($pun == $val) echo " checked ";
                                        echo " /> $val</label>";
                                    }
                                    @endphp
                                    </div>                                         
                            </div>

                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                <label for="ci">Custom Value:</label>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" name="pun_f" step="0.1" min="1" max="5" id="">
                            </div>
                        </div>

                        <div class="row ">
                            <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                            <div class="col-md-10">
                                <textarea name="pun_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->pun_comments }}</textarea>
                            </div>
                        </div>
                        {{-- //(7) --}}
                        </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane " id="part4">
                        <div class="gap">
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART IV - SUPERVISORY FACTORS</h5>
                                </div>
                            </div>
                                {{-- (1) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>1. Leadership:</b>   Consider how well the employee demonstrates effective supervisory abilities; gains respect and cooperation; inspires and motivates subordinates; directs work group toward common goal.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        @php 
                                        $led = $evaluationInfo ? $evaluationInfo->led : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='led' value='$val' ";
                                        if($led == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>                                           
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="led_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="led_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->led_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(1) --}}

                                {{-- (2) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>2. Delegation:</b>  How well does the employee demonstrate the ability to direct others in accomplishing work; effectively select and motivate staff; define assignments; oversee the work of subordinates?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $del = $evaluationInfo ? $evaluationInfo->del : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='del' value='$val' ";
                                        if($del == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" step="0.1" min="1" max="5" name="del_f" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="del_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->del_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(2) --}}

                                {{-- (3) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>3. Planning and Organizing:</b>  Consider how well the employee plans and organizes work; coordinates with others, and establishes appropriate priorities; anticipates future needs; carries out assignments effectively.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $pla = $evaluationInfo ? $evaluationInfo->pla : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='pla' value='$val' ";
                                        if($pla == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" step="0.1" min="1" max="5" name="pla_f" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="pla_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->pla_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(3) --}}

                                {{-- (4) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>4. Administration: </b>  How well does the employee perform day-to-day administrative tasks; manage time; administer policies and implement procedures; maintain appropriate contact with supervisor and utilize funds, staff or equipment?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $adm = $evaluationInfo ? $evaluationInfo->adm : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='adm' value='$val' ";
                                        if($adm == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>                                           
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="adm_f" step="0.1" min="1" max="5" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="adm_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->adm_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(4) --}}

                                {{-- (5) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> <b>5. Personnel Management:</b>  Consider how well the employee serves as a role model; provides guidance and opportunities to their staff for their development and advancement; resolves work-related employee problems; assists subordinates in accomplishing their work-related objectives. Does the employee communicate well with subordinates in a clear, concise, accurate, and timely manner and make useful suggestions?</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $per = $evaluationInfo ? $evaluationInfo->per : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='per' value='$val' ";
                                        if($per == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>                                           
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" step="0.1" min="1" max="5" name="per_s" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="per_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->per_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(5) --}}

 
                        </div>
                        </div>
                        <!-- /.tab-pane -->

                        <div class="tab-pane " id="part5">
                        <div class="gap">
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART V - OVERALL PERFORMANCE</h5>
                                </div>
                            </div>
                            {{-- (1) --}}
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> Please use this space to describe the overall performance rating. The overall rating should be a reflection of the performance factors, behavioral traits and supervisory factors.</p>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-6 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $opr = $evaluationInfo ? $evaluationInfo->opr : '';
                                        foreach ($points as $val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='opr' value='$val' ";
                                        if($opr == $val) echo " checked ";
                                        echo " /> $val</label>";
                                        }
                                    @endphp
                                    </div>                                           
                                </div>

                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end">
                                    <label for="ci">Custom Value:</label>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" step="0.1" min="1" max="5" name="opr_f" id="">
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="opr_comments" id="opr_comments" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->opr_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(1) --}}

                            {{-- (2) --}}
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART VI - HUMAN BEING FACTORS</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0"> Consider the degree of human personality that how he or she is received to his colleagues in regard of Social Behavior.</p>
                                </div>
                            </div>

                            @php
                            $humanbf = array("1"=>"Unsocial", "2"=> "Almost Social" , "3"=>"Social", "4"=>"More than Social","5"=>"Superior")
                            @endphp

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="rating">Rating</label> </div>
                                <div class="col-md-10 d-flex justify-content-between">
                                    <div class="form-check">
                                        @php 
                                        $hbf = $evaluationInfo ? $evaluationInfo->hbf : '';
                                        foreach ($humanbf as $key=>$val)
                                        {
                                        echo "<label class='radio-inline mx-4'> <input type='radio' name='hbf' value='$key' ";
                                        if($hbf == $key) echo " checked ";
                                        echo " />$key ($val)</label>";
                                        }
                                    @endphp
                                    </div>                                           
                                </div>

                                
                            </div>
                            <div class="row">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"><label for="cv">Custom Value:</label></div>
                                <div class="col-md-3">
                                    <input type="number" name="hbf_f" step="0.1" min="1" max="5" id="" class="form-control">
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="hbf_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->hbf_comments }}</textarea>
                                </div>
                            </div>
                            {{-- //(2) --}}

                                {{-- (3) --}}
                                <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART VII - SIGNATURE OF MANAGER </h5>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-2"><label for="rater">Rater:</label></div>
                                        <div class="col-7 border-bottom">
                                        {{-- <p class="mb-0 text-center"> {{ Auth::user()->username }}</p> --}}
                                        <p class="mb-0 text-center"> {{ $evaluationInfo==null ? Auth::user()->username : $evaluationInfo->admin_id }}</p>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-2"><label for="rater">Date:</label></div>
                                        <div class="col-7 border-bottom text-center">
                                            <p class="mb-0">{{ $evaluationInfo==null ? date('Y-m-d') : $evaluationInfo->man_sig_date }}</p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                {{-- //(3) --}}

                                {{-- (4) --}}
                                <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART VIII - TO THE EMPLOYEE
                                    </h5>
                                </div>
                                </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="mb-0">  I have been advised of my performance ratings. I have discussed the contents of this review with my Manager. My signature does not necessarily imply agreement. My comments are as follows (optional) (attach additional sheets if necessary):</p>
                                </div>
                            </div>


                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="emp_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->emp_comments }}</textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                <label for="att">Attachment</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-2"><label for="rater">Signature: </label></div>
                                        <div class="col-7 border-bottom text-center">
                                        <p class="mb-0"> {{ $evaluationInfo==null ? $empInfo->name : $evaluationInfo->employee->name }} </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-2"><label for="rater">Date:</label></div>
                                        <div class="col-7 border-bottom text-center">
                                        {{-- <p class="mb-0 text-center">{{ date('Y-m-d') }}</p> --}}
                                        <input type="text" style="border: none" name="emp_sig_date" value="{{ $evaluationInfo==null ? date('Y-m-d') : $evaluationInfo->emp_sig_date }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- //(4) --}}

                                {{-- (5) --}}
                            <div class="row">
                                <div class="col-md-5 mx-auto bg-info">
                                    <h5 class="mb-0 text-center py-2 display-5">PART IX - VERIFICATION BY ADMIN
                                    </h5>
                                </div>    
                            </div>

                            <input type="hidden" name="admin_id" value={{ Auth::user()->username }} >

                            <div class="row ">
                                <div class="col-md-2 d-flex align-items-center justify-content-start justify-content-md-end"> <label for="cmnt">Comments</label> </div>
                                <div class="col-md-10">
                                    <textarea name="admin_comments" id="" cols="30" rows="3" class="form-control">{{ $evaluationInfo==null ? '' : $evaluationInfo->admin_comments }}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-2"><label for="rater">Signature: </label></div>
                                        <div class="col-7 border-bottom text-center">
                                        <p class="mb-0 border-none">{{ $evaluationInfo==null ? '' : $evaluationInfo->admin_id }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-2"><label for="rater">Date:</label></div>
                                    <div class="col-7 border-bottom text-center">
                                        <input type="text" style="border:none" name="admin_sig_date" value="{{ $evaluationInfo==null ? '' : $evaluationInfo->admin_sig_date }}" readonly>
                                    </div>
                                </div>
                            </div>
                            </div>
                            {{-- //(5) --}}

                        <div class="text-center mt-2">
                            <input type="submit" class="btn btn-success rounded" value="Submit" />
                        </div>

                        </div>
                        </div>
                        <!-- /.tab-pane -->
                        </div>
                    </form>
                </div>
                {{-- //card-body --}}
            </div>
        </div>
    </div>
    
    <div class="card">
    
        <div class="card-head">
        <ul class="nav  nav-pills">
            <li class="nav-item"><a class="nav-link active" href="#part1" data-toggle="tab">1</a>
            </li>
        
            <li class="nav-item"><a class="nav-link" href="#part2" data-toggle="tab">2</a></li>
            <li class="nav-item"><a class="nav-link" href="#part3" data-toggle="tab">3</a></li>
            <li class="nav-item"><a class="nav-link" href="#part4" data-toggle="tab">4</a></li>
            <li class="nav-item"><a class="nav-link" href="#part5" data-toggle="tab">5</a></li>
        </ul> 
        </div>
    
    </div>

</div>

</div>

@endsection
@endsection
@endsection
@endsection


@section('add-script')

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>

    $('#sdate').change(function(){
        var start = $(this).val();
        // alert(start);
    });

    $('#edate').change(function(){
        var end = $(this).val();
    });

    $(function(){
        $('.dateField').flatpickr();    //Date field customization
    });


    //$(document).ready(function() {
    // get all input flieds with number class

    $('.evaluation-factor').change(function(){
    var numInput = $('input[type=radio]:checked').val();
    var sum = 0;
    sum = sum + parseFloat(numInput);
    $('#result').val(sum);


    /* function calcAvg() {
    var sum = 0;
    // add the current val of each input field to the sum variable
    numInput.each(function() {
    sum += Number($(this).val());
    });
    // set the avg to the #result input field
    $('#result').val(sum / numInput.length);
    }; */

    // run the calcAvg function everytime the input changes
    /* numInput.change(calcAvg); */


    });


</script>

@endsection
@endsection