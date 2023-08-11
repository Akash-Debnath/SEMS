@extends('index')
@section('title', '| Today Leave')
@section('wrapper')
@parent


@section('content-wrapper')
@parent
@section('content-header')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Leave Today</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Attendance </a></li>
                    <li class="breadcrumb-item"><a href="#">Leave</a></li>
                    <li class="breadcrumb-item active">Leave Today</li>
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
        <div class="card">
           <div class="card-header">
            <form action="{{ url('search-today-leave') }}" method="POST" enctype="multipart/form-data">
            @csrf
               <div class="row">
                   <div class="col-md-4">
                        <input class="form-control js-date-field bg-transparent" type="date" name="date" value="{{date('Y-m-d')}}" id="date">
                   </div>
                   <div class="col-md-2 ml-auto mt-md-0 mt-2">
                       <button class="btn form-control btn-sm btn-info">Search</button>
                   </div>
               </div>
            </form>
           </div>
        </div>
    </div>
    <div class="col-12  my-5">
        <div class="card card-info">
           <div class="card-header">
               <div class="row">
                   <div class="col-12">
                       <h5 class="mb-0 text-center ">
                        Today ({{$date}})  in Leave: {{count($leave)}}
                       </h5>
                   </div>
               </div>
           </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row d-flex justify-content-center">
            
            @foreach($leave as $l)
           
             @foreach($employee as $e)
              @if($e->emp_id == $l->emp_id)
             
            {{-- start from here --}}
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                       <p class="mb-0">
                        {{$l->emp_id}}
                       </p>
                        <a href="http://">{{$e->name}}</a>
                        <p class="mb-0 ">{{$e->userDesignation->designation}}</p>
                        <p class="mb-0">{{$e->department->dept_name}}</p>
                    </div>
                    <div class="card-footer bg-light">
                     <div class="row">
                         <div class="col-12 bg-info"> 
                             <p class="mb-0  text-center">Will join on : {{date('Y-m-d', strtotime( $l->leave_end . "+ 1 days"));}}</p>
                         </div>
                         
                     </div>
                     <div class="row mt-2">
                        
                            <a href={{ "view-leave-list/". $l->emp_id."/".$l->leave_start}} class="btn btn-block btn-sm btn-warning">Show Leave</a>
                        
                     </div>
                     
                    </div>
                </div>
            </div>
            {{-- ///end one card --}}
             
            {{-- <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center mb-0">No Leaves Found {{$date}}</h1>
                    </div>
                </div>
              </div> --}}
              @endif
             @endforeach
            @endforeach
        </div>
    </div>
{{-- //today leave --}}



{{-- join today --}}
<div class="col-12  my-5">
    <div class="card card-info">
       <div class="card-header">
           <div class="row">
               <div class="col-12">
                   <h5 class="mb-0 text-center ">
                    Joined Today({{$date}}) after spent their leave: {{count($joined)}}
                   </h5>
               </div>
           </div>
       </div>
    </div>
</div>
{{-- to print emp card --}}
<div class="col-12 mb-5">
    <div class="row d-flex justify-content-center">
        @foreach($joined as $j)
         @foreach($employee as $e)
          @if($e->emp_id == $j->emp_id)
        {{-- start from here --}}
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                   <p class="mb-0">
                    {{$j->emp_id}}
                   </p>
                    <a href="http://">{{$e->name}}</a>
                    <p class="mb-0">{{$e->userDesignation->designation}}</p>
                    <p class="mb-0">{{$e->department->dept_name}}</p>
                </div>
                <div class="card-footer">
                    <div class="row mt-2">
                        <a href={{ "view-leave-list/". $j->emp_id."/".$j->leave_start}} class="btn btn-block btn-sm btn-warning">Show Leave</a>
                    </div>
                </div>
                
            </div>
        </div>
        {{-- ///end one card --}}
          @endif
         @endforeach
        @endforeach
       
    </div>
</div>
{{-- //join today --}}
</div>


@endsection
<!-- end editing-->
@endsection
@endsection
@endsection

@section('script')
@parent
<script>
    $(function() {
        bsCustomFileInput.init();

        //Date field customization
        $('.js-time-field').flatpickr();
    });
</script>
@endsection
@endsection