<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Doctor Dashboard - OurPhoneMD')</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

    <style>
        .navbar-lightgreen {
            background-color: #28a745 !important;
        }
        .navbar-lightgreen .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        .navbar-lightgreen .navbar-nav .nav-link:hover {
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-lightgreen navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('doctor.dashboard') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('patient.logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('doctor.dashboard') }}" class="brand-link">
            <i class="fas fa-user-md brand-icon"></i>
            <span class="brand-text font-weight-light">OurPhoneMD - Doctor</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="#" class="d-block">
                        <i class="fas fa-user-circle mr-2"></i>
                        Dr. {{ Auth::user()->name }}
                    </a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('doctor.dashboard') }}" class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.upcoming') }}" class="nav-link {{ request()->routeIs('doctor.appointments.upcoming') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Upcoming Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.unconfirmed') }}" class="nav-link {{ request()->routeIs('doctor.appointments.unconfirmed') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-clock"></i>
                            <p>Unconfirmed Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.follow-up') }}" class="nav-link {{ request()->routeIs('doctor.appointments.follow-up') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-redo"></i>
                            <p>Follow-up Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.walk-in') }}" class="nav-link {{ request()->routeIs('doctor.appointments.walk-in') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-walking"></i>
                            <p>Walk-in Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.finished') }}" class="nav-link {{ request()->routeIs('doctor.appointments.finished') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>Finished Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.cancelled') }}" class="nav-link {{ request()->routeIs('doctor.appointments.cancelled') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-times-circle"></i>
                            <p>Cancelled Appointments</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('doctor.appointments.unfinished') }}" class="nav-link {{ request()->routeIs('doctor.appointments.unfinished') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hourglass-half"></i>
                            <p>Unfinished Appointments</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('doctor.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">@yield('page_title', 'Dashboard')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 OurPhoneMD.</strong> All rights reserved.
    </footer>
</div>

<!-- AdminLTE JS -->
<script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
