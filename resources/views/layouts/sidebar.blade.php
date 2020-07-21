  <aside class="main-sidebar">

    <section class="sidebar">

      <!-- <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset("/bower_components/AdminLTE/dist/img/icon.png") }}">
        </div> -->
        <!-- <div class="pull-left info">
          <p>{{ Auth::user()->email}}</p> -->
            <!-- <div class="main-header navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
                                <p>Hello {{ Auth::user()->username }}</p>
                            </li>
                            <li class="user-footer">
                                @if (Auth::guest())
                                <div class="pull-left">
                                    <a href="{{ route('login') }}" class="btn btn-default btn-flat">Login</a>
                                </div>
                                @else
                                <div class="pull-left">
                                    <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a class="btn btn-default btn-flat" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                </div>
                                @endif
                            </li>
                        </ul>
                    </li>
                </ul>
            </div> -->
        <!-- </div> -->

        

      <!-- </div> -->
      <ul class="sidebar-menu">
        <li class="active">
          <a href="{{ route('map.index') }}">
            <i class="icon icon-measure undefined" style="background: url(&quot;../../../bower_components/AdminLTE/dist/img/logo.png&quot;) center center no-repeat;"></i> 
            <span style="padding-left: 30px;">Measurements</span>
          </a>
        </li>


        <!-- <li><a href="{{ url('employee-management') }}"><i class="fa fa-link"></i> <span>Employee Management</span></a></li> -->
        <!-- <li class="treeview">
          <a href="#"><i class="fa fa-link"></i> <span>System Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ url('system-management/department') }}">Department</a></li>
            <li><a href="{{ url('system-management/division') }}">Division</a></li>
            <li><a href="{{ url('system-management/country') }}">Country</a></li>
            <li><a href="{{ url('system-management/state') }}">State</a></li>
            <li><a href="{{ url('system-management/city') }}">City</a></li>
            <li><a href="{{ url('system-management/report') }}">Report</a></li>
          </ul>
        </li> -->
        <!-- <li><a href="{{ route('map.index') }}"><i class="fa fa-link"></i> <span>User management</span></a></li> -->
      </ul>
    </section>
  </aside>