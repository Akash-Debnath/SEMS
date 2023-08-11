<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light layout-fixed layout-navbar-fixed">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link d-flex align-items-center justify-content-center" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="font-size: 23px;"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto navbar-logout">


      <!-- Notifications Dropdown Menu -->
      {{-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell" style="font-size: 25px;"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li> --}}

        <!-- settings Dropdown Menu -->
        <li class="nav-item dropdown">
        <a class="nav-link d-flex  justify-content-center align-items-center user-panel-image" data-toggle="dropdown" href="#" aria-expanded="false">

          <img class=" img-circle img-thumbnail" style="height:25px; width:25px;" src="{{ asset('EmployeePhoto/'.Auth::user()->employeeInfo->image) }}" alt="User">

          {{-- @if (!is_null(Auth::user()->employeeInfo->image) && !file_exists(public_path().'/EmployeePhoto'.Auth::user()->employeeInfo->image))
          <img class=" img-circle img-thumbnail" style="height:25px; width:25px;" src="{{ asset('EmployeePhoto/'.Auth::user()->employeeInfo->image) }}" alt="User">
          @else
          <img src="{{ asset('EmployeePhoto/default.png') }}" class="img-circle elevation-2" alt="No Image">
          @endif --}}
          <span class="float-right text-light text-md ml-1 " >{{ Auth::user()->employeeInfo->name }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Settings</span>



          <div class="dropdown-divider"></div>
          <a href="{{ url('change-password') }}" class="dropdown-item">
            <i class="fas fa-edit mr-2"></i> Change Password
            <span class="float-right text-muted text-sm">3 mins ago</span>
          </a>

          <div class="dropdown-divider"></div>
          <a href="{{ url('/') }}" class="dropdown-item">
            <i class="fas fa-eye mr-2" ></i> View Profile
            <span class="float-right text-muted text-sm">3 mins ago</span>
          </a>

          <div class="dropdown-divider"></div>
          <form id="logout-form" action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-info ml-auto btn-sm  form-control rounded-0  dropdown-item" style="font-size: 1.06rem;" data-toggle="modal" data-target="#modal-default">
              <div class="center">
                <i class="fas fa-sign-out-alt mr-2"></i>  Logout
              </div>
            </button>
          </form>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
