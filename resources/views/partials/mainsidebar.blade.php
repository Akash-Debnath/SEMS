<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
      <img src="{{asset('dist/img/logo.svg')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
      <span class="brand-text font-weight-bolder">EMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('EmployeePhoto/'.Auth::user()->employeeInfo->image) }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ url('/') }}" class="d-block">{{Auth::user()->employeeInfo->name}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
            
          <li class="nav-item " >
            
            <a href="pages/widgets.html" class="nav-link ">
              <i class="nav-icon fas fa-id-card-alt"></i>
              <p>
                Employee
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url('employees') }}" class="nav-link  ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>All
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Profile Update History</p>
                  </a>
                </li> 

              {{-- @foreach ($employeeDept as $dept)            
                <li class="nav-item">
                  <a href="{{ url('employees?dept_code='.$dept->dept_code) }}" class="nav-link ">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $dept->dept_name }}</p>
                  </a>
                </li>
              @endforeach --}}
          </li>
        </ul>

          <li class="nav-item menu-open">
            <a href="pages/widgets.html" class="nav-link ">
              <i class="nav-icon fas fa-columns"></i>
              <p>
                Board
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('notice')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notice
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('attachment')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attachment
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('policy')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Policy
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('holiday')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Holiday
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('incident')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Incident
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('job.desc')}}" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Job Description
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Leave
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Leave List
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>At a Glance
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Yearly Leave Report
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pending
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Today's Leave
                    <span class="badge badge-info right">6</span>
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-archive"></i>
              <p>
                Archive
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Settings
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Department
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Designation
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Facility
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Note
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Administration Privilege
                    <span class="badge badge-info right">6</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Permission Privilege
                    <span class="badge badge-info right">6</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Office Time
                    <span class="badge badge-info right">6</span>
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-moon"></i>
              <p>
                Ramadan Time
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Set Ramadan list
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="pages/widgets.html" class="nav-link">
              <i class="nav-icon fas fa-file-export"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Report
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Today's Employee
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Late/Early Request
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Late/Early Request Pending
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Missing Att. Req. Pending
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Office Schedule
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roster Set
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employee-list.html" class="nav-link ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Roster Pending
                  </p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>