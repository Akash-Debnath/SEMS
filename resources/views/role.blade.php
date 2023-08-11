@extends('index')
@section('title', '| Role & Permission')

{{-- @author Akash Chandra Debnath
@Behaviour add new roles and permission --}}

@section('wrapper')
@parent
@section('content-wrapper')
@parent
@section('content-header')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h4>Roles & Permission</h4>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Remark </a></li>
                    <li class="breadcrumb-item"><a href="#">Attachment </a></li>
                    <li class="breadcrumb-item active">Attachment Board </li>
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
<div class="row d-flex justify-content-center ">
   <div class="col-12">
    <div class="card">
        @if(Auth::user()->can('roleAndPermission-create'))
            <div class="card-header d-flex justify-content-end">
                <a href="{{ route('roles.create') }}"><button class="btn btn-info btn-sm">Add New Role</button></a>
            </div>
        @endif

        <div class="card-body">
            <table class="table table-bordered">
               <thead>
                <tr>
                    <th>SL</th>
                    <th>Role</th>
                    <th>Permission</th>
                    @if (Auth::user()->can('roleAndPermission-edit') || Auth::user()->can('roleAndPermission-delete'))
                        <th class="text-center">Action</th>
                    @endif
                </tr>
               </thead>
               <tbody>
                <?php $i = $roles->currentPage() == 1 ? 0 : ($roles->currentPage() - 1) * 20; ?>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach ($role->permissions as $perm)
                                <span class="badge badge-info mr-1">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="d-flex justify-content-center">
                            @if(Auth::user()->can('roleAndPermission-edit'))
                                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>
                            @endif
                            @if(Auth::user()->can('roleAndPermission-delete'))
                                <form action="{{ route('roles.destroy', $role->id) }}" method="post" style="display:unset;" class="ml-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete role : {{ $role->name }}?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    </svg></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
               </tbody>
            </table>
        </div>
        <div class="card-footer overflow-auto ">
            {!! $roles->Links('pagination::bootstrap-4') !!}
        </div>
    </div>
   </div>
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
    setTimeout(function() {
        $('#successMsg').fadeOut('slow');
        $('#failMsg').fadeOut('slow');
    }, 3000);
</script>
@endsection
@endsection