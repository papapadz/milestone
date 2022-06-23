<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'Task and Inventory Management') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white" style="background-color:#EFEFD0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars text-red"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('dashboard') }}" class="nav-link text-red">Home</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-dark elevation-5" style="background-color:#EFEFD0">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{asset('images/Logo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light text-red"> <strong>Milestone</strong> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('assets/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        @php
            if(session()->has('admin'))
            {
              $admin = session()->get('admin');
            }

            if(session()->has('ceo'))
            {
              $ceo = session()->get('ceo');
            }

            if(session()->has('manager'))
            {
              $manager = session()->get('manager');
            }

            else
              $employee = session()->get('employee')
        @endphp
        <div class="info">
          <a href="#" class="d-block text-dark">
            @if(isset($ceo))
              {{$ceo['firstname'] .' '. $ceo['lastname']}}
            @elseif(isset($manager))
              {{$manager['firstname'] .' '. $manager['lastname']}}
            @elseif(isset($employee))
              {{$employee['firstname'] .' '. $employee['lastname']}}
            @else
              Admin
            @endif
          </a>
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
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('dashboard') }}" class="nav-link @if(Request::url() === url('home')) active @endif">
                    <i class="nav-icon fa-solid fas fa-warehouse text-red"></i>
                    <p class="text-red">Dashboard</p>
                  </a>
                </li>
              </ul>
            </li>
            @if((Auth::user()->role == 'ceo')||(Auth::user()->role == 'manager'))
            <li class="nav-item menu-is-opening {{request()->is('supply') || request()->is('suppliers') || Request::url() === url('add-supplier') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chart-pie"></i>
                <p> Inventory <i class="right fas fa-angle-left"></i> </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('supply') }}" class="nav-link {{request()->is('supply') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Products</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ route('suppliers') }}" class="nav-link {{request()->is('suppliers') || Request::url() === url('add-supplier')? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Suppliers</p>
                  </a>
                </li>
              </ul>
              </li>
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('task') }}" class="nav-link @if(Request::url() === url('task') || Request::url() === url('add-task')) active @endif">
                    <i class="nav-icon fa-solid fas fa-tasks text-red"></i>
                    <p class="text-red">Task</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('addEmployee') }}" class="nav-link  @if(Request::url() === url('add-employee')) active @endif">
                    <i class="nav-icon fa-solid fas fa-user-plus text-red"></i>
                    <p class="text-red">Add Employee</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->role == 'admin')
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('userLists') }}" class="nav-link  @if(Request::url() === url('user-lists') || Request::url() === url('add-user')) active @endif">
                    <i class="nav-icon fa-solid fas fa-users text-red"></i>
                    <p class="text-red">Users</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->role == 'ceo')
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('employeeDirectory') }}" class="nav-link @if(Request::url() === url('employee-directory')) active @endif">
                    <i class="nav-icon fa-solid fas fa-address-book text-red"></i>
                    <p class="text-red">Employee Directory</p>
                  </a>
                </li>
              </ul>
            </li>
            @endif
            @if(Auth::user()->role == 'employee')
                <li class="nav-item menu-is-opening menu-open">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p> Inventory <i class="right fas fa-angle-left"></i> </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('supply') }}" class="nav-link {{request()->is('supply') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        @endif
            <li class="nav-item menu-open">
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('manageAccount') }}" class="nav-link  @if(Request::url() === url('manage-account')) active @endif">
                    <i class="nav-icon fa-solid fas fa-user-cog text-red"></i>
                    <p class="text-red">Manage Account</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
            {{-- <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt text-red"></i>
              <p class="text-red">
                Logout
              </p>
            </a> --}}
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                <i class="nav-icon fas fa-sign-out-alt text-red"></i>
                <p class="text-red">{{ __('Logout') }}</p>
            </a>
            
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
  </form>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div>
        @yield('content')
    </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- Main Footer -->
<footer class="main-footer font-small teal pt-4">
      <div class="container-fluid text-center text-md-left">
          <div class="row">
              <div class="col-md-6 mt-md-0 mt-3">
                  <h5 class="text-uppercase font-weight-bold">Contact Us</h5>
                  <span>milestone.ph@gmail.com</span> <br>
                  <span>(02) 7712 3456</span>
              </div>
              <hr class="clearfix w-100 d-md-none pb-3">
              <div class="col-md-6 mb-md-0 mb-3">
                  <h5 class="text-uppercase font-weight-bold">About</h5>
                  <p>An Inventory and Task Management System </p>
              </div>
          </div>
      </div>
      <div class="footer-copyright text-center py-3 w-100">© 2022 Copyright:
          <a href="https://mdbootstrap.com/"> Milestone</a>. <span>All Rights Reserved</span>
      </div>
  </footer>

@include('sweetalert::alert')
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
@yield('scripts')
</body>
</html>
