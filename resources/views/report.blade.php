@extends('index')
@section('title', '| Report')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Employee Attendance report</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Attendance</a></li>
                    <li class="breadcrumb-item"><a href="#">Report</a></li>
                    <li class="breadcrumb-item active">Employee Attendance report </li>
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
        <!-- leave request by year table -->
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header ">
                    <form action="{{route('search_report')}}" class="" method="POST">
                        @csrf
                            <div class="row gap-5">
                               @if(Auth::user()->can('report-department-staff-search'))
                                <div class="col-md-3 mt-md-0 mt-2 " >
                                <label for="dept">Department</label>
                                    <select id="dept" name="dept" class="form-control select2" style="width: 100%;" data-placeholder='select Department' >
                                        <option value="" selected hidden> --Department-- </option>
                                        @foreach($dept as $d)
                                        <option data-state="{{$d->dept_code}}" value="{{$d->dept_code}}">{{$d->dept_name}}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-3 mt-md-0 mt-2 ml-auto">
                                <label for="staff">Staff</label>
                                    <select id="staff" name="staff" class="form-control select2" style="width: 100%;" data-placeholder='select Staff'>
                                       
                                        @foreach($employee as $e)
                              
                                
                               
                                <option data-state="{{$e->dept_code}}"  value="{{$e->emp_id}}"  >{{$e->emp_id}} - {{$e->name}}</option>
                              
                                @endforeach

                                    </select>

                                </div>
                               @endif
                                <div 
                                @if(Auth::user()->can('report-department-staff-search'))    class="col-md-2 mt-md-0 mt-2 ml-auto" @else class="col-md-2 mt-md-0 mt-2 "  @endif >
                                    <label for="from">From</label>
                                    @php $f = date('Y-m-01'); $t = $t = date('Y-m-d');  @endphp 
                                    <input type="date" name="from" value="{{$from}}"  id="from" class="form-control js-date-field bg-transparent">

                                </div>
                                <div  @if(Auth::user()->can('report-department-staff-search'))    class="col-md-2 mt-md-0 mt-2 ml-auto" @else class="col-md-2 mt-md-0 mt-2 "  @endif >

                                    <label for="to">To</label>
                                    <input type="date" name="to" id="to" value="{{$to}}" class="form-control js-date-field bg-transparent">
                                </div>
                                <div  @if(Auth::user()->can('report-department-staff-search'))    class="col-md-1 mt-md-0 mt-2 ml-auto" @else class="col-md-1 mt-md-0 mt-2 "  @endif  >
                                <label for="to" style="visibility: hidden">Search</label> 
                                    <button class="btn btn-info form-control">  Show</button>
                                </div>
                            </div>
                        
                    </form>
                </div>

                
                <div class="card-body  overflow-auto">
                    
                    <table class="table table-bordered table-hover report">
                        <thead>
                            <tr>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Date</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;"> day</th>
                                <th colspan="3" class="text-center">Official Time Table</th>
                                <th colspan="3" class="text-center">Log</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Incident</th>
                                <th rowspan="2" style="vertical-align : middle;text-align:center;">Attendance</th>
                            </tr>
                            <tr>
                                <th class="text-center">Start</th>
                                <th class="text-center">End</th>
                                <th class="text-center">Duration</th>
                                <th class="text-center">In</th>
                                <th class="text-center">Out</th>
                                <th class="text-center">Duration</th>

                            </tr>
                        </thead>
                        <tbody>
                  

                        @php  $wr =0; $hd1=0; $extw=0; $rmdn=false; $emp_rost_s=false; $ltype=false; $w1=0;$w2=0;$a1=0;$a2=0;$a3=0; $hd2=0; $l1=0; $l2=0; $late1=0; $late2=0; $eout=0; $incd=0; $whd=0; $slot=false; $exWithout = array();  $echo='yes';
                        $tw=array(); $extraDw = array(); @endphp  
                    @for($i = $start; $i <= $end; $i=$i + 86400 )  
                     @php $thisDate=date( 'Y-m-d' , $i );  @endphp  
                     
                     <tr>
                        <td>

                             {{-- if holiday --}}
                        
                             @foreach($holiday as $h)@if($thisDate==$h->date )  <span class="text-info ">@if($h->description == 'Eid-ul-Fitr')
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#cc2b5e " class="bi bi-moon-stars" viewBox="0 0 16 16">
                                    <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z"/>
                                    <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
                                  </svg>
                                 
                                @endif

                                
                                </span>  @endif  @endforeach
                                {{-- //holiday --}}


                           
                            {{-- defining roster --}}
                        @php $roster = false; $md=false; @endphp
                        {{-- @foreach($roster_dept as $rd)
                         @if($rd->option_code==$edept)@php $roster = true; @endphp @endif
                        @endforeach --}}
                        @foreach($employee as $e) @if(  $e->emp_id == $staff && $e->roster == 'Y') @php $roster = true; @endphp @endif @endforeach

                        @foreach($rostering as $rs) @if($rs->emp_id==$staff && date('Y-m-d',strtotime($rs->stime))==$thisDate) @php $roster = true; @endphp @endif @endforeach
                        {{-- //----------------defining roster --}}
                            
                            @if($roster==true)
                            
                            {{-- {{$thisDate}} --}}
                            {{-- echo roster dates --}}
                             @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->stime)); $etime = date('Y-m-d',strtotime($rs->etime)); @endphp 
                               @if(($thisDate == $stime))
                                 @if($stime!=$etime) @php $md=true;  @endphp {{$thisDate}}-{{$etime}}
                                 @elseif($stime==$etime) @php $md=false; @endphp @endif
                               
                               @endif
                              
                             @endforeach

                            @if($md==false) {{$thisDate}}  @endif
                              
                             {{-- md --}}
                             {{-- @if($md==true){{$thisDate}} @endif --}}

                            @elseif($roster==false)
                           
                                {{$thisDate}}
                            @endif

                            {{-- if  no roster and no stime and etime matching --}}
                            
                        </td>




                        <td>@php $day = date('l',strtotime($thisDate)); @endphp 
                        
                         {{-- defining roster --}}
                         {{-- @php $roster = false; $md=false; @endphp
                         @foreach($roster_dept as $rd)
                          @if($rd->option_code==$edept)@php $roster = true; @endphp @endif
                         @endforeach --}}
                         {{-- //----------------defining roster --}}
                             
                             @if($roster==true)
                             
                             {{-- {{$thisDate}} --}}
                             {{-- echo roster dates --}}
                             @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->stime)); $etime = date('Y-m-d',strtotime($rs->etime)); @endphp 
                                
                                @if(($thisDate == $stime))
                                  
                                  @if($stime!=$etime) @php $md=true;  @endphp {{$day}}-{{(date('l',strtotime($etime)))}}
                                  @elseif($stime==$etime) @php $md=false; @endphp @endif
                                
                                @endif
                               
                              @endforeach
 
                             @if($md==false) {{$day}}  @endif
                               
                              {{-- md --}}
                              {{-- @if($md==true){{$thisDate}} @endif --}}
 
                             @elseif($roster==false)
                            
                                 {{$day}}
                             @endif
                        
                        
                        
                        </td>


                        <td>
                            @if($roster==true)
                            
                            {{-- {{$thisDate}} --}}
                            {{-- echo roster dates --}}
                             @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->stime)); $etime = date('Y-m-d',strtotime($rs->etime)); @endphp 
                               
                               @if(($thisDate == $stime))
                                 @php $slot = true; @endphp
                                 @php $md=true;  @endphp {{date('h:i:s a',strtotime($rs->stime))}}

                                 @php break; @endphp
                                
                               @endif
                              
                             @endforeach

                             
                             {{-- non-sloted roster --}}
                             @if($slot==false)
                             @foreach($emp_roster_schedule as $emp_rost) @if($thisDate==$emp_rost->ddate && $emp_rost->emp_id==$staff) {{date('h:i:s a',strtotime($emp_rost->start_time))}} @php break; @endphp @endif @endforeach
                             @endif
                             {{-- // --}}
                            @elseif($roster==false)
                            {{-- DEFAULT --}}
                            {{-- non-sloted non-roster  --}}
                            @foreach($emp_roster_schedule as $emp_rost)
                            @if($thisDate==$emp_rost->ddate && $emp_rost->emp_id==$staff) @php $emp_rost_s=true; @endphp {{date('h:i:s a',strtotime($emp_rost->start_time))}} @else  @php $emp_rost_s=false; @endphp@endif 
                            @endforeach 

                            @if($emp_rost_s==false) 

                            {{-- @if(!is_null($weeklyLeave))
                            @php $leaveWeekend = array('Saturday'=>$weeklyLeave->sat,'Sunday'=>$weeklyLeave->sun,'Monday'=>$weeklyLeave->mon,'Tuesday'=>$weeklyLeave->tue,'Wednesday'=>$weeklyLeave->wed,'Thursday'=>$weeklyLeave->thu,'Friday'=>$weeklyLeave->fri); @endphp
                            @else
                              
                            @endif --}}
                             
                            @foreach($default_weekend as $dftw)
                            @if($day==$dftw->option_code)
                            @if($dftw->option_value=='N') 
                            {{-- default time --}}
                             {{-- @foreach($default_time as $dt) 
                              {{$dt->stime}}
                             @endforeach --}}
                             {{-- ramadan --}}
                             @php  $echo='yes'; @endphp
                             @foreach($ramadan as $r) 
                             
                             @if($thisDate >=$r->date_from && $thisDate <= $r->date_to)
                            
                              {{date('h:i:s a',strtotime($r->stime))}}    
                             @php $rmdn=true; $echo='no'; @endphp
                             @else
                             @php $rmdn=false; @endphp 
                             @endif
                             @endforeach
                             {{-- //ramadan --}}

                              



                            @endif
                            @endif
                            @endforeach
                            
                            @endif 

                              {{-- {{$emp_rost_s}} {{$rmdn}} {{$echo}} --}}

                              @if($emp_rost_s==false && $echo=="yes") 


                              @foreach($default_weekend as $dftw)
                              
                              @if($dftw->option_code==$day && $dftw->option_value=='N')
                              @foreach($default_time as $dftw)
                              {{date('h:i:s a',strtotime($dftw->stime))}}
                              
                              @endforeach
                              @php continue; @endphp
                              @endif
                              @endforeach


                              @endif

                            

                            {{-- //DEFAULT --}}
                            @endif
                        </td>

                        <td>
                            @if($roster==true)
                            
                            {{-- {{$thisDate}} --}}
                            {{-- echo roster dates --}}
                             @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->stime)); $etime = date('Y-m-d',strtotime($rs->etime)); @endphp 
                               
                               @if(($thisDate == $stime))
                                 @php $md=true;  @endphp {{date('h:i:s a',strtotime($rs->etime))}}

                                 @php break; @endphp
                                
                               @endif
                              
                             @endforeach

                             {{-- non-sloted roster --}}
                             @if($slot==false)
                             @foreach($emp_roster_schedule as $emp_rost) @if($thisDate==$emp_rost->ddate && $emp_rost->emp_id==$staff) {{date('h:i:s a',strtotime($emp_rost->end_time))}} @php break; @endphp @endif @endforeach
                             @endif
                             {{-- // --}}

                            @elseif($roster==false)
                             
                                    {{-- non-sloted non-roster  --}}
                            @foreach($emp_roster_schedule as $emp_rost)
                            @if($thisDate==$emp_rost->ddate && $emp_rost->emp_id==$staff) @php $emp_rost_s=true; @endphp {{date('h:i:s a',strtotime($emp_rost->end_time))}} @else  @php $emp_rost_s=false; @endphp@endif 
                            @endforeach 

                            @if($emp_rost_s==false) 
                             
                            @foreach($default_weekend as $dftw)
                            @if($day==$dftw->option_code)
                            @if($dftw->option_value=='N') 
                            {{-- default time --}}
                             {{-- @foreach($default_time as $dt) 
                              {{$dt->stime}}
                             @endforeach --}}
                             {{-- ramadan --}}
                             @php  $echo='yes'; @endphp
                             @foreach($ramadan as $r) 
                             
                             @if($thisDate >=$r->date_from && $thisDate <= $r->date_to)
                            
                              {{date('h:i:s a',strtotime($r->etime))}}   
                             @php $rmdn=true; $echo='no'; @endphp
                             @else
                             @php $rmdn=false; @endphp 
                             @endif
                             @endforeach
                             {{-- //ramadan --}}

                              



                            @endif
                            @endif
                            @endforeach
                            
                            @endif 

                              {{-- {{$emp_rost_s}} {{$rmdn}} {{$echo}} --}}

                              @if($emp_rost_s==false && $echo=="yes") 
                              @foreach($default_weekend as $dftw)
                              
                              @if($dftw->option_code==$day && $dftw->option_value=='N')
                              @foreach($default_time as $dftw)
                              {{date('h:i:s a',strtotime($dftw->etime))}}
                              
                              @endforeach
                              @endif
                              @endforeach
                              @endif    
                            @endif

                           
                            {{-- emp-rost {{$emp_rost_s}} ramadan {{$rmdn}} --}}
                           
                        </td>

                        <td> 
                            @if($roster==true)
                             
                             {{-- {{$thisDate}} --}}
                             {{-- echo roster dates --}}
                             @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->stime)); $nstime=date('H:i:s',strtotime($rs->stime)); $etime = date('H:i:s',strtotime($rs->etime)); @endphp 
                                
                                @if(($thisDate == $stime))
                                  
                                   @php $dure = ((strtotime($nstime) - strtotime($etime))/3600); $min =((strtotime($nstime) - strtotime($etime))%3600)/60   @endphp 
                                   @if(abs(intval($dure))<10) 0{{abs(intval($dure))}} @else {{abs(intval($dure))}} @endif: {{intval(abs($min))}}  
                                   {{-- {{date('H:i:s',(strtotime($nstime) - strtotime($etime)))}} --}}
                                   @php break; @endphp
                                @endif
                               
                              @endforeach
                             {{-- for non-sloted roster --}}
                              @if($slot==false) 

                              @foreach($emp_roster_schedule as $emp_rost) 
                              @if($emp_rost->ddate == $thisDate)
                              @php $diff = strtotime($emp_rost->end_time)-strtotime($emp_rost->start_time); @endphp
                                  {{date('H:i:s',$diff)}}
                              @endif
                              @endforeach
                              
                              @endif
                             {{-- // --}}
                             @if($md==false) <p class="mb-0 text-indigo">--------</p>  @endif
                               
                              {{-- md --}}
                              {{-- @if($md==true){{$thisDate}} @endif --}}
 
                             @elseif($roster==false)
                             
                                         {{-- non-sloted non-roster  --}}
                            @foreach($emp_roster_schedule as $emp_rost)
                            @if($thisDate==$emp_rost->ddate && $emp_rost->emp_id==$staff) @php $emp_rost_s=true; @endphp 
                           
                            @php $diff = strtotime($emp_rost->end_time)-strtotime($emp_rost->start_time);  @endphp
                            {{date('H:i:s',$diff)}} 

                            @else  @php $emp_rost_s=false; @endphp @endif 
                            @endforeach 

                            @if($emp_rost_s==false) 
                             
                            @foreach($default_weekend as $dftw)
                            @if($day==$dftw->option_code)
                            @if($dftw->option_value=='N') 
                            {{-- default time --}}
                             {{-- @foreach($default_time as $dt) 
                              {{$dt->stime}}
                             @endforeach --}}
                             {{-- ramadan --}}
                             @php  $echo='yes'; @endphp
                             @foreach($ramadan as $r) 
                             
                             @if($thisDate >=$r->date_from && $thisDate <= $r->date_to)
                            
                             @php $diff = strtotime($r->etime)-strtotime($r->stime); @endphp
                             {{date('H:i:s',$diff)}} 
                             @php $rmdn=true; $echo='no'; @endphp
                             @else
                             @php $rmdn=false; @endphp 
                             @endif
                             @endforeach
                             {{-- //ramadan --}}

                              



                            @endif
                            @endif
                            @endforeach
                            
                            @endif 

                              {{-- {{$emp_rost_s}} {{$rmdn}} {{$echo}} --}}

                              @if($emp_rost_s==false && $echo=="yes") 
                              @foreach($default_weekend as $dftw)
                              
                              @if($dftw->option_code==$day && $dftw->option_value=='N')
                              @foreach($default_time as $dftw)
                              @php $diff = strtotime($dftw->etime)-strtotime($dftw->stime); @endphp
                              {{date('H:i:s',$diff)}}
                              @endforeach
                              @endif
                              @endforeach
                              @endif    





                             @endif
                        </td>
                       
                       {{-- just for colspan --}}
                       @php $s = array(); $e=array(); @endphp @foreach($report as $r)  @if($thisDate == $r->date)  @php array_push($s,$r->stime); array_push($e,$r->stime); @endphp @endif @endforeach
                        {{-- @foreach($holiday as $h)@if($thisDate==$h->date ) @php $hol = $thisDate; $hd1=$hd1+1; @endphp  @endif  @endforeach --}}
                      
                        <td @if($roster==false) @foreach($holiday as $h) @if($thisDate==$h->date) @if(empty($s)&& empty($e)) colspan="3" @endif @endif  @endforeach @endif @if($roster==true ) @foreach($roster_holiday as $rh)@if($thisDate==$rh->date && $rh->emp_id == $staff ) @if(empty($s)&& empty($e)) colspan="3"   @endif @endif  @endforeach @endif> 
                            
                            @php $s = array(); @endphp @foreach($report as $r)  @if($thisDate == $r->date)  @php array_push($s,$r->stime) @endphp @endif @endforeach 
                            {{-- @php  if(!empty($s)){ if(strtotime(min($s))>strtotime("09:15:00"))  echo '<span class="text-danger" >'.((date('h:i:s a',strtotime(min($s))))). min($s) .'</span>';  elseif(strtotime(min($s))<strtotime("09:15:00"))echo '<span class="text-info" >'.((date('h:i:s a',strtotime(min($s))))). min($s).'</span>';}@endphp  --}}
                            {{-- @foreach($holiday as $h) @if($thisDate==$h->date  ) {{$h->description}} @endif @endforeach --}}
                        {{-- if roster--}} 
                        @if($roster==true)
                            
                        {{-- {{$thisDate}} --}}
                        {{-- echo roster dates --}}
                         @foreach($rostering as $rs) 
                         @php $stime = date('Y-m-d',strtotime($rs->stime)); $shour = date('H:i:s',strtotime($rs->stime.'15 minutes')); @endphp 
                           @if(($thisDate == $stime))
                         
                             @php $md=true;  @endphp 
                            
                             @if(!empty($s)) 

                             
                              @if((strtotime($shour))<(strtotime(min($s)))) 

                              
                              @php $late1=$late1+1; @endphp <p class='mb-0 text-danger'>{{Date('h:i:s a',strtotime(min($s)))}} </p> 

                              @else <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(min($s)))}}</p> 
                              @endif
                              
                              
                             @endif

                             @php break; @endphp
                            
                           @endif
                          
                         @endforeach




                        {{-- if slot false --}}
                         @if($slot==false) 
                         @foreach($emp_roster_schedule as $emp_rost)
                         @if($thisDate==$emp_rost->ddate) 
                          @php $shour = date('H:i:s',strtotime($emp_rost->start_time.'15 minutes'));$md=true; @endphp 
                          

                          @if(!empty($s)) 
                          @if((strtotime($shour))<(strtotime(min($s)))) @php $late1=$late1+1; @endphp <p class='mb-0 text-danger'>{{Date('h:i:s a',strtotime(min($s)))}}  </p> 
                          @else <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(min($s)))}}</p> 
                          @endif 
                          @endif




                          {{-- {{$shour}} --}}
                         @endif
                         @endforeach
                         @endif
                        {{-- // --}}

                        {{-- work without roster --}}
                         @if($md==false)    @if(!empty($s)) <p class='mb-0 text-gray'>{{Date('h:i:s a',strtotime(min($s)))}}</p>  @endif @endif
                        {{-- // --}}
                        @elseif($roster==false)
                        @php 
                        // ramadan
                        if($rmdn==true){
                           foreach($ramadan as $rmd){
                            if($thisDate >= $rmd->date_from && $thisDate <= $rmd->date_to){
                                 $time1 = strtotime($rmd->stime.'15 minutes');
                                
                            }
                           }
                         }elseif($rmdn==false){

                            // rost emp

                            if($emp_rost_s==true){
                                foreach($emp_roster_schedule as $emp_rost){
                                    if($emp_rost->emp_id==$staff && $thisDate==$emp_rost->ddate){
                                        $rst =  date('H:i:s',strtotime($emp_rost->start_time));
                                        $time1 = strtotime($rst.'15 minutes');
                                    
                                    }
                                    
                                }
                                
                            }else{
                                foreach($default_time as $dft){
                                $time1 = strtotime($dft->stime.'15 minutes');
                                }
                                
                            }
                            
                           
                           
                         }
                        // ramadan
                        
                        // roster emp

                        // $time1 = strtotime('09:00:00'.'15 minutes');  
                        @endphp

                        @if(!empty($s)) 
                        @if((strtotime(min($s)))>$time1) 

                        @foreach($default_weekend as $dftw)
                        @if($dftw->option_code==$day && $dftw->option_value=='N')
                        <p class='mb-0 text-danger'> @php $late2=$late2+1; @endphp {{Date('h:i:s a',strtotime(min($s)))}}</p> 
                        @elseif((($dftw->option_code==$day && $dftw->option_value=='Y')))
                        <p class='mb-0 txt-blue'>   {{Date('h:i:s a',strtotime(min($s)))}}</p> 
                        @endif
                        @endforeach

                        @else 
                         
                        @foreach($default_weekend as $dftw)
                        @if($dftw->option_code==$day && $dftw->option_value=='N')
                        <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(min($s)))}}  </p> 
                        @elseif(($dftw->option_code==$day && $dftw->option_value=='Y') )
                        <p class='mb-0 txt-blue'>   {{Date('h:i:s a',strtotime(min($s)))}}</p>
                        @endif
                        @endforeach

                        @endif 
                        @endif

                        @endif 
                        {{-- // --}}
                        {{-- holiday --}}
                        @if($roster==false)
                        @foreach($holiday as $h)@if($thisDate==$h->date )@if(empty($s)&& empty($e)) <span class="text-info ">   @if($h->description == 'Eid-ul-Fitr')
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#cc2b5e " class="bi bi-moon-stars" viewBox="0 0 16 16">
                                <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z"/>
                                <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z"/>
                            </svg>
                            
                            @endif

                            @php $holidayTrue = true; @endphp
                            {{ $h->description }} </span> @endif @endif @endforeach 
                            @endif

                            @if($roster==true) 
                            @foreach($roster_holiday as $rh)@if($thisDate==$rh->date && $rh->emp_id == $staff ) <span class="text-info">Roster Holiday</span> @endif @endforeach
                            @endif
                          
                        </td>


                       
                        <td @if($roster==false) @foreach($holiday as $h) @if($thisDate==$h->date  ) @if(empty($s) && empty($e)) style="display:none;"  @endif @endif  @endforeach @endif  @if($roster==true ) @foreach($roster_holiday as $rh)@if($thisDate==$rh->date && $rh->emp_id == $staff ) @if(empty($s)&& empty($e)) style="display:none;"   @endif @endif  @endforeach @endif>
                            @php $e = array(); @endphp @foreach($report as $r)  @if($thisDate == $r->date)  @php array_push($e,$r->stime) @endphp @endif @endforeach 
                            
                             {{-- if roster--}} 
                        
                        @if($roster==true)
                            
                        {{-- {{$thisDate}} --}}
                        {{-- echo roster dates --}}
                         @foreach($rostering as $rs) @php $stime = date('Y-m-d',strtotime($rs->etime)); $ehour = date('H-i-s ',strtotime($rs->etime)); @endphp 
                           
                           @if(($thisDate == $stime))
                             @php $md=true;  @endphp 

                             @if(!empty($e)) @if((strtotime(max($e)))>=(strtotime($ehour))) <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(max($e)))}}</p> 
                             @else @php $eout=$eout+1; @endphp <p class='mb-0 text-danger'>{{Date('h:i:s a',strtotime(max($e)))}}</p> 
                             @endif @endif

                             @php break; @endphp
                           
                             
                           
                           @endif
                          {{--  --}}
                          
                         @endforeach


                        {{-- non-sloted roster --}}
                          {{-- if slot false --}}
                          @if($slot==false) 
                          @foreach($emp_roster_schedule as $emp_rost)
                          @if($thisDate==$emp_rost->ddate) 
                           @php $ehour = date('H:i:s',strtotime($emp_rost->end_time)); $md=true; @endphp 
                           
 
                           @if(!empty($s)) 
                           @if((strtotime($ehour))>(strtotime(max($e)))) @php $eout=$eout+1; @endphp <p class='mb-0 text-danger'>{{Date('h:i:s a',strtotime(max($e)))}}  </p> 
                           @else <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(max($e)))}}</p> 
                           @endif 
                           @endif
 
 
 
 
                           {{-- {{$ehour}} --}}
                          @endif
                          @endforeach
                          @endif
                         {{-- // --}}

                        {{-- // --}}
                        {{-- work without roster --}}
                        @if($md==false)    @if(!empty($e)) <p class='mb-0 text-gray'>{{Date('h:i:s a',strtotime(max($e)))}}</p>  @endif @endif
                        {{-- // --}}
                        @elseif($roster==false)
                        @php 
                         if($rmdn==true){
                           foreach($ramadan as $rmd){
                            if($thisDate >= $rmd->date_from && $thisDate <= $rmd->date_to){
                                 $time = strtotime($rmd->etime);
                                
                            }
                           }
                         }elseif($rmdn==false){

                            

                            if($emp_rost_s==true){
                                foreach($emp_roster_schedule as $emp_rost){
                                    if($emp_rost->emp_id==$staff && $thisDate==$emp_rost->ddate){
                                        $rst =  date('H:i:s',strtotime($emp_rost->end_time));
                                        $time = strtotime($rst);
                                    
                                    }
                                    
                                }
                                
                            }else{
                                foreach($default_time as $dft){
                                $time = strtotime($dft->etime);
                                }
                                
                            }
                            
                            // foreach($default_time as $dft){
                            //     $time = strtotime($dft->etime);
                            // }
                            // $time = strtotime('18:00:00'); 
                         }
                       
                        //  $time = strtotime('18:00:00');
                        @endphp
                            {{-- {{Date('h:i:s',$time)}} --}} 
                            @if(!empty($e)) @if((strtotime(max($e)))>=$time) 
                            
                            @foreach($default_weekend as $dftw)
                            @if($dftw->option_code==$day && $dftw->option_value=='N')
                            {{-- ---{{max($s)}}    if we have to count the end time from start time, we can use max($s) instead of using max($e)  here is the systems--}}
                            <p class='mb-0 text-info'>{{Date('h:i:s a',strtotime(max($e)))}} </p> 
                            @elseif($dftw->option_code==$day && $dftw->option_value=='Y')
                            <p class='mb-0 txt-blue'>{{Date('h:i:s a',strtotime(max($e)))}} </p> 
                            @endif
                            @endforeach


                             @else 

                             @foreach($default_weekend as $dftw)
                             @if($dftw->option_code==$day && $dftw->option_value=='N')
                             @php $eout=$eout+1; @endphp <p class='mb-0 text-danger'>{{Date('h:i:s a',strtotime(max($e)))}} </p> 
                             @elseif($dftw->option_code==$day && $dftw->option_value=='Y')
                             <p class='mb-0 txt-blue'>{{Date('h:i:s a',strtotime(max($e)))}}</p> 
                             @endif
                             @endforeach

                             @endif @endif 
                            
                        @endif 

                         
                        </td>
                        
                        <td @if($roster==false) @foreach($holiday as $h) @if($thisDate==$h->date  ) @if(empty($s) && empty($e)) style="display:none;"  @endif @endif  @endforeach @endif  @if($roster==true ) @foreach($roster_holiday as $rh)@if($thisDate==$rh->date && $rh->emp_id == $staff ) @if(empty($s)&& empty($e)) style="display:none;"   @endif @endif  @endforeach @endif>
                           
                            @php 
                            if(!empty($e)&&!empty($s)){
                                $dateDiff = intval((strtotime($thisDate.max($e))-strtotime($thisDate.min($s)))/60);
                                
    $hours = intval($dateDiff/60);
    $minutes = ($dateDiff%60);

    if($roster == true){
    
        if($slot == true){
    foreach($rostering as $r){
        $stime =date('H:i:s',strtotime($r->stime)) ; $etime = date('H:i:s',strtotime($r->etime)); $sdate = date('Y-m-d',strtotime($r->stime));
        if($sdate==$thisDate){
            $md = true;
            $diff = abs(strtotime($etime)-strtotime($stime))/3600;
            array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
            if($hours <$diff){
        // echo '<span class="text-danger">'.abs($hours).':'.$minutes.'</span>';echo date('H:i:s',(strtotime(max($e))-strtotime(min($s))));
        echo '<span class="text-danger">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
        $incd=$incd+1;
        array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
        }elseif($hours>=$diff){
            array_push($extraDw,(abs(strtotime(max($e))-strtotime(min($s))))-(abs(strtotime($etime)-strtotime($stime))));
        echo '<span class="text-info">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
        }else{echo '<span class="text-gray">'.abs($hours).':'.$minutes.'</span>';}
            break;
            
        }

        
    }

    } // non-sloted roster
    else{
    foreach($emp_roster_schedule as $emp_rost){
        $stime =date('H:i:s',strtotime($emp_rost->start_time)) ; $etime = date('H:i:s',strtotime($emp_rost->end_time)); 
        if($emp_rost->ddate==$thisDate){
            $md = true;
            $diff = abs(strtotime($etime)-strtotime($stime))/3600;
            array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
            
            if($hours <$diff){
        // echo '<span class="text-danger">'.abs($hours).':'.$minutes.'</span>';echo date('H:i:s',(strtotime(max($e))-strtotime(min($s))));
        echo '<span class="text-danger">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
        $incd=$incd+1;
        array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
        }elseif($hours>=$diff){
            array_push($extraDw,(abs(strtotime(max($e))-strtotime(min($s))))-(abs(strtotime($etime)-strtotime($stime))));
        echo '<span class="text-info">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
        }else{echo '<span class="text-gray">'.abs($hours).':'.$minutes.'</span>';}

        }
    }
    }
    if($md==false){
        $extw=$extw+1;
        array_push($exWithout,(strtotime(max($e))-strtotime(min($s))));
        echo '<span class="txt-blue">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
    }
        
    
    }elseif($roster==false){

        // if ramadan set

        if($rmdn==true){
        foreach($ramadan as $rd){
            if($thisDate>=$rd->date_from && $thisDate<= $rd->date_to){
                $diff = abs(strtotime($rd->stime)-strtotime($rd->etime))/3600;;
                
                // if($hours>$diff){
                //     echo "<span class='text-info'>".date('H:i:s',(strtotime(max($e))-strtotime(min($s))))."</span";
                        
                // }else{
                //     echo "<span class='text-danger'>".date('H:i:s',(strtotime(max($e))-strtotime(min($s))))."</span";
                // }
                
            }
        }
        }

        
        if($emp_rost_s==true){
            foreach($emp_roster_schedule as $emp_rost){
                // $extd = abs(strtotime($emp_rost->end_time)-strtotime($emp_rost->start_time));
                $diff=(strtotime($emp_rost->end_time)-strtotime($emp_rost->start_time))/3600;
            }
        }


        foreach ($default_weekend as $dftw) {
            # code...
        if($dftw->option_code==$day && $dftw->option_value=='N'){

        if($emp_rost_s==false && $rmdn==false){
            foreach($default_time as $dt){
                $diff = abs(strtotime($dt->stime)-strtotime($dt->etime))/3600;;
            }
        }
        //  ----ramadan
        if($hours <$diff){
            $incd=$incd+1;
            array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
        echo '<span class="text-danger">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>'; 
        }elseif($hours>=$diff ){
        if($minutes>0){
            array_push($extraDw,(abs(strtotime(max($e))-strtotime(min($s))))-($diff*3600));
            array_push($tw,abs(strtotime(max($e))-strtotime(min($s))));
        echo '<span class="text-info">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>'; }

        }else{echo '<span class="txt-blue">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';}
    }elseif(($dftw->option_code==$day && $dftw->option_value=='Y') ){
        echo '<span class="txt-blue">'.date('H:i:s',(strtotime(max($e))-strtotime(min($s)))).'</span>';
    }
    }

    }
        


    }
                                @endphp

                            
                        </td>
                       {{-- @foreach($holiday as $h)@if($thisDate==$h->date ) @if(empty($s)&& empty($e)) style="display:none;" @endif @endif  @endforeach --}}
                        <td >
                           @if($roster==false)
                            @if(!empty($s)||!empty($e)) 
                            @foreach($holiday as $h)@if($thisDate==$h->date ) @php $whd=$whd+1; @endphp <p class="mb-0 text-info">{{$h->description}}</p>  @endif  @endforeach  
                            @endif
                           @endif


                           @if($roster==true)
                            @if(!empty($s)||!empty($e)) 
                            @foreach($roster_holiday as $rh)@if($thisDate==$rh->date ) @php $whd=$whd+1; @endphp <p class="mb-0 text-info">{{$rh->description}}</p>  @endif  @endforeach  
                            @endif
                           @endif
                            {{-- incident --}}

                            @foreach($incident as $inc)
                            @if($inc->date == $thisDate) <span class="text-pink">{{$inc->description}}</span> @endif
                            @endforeach
                          
                        </td>
                       

                       
                        {{-- // --}}
                       
                        <td> 
                          






                {{-- roster true --}}
                       @if($roster==true) 

                        {{-- defining weekend --}}
                        @php $week = false; @endphp
                        @foreach($weekend as $w) @if($w->date==$thisDate) @php $week = true; @endphp @endif @endforeach
                        {{-- // defining weekend--}}

                        {{-- if weekend true --}}
                        @if($week==true)

                        
                        @php $hd=false; @endphp
                        @foreach($roster_holiday as $h)@if($h->date == $thisDate)@php $hd=true; @endphp @endif @endforeach

                        @if($hd==true)<p class="mb-0 text-info">Weekend & Holiday</p> @elseif($hd==false) <p class="mb-0 text-info">Weekend</p> @endif

                        {{-- if weekend false --}}
                        @elseif($week == false)
                        {{-- holiday --}}
                          @php $hd=false; @endphp
                          {{-- roster holiday --}}
                          @if($roster==true ) @foreach($roster_holiday as $rh)@if($thisDate==$rh->date && $rh->emp_id == $staff ) @php $hd=true; @endphp  @endif  @endforeach @endif
                          {{-- // --}}
                          {{-- @foreach($holiday as $h)@if($h->date == $thisDate)@php $hd=true; @endphp @endif @endforeach --}}
                          {{-- if hd t --}}
                          @if($hd==true) <p class="mb-0 text-info">Holiday</p>
                          {{-- if hd f --}}
                          @elseif($hd==false) 
                          {{-- absent or wday --}}
                            @if(!empty($s)||!empty($e)) 
                            @php $w2=$w2+1; @endphp
                            <p class="mb-0 text-indigo">Working Day</p>
                            @elseif(empty($s)||empty($e)) 
                            {{-- <p class="mb-0 text-danger">Absent</p>  --}}
                            {{-- leave --}}
                            @php $lv=false; @endphp
                            @foreach($leave as $l) @if(($l->leave_start <=$thisDate)&&($l->leave_end>=$thisDate)) @php $lv=true; @endphp @if($l->leave_type=='HL') @php $ltype=true; @endphp @endif @endif @endforeach
                            @if($lv==true) @php $l1=$l1+1; @endphp @if($ltype==true) <p class="mb-0 text-orange">Half Leave</p> @else <p class="mb-0 text-orange">Leave</p> @endif   @elseif($lv==false) @php $a1=$a1+1; @endphp <p class="mb-0 text-danger">Absent</p>  @endif
                            {{-- //leave --}}
                            @endif
                             {{-- //absent or wday --}}
                          @endif
                        {{-- // --}}

                        @endif

                         {{-- rostering --}}


                {{-- roster false --}}                       
                       @elseif($roster==false)
                        
                        @if(!is_null($weeklyLeave))
                         
                          @php $leaveWeekend = array('Saturday'=>$weeklyLeave->sat,'Sunday'=>$weeklyLeave->sun,'Monday'=>$weeklyLeave->mon,'Tuesday'=>$weeklyLeave->tue,'Wednesday'=>$weeklyLeave->wed,'Thursday'=>$weeklyLeave->thu,'Friday'=>$weeklyLeave->fri); @endphp
                           {{-- weekly --}}
                          @foreach($leaveWeekend as $week =>$value)
                          @if($week==$day && $value == 'Y')


                          @php $hd=false; $weekL = array();  @endphp
                          @foreach($holiday as $h) @if($h->date == $thisDate) @php $hd=true; @endphp @endif  @endforeach
                          @if($hd==false) @if(!empty($s)||!empty($e)) @php $w2=$w2+1; array_push($exWithout,(strtotime(max($e))-strtotime(min($s)))); @endphp <p class="mb-0 txt-blue"> Weekend / present </p> @php $whd=$whd+1; @endphp 
                          @else <p class="mb-0 text-info"> Weekend</p>  @endif  @elseif($hd==true) <p class="mb-0 text-info">Weekend & Holiday</p> @endif
                          
                          
                          @elseif($week==$day && $value == 'N')
                            
                          @php $hd=false; @endphp
                          @foreach($holiday as $h)@if($h->date == $thisDate)@php $hd=true; @endphp @endif @endforeach
                          
                          {{-- if hd false--}}
                          @if($hd==false)
                          
                          {{-- working day --}}
                           @if(!empty($s)||!empty($e)) @php $w1=$w1+1; @endphp <p class="mb-0 text-indigo"> Working Day</p> 
                           {{-- //working day --}}
                           {{-- absent or leave --}}
                           @elseif(empty($s) && empty($e)) 
                            
                            @php $lv=false; @endphp
                            @foreach($leave as $l) @if(($l->leave_start <=$thisDate)&&($l->leave_end>=$thisDate)) @php $lv=true; @endphp @endif @endforeach
                            @if($lv==true) @php $l2=$l2+1; @endphp <p class="mb-0 text-orange">Leave</p>  @elseif($lv==false) @php $a2=$a2+1; @endphp <p class="mb-0 text-danger">Absent</p>  @endif
                           @endif
                           {{-- // absent or leave--}}

                           {{-- if hd true--}}
                          @elseif($hd==true) 
                          
                          @if(!empty($s)||!empty($e)) @php $w2=$w2+1; array_push($exWithout,(strtotime(max($e))-strtotime(min($s)))); @endphp <p class="mb-0 txt-blue">Holiday/present</p> @php $whd=$whd+1; @endphp  @else <p class="mb-0 text-info">Holiday</p>  @endif
                          @endif
                          {{-- //hd --}}
                            


                          @endif
                          @endforeach
                          {{-- finish weekly  --}}
                        @else
                       

                        {{--def weekend --}}
                        @foreach($default_weekend as $rd) @if($rd->option_code==$day) 
                        
                       {{-- wday --}}
                        @if($rd->option_value=='N') 
                          
                          @php $hd=false; @endphp
                          @foreach($holiday as $h)@if($h->date == $thisDate)@php $hd=true; @endphp @endif @endforeach
                          
                          {{-- if hd false--}}
                          @if($hd==false)
                          
                          {{-- working day --}}
                           @if(!empty($s)||!empty($e)) @php $w1=$w1+1; @endphp <p class="mb-0 text-indigo"> Working Day</p> 
                           {{-- //working day --}}
                           {{-- absent or leave --}}
                           @elseif(empty($s) && empty($e)) 
                            
                            @php $lv=false; @endphp
                            @foreach($leave as $l) @if(($l->leave_start <=$thisDate)&&($l->leave_end>=$thisDate)) @php $lv=true; @endphp @endif @endforeach
                            @if($lv==true) @php $l2=$l2+1; @endphp <p class="mb-0 text-orange">Leave</p>  @elseif($lv==false) @php $a2=$a2+1; @endphp <p class="mb-0 text-danger">Absent</p>  @endif
                           @endif
                           {{-- // absent or leave--}}

                           {{-- if hd true--}}
                          @elseif($hd==true) 
                          
                          @if(!empty($s)||!empty($e)) @php $w2=$w2+1; array_push($exWithout,(strtotime(max($e))-strtotime(min($s)))); @endphp <p class="mb-0 txt-blue">Holiday/present</p> @php $whd=$whd+1; @endphp  @else <p class="mb-0 text-info">Holiday</p>  @endif
                          @endif
                          {{-- //hd --}}
                        
                        
                          {{-- weekday --}}
                        @elseif($rd->option_value=='Y') 
                        
                          @php $hd=false; $weekL = array();  @endphp
                          @foreach($holiday as $h) @if($h->date == $thisDate) @php $hd=true; @endphp @endif  @endforeach
                          @if($hd==false) @if(!empty($s)||!empty($e)) @php $w2=$w2+1; array_push($exWithout,(strtotime(max($e))-strtotime(min($s)))); @endphp <p class="mb-0 txt-blue"> Weekend / present </p> @php $whd=$whd+1; @endphp 
                          @else <p class="mb-0 text-info"> Weekend</p>  @endif  @elseif($hd==true) <p class="mb-0 text-info">Weekend & Holiday</p> @endif
                        @endif
                        
                        
                        
                        @endif @endforeach
                        {{-- // --}}



                        
                        
                        @endif  
                       @endif 
                        </td>
                       
                     </tr>
                     @php $wr=$wr+1; @endphp
                    @endfor    
                        </tbody>
                    </table>
                     <div class="col-md-12">
                        
                     </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-3">
                            {{-- {{$w1+$w2+$hd1}} {{$wr}} --}}
                            <label for="" >Total working day: &nbsp;</label>{{$w1+$w2+$a1+$a2+$l1+$l2-$extw}} <br>
                            {{-- {{$wr-($w1+$w2+$hd1)}} --}}
                            <label for="" >Total Late Login:&nbsp; </label>  {{$late1+$late2}}
                            {{-- {{$late}} --}}
                        </div>
                        <div class="col-md-3">
                            <label for="">Total present day:&nbsp;</label> {{$w1+$w2}}  <br>
                            {{-- {{$p1+$p2}} --}}
                            <label for="">Total Early Logout:&nbsp;</label> {{$eout}}
                            {{-- {{$eout}} --}}
                        </div>
                        <div class="col-md-3">
                            <label for="">Total absent day:&nbsp;</label>{{$a1+$a2}} <br>
                            {{-- {{($wr-($w1+$w2+$hd1))-($p1+$p2)}} --}}
                            <label for="">Incomplete office duration:&nbsp;&nbsp;</label>{{$incd}} &nbsp; day(s)
                        </div>
                        <div class="col-md-3">
                            <label for="">Present During Holiday:&nbsp;</label> {{$whd}} <br>
                            @php $total_duration = array_sum($tw); $tday= $w1+$w2+$a1+$a2+$l1+$l2;
                            if($w1==0 && $w2==0  && $a1==0 && $a2==0 && $l1==0 && $l2==0){ $tday=1; }
                            $avg_du = intval($total_duration/($tday *3600));
                           
                            $mn = intval($total_duration/($tday ));
                             @endphp
                            <label for="">Average Working Time:&nbsp;</label>  {{date('H:i:s',$mn)}} 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                           
                            <label for="">Extra Working Hour during Working Day:&nbsp;</label>  {{date('H:i:s',array_sum($extraDw))}}
                        </div>
                        <div class="col-md-6"> <label for="">Extra Working Hour without Working Day:&nbsp;</label> {{abs(array_sum($exWithout))/3600}} </div>
                    </div>
                </div>

            </div>
            <!-- /.card -->
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
    var $seldept = $('#dept'),
		$selstaff = $('#staff'),
    $options = $selstaff.find('option');
    
    $seldept.on('change', function() {
        $selstaff.html($options.filter('[data-state="'+this.value+'"]'));
    }).trigger('change');

    //Date field customization
    $(function(){
        $('.js-date-field').flatpickr();
    });


     // fail/success msg

     setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>

    
@endsection
@endsection