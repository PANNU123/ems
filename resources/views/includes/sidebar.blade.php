 <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('backend.dashboard')}}" class="brand-link">
      <img src="{{asset('assets/dist/img/ems1.png')}}" alt="DHL Logo" class="elevation-2" style="height: 100px;width: 230px;">
{{--      <span class="brand-text font-weight-light">AdminLTE 3</span>--}}
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{route('backend.dashboard')}}" class="nav-link {{Route::is('backend.dashboard') ? "active" : ""}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

            {{-- menu-open --}}
            <li class="nav-item">
                <a href="{{route('backend.academic.type.index')}}" class="nav-link {{Route::is('backend.academic.type.index') ? "active" : ""}}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Academic Type
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{route('backend.subject.index')}}" class="nav-link {{Route::is('backend.subject.index') ? "active" : ""}}">
                    <i class="nav-icon fas fa-th"></i>
                    <p>
                        Manage Subject
                    </p>
                </a>
            </li>
          <li class="nav-item  {{ Route::is('backend.user.list*') || Route::is('backend.role.list*') ? "menu-open" : "" }}">
            <a href="#" class="nav-link {{ Route::is('backend.user.list*') || Route::is('backend.role.list*') ? "active" : "" }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                User Management
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('backend.user.list')}}" class="nav-link {{Route::is('backend.user.list*') ? "active" : ""}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>User List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('backend.role.list')}}" class="nav-link {{Route::is('backend.role.list*') ? "active" : ""}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Role</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
    </div>
  </aside>
