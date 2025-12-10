@extends('adminlte::master')

@section('title', 'Patient Dashboard - OurPhoneMD')

@section('plugins.Datatables', false)
@section('plugins.TempusDominusBs4', false)
@section('plugins.TempusDominusBs5', false)
@section('plugins.Select2', false)
@section('plugins.Chartjs', false)
@section('plugins.Sweetalert2', false)
@section('plugins.Toastr', false)
@section('plugins.IziToast', false)
@section('plugins.FontAwesome', false)

@section('adminlte_css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background: #f8fafc;
        }

        .main-header {
            background: #fff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            min-height: 64px;
            padding: 20px 0;
        }

        /* Reduce width of main header */
        nav.main-header {
            max-width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .navbar-brand {
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .navbar-nav .nav-link {
            color: #1a2e35 !important;
            font-weight: 500;
            font-size: 16px;
        }

        .navbar-nav .nav-link:hover {
            color: #3EA293 !important;
        }

        .action-btn,
        .action-btn.secondary {
            background: #3EA293 !important;
            color: #fff !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            padding: 10px 24px !important;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.08);
            border: none;
            margin-right: 10px;
            transition: background 0.2s;
        }

        .action-btn.secondary {
            background: #51A897 !important;
        }

        .action-btn:hover,
        .action-btn.secondary:hover {
            background: #2e8c7e !important;
            color: #fff !important;
        }

        .main-sidebar {
            background: #fff !important;
            border-right: 1.5px solid #ffffff !important; /* Lightened the right border even more */
            min-width: 250px;
        }

        /* Remove shadow from aside menu */
        aside.main-sidebar.elevation-4 {
            box-shadow: none !important;
            border-radius: 0 !important;
        }

        /* Lighten the left border of sidebar navigation */
        .sidebar .nav-sidebar {
            border-left: 2.5px solid #ffffff;
            padding-left: 8px;
        }

        .sidebar .nav-sidebar .nav-link {
            color: #1a2e35 !important;
            font-size: 16px;
            font-weight: 500;
            border-radius: 6px;
            margin-bottom: 6px;
            padding: 10px 18px;
            transition: all 0.2s;
            border: none !important;
            box-shadow: none !important;
        }

        /* Active state styles - No border, no shadow */
        .sidebar .nav-sidebar .nav-link.active {
            background: #EDF6F4 !important;
            color: #62B1A1 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar .nav-sidebar .nav-link.active .nav-icon {
            color: #62B1A1 !important;
        }

        .sidebar .nav-sidebar .nav-link.active p {
            color: #51A897 !important;
            font-weight: 600;
        }

        .sidebar .nav-sidebar .nav-link:hover {
            background: #e6f7f3 !important;
            color: #3EA293 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .sidebar .nav-icon {
            margin-right: 10px;
            font-size: 18px;
            transition: color 0.2s;
            -webkit-text-stroke:3px #000000;
            paint-order: stroke fill;
            color: white !important;
            text-shadow: none !important;
        }

        /* For active and hover states */
        .sidebar .nav-sidebar .nav-link.active .nav-icon {
            -webkit-text-stroke: 2px #62B1A1 !important;
            color: white !important;
        }

        .sidebar .nav-sidebar .nav-link:hover .nav-icon {
            -webkit-text-stroke: 2px #3EA293 !important;
            color: white !important;
        }

        .sidebar .user-panel {
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        .sidebar .user-panel .info a {
            color: #1a2e35 !important;
            font-weight: 600;
        }

        .content-wrapper {
            background: #f8fafc !important;
            border-left: 2px solid #d3d3d3 !important;
            min-height: 100vh;
        }

        .main-footer {
            background: #fff;
            border-top: 1px solid #e5e7eb;
            color: #888;
            font-size: 15px;
        }

        /* Dashboard Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-top: 32px;
        }

        .stat-card {
            background: #f9fdfc;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.07);
            padding: 32px 24px 24px 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            position: relative;
            border: 1.5px solid #e5e7eb;
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 18px;
            font-size: 24px;
        }

        .stat-card .stat-number {
            font-size: 2.2rem;
            font-weight: 700;
            color: #1a2e35;
            margin-bottom: 6px;
        }

        .stat-card .stat-label {
            color: #3EA293;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .stat-card .stat-link {
            color: #1976d2;
            font-size: 0.98rem;
            font-weight: 500;
            margin-top: auto;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .support-card {
            background: linear-gradient(135deg, #67e8f9 0%, #3EA293 100%);
            color: #fff;
            padding: 32px 24px;
            border-radius: 14px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            min-height: 180px;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.10);
        }

        .support-title {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .support-subtitle {
            font-size: 1.05rem;
            opacity: 0.95;
            margin-bottom: 18px;
        }

        .support-btn {
            background: #fff;
            color: #3EA293;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(62, 162, 147, 0.08);
            transition: background 0.2s, color 0.2s;
        }

        .support-btn:hover {
            background: #e6f7f3;
            color: #1976d2;
        }

        /* Divider lines */
        .sidebar hr,
        .main-header hr {
            border: none;
            border-top: 1.5px solid #e5e7eb;
            margin: 12px 0;
        }

        .sidebar .nav-sidebar {
            border-left: 2.5px solid #e5e7eb;
            padding-left: 8px;
        }

        /* New styles for header dropdown */
        .user-dropdown {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 6px;
            transition: background 0.2s;
        }

        .user-dropdown:hover {
            background: #f5f5f5;
        }

        .user-email {
            margin-right: 8px;
            font-weight: 500;
            color: #1a2e35;
        }

        .dropdown-icon {
            font-size: 12px;
            color: #6b7280;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 8px 0;
            min-width: 160px;
        }

        .dropdown-item {
            padding: 8px 16px;
            color: #1a2e35;
            display: flex;
            align-items: center;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: #e6f7f3;
            color: #3EA293;
        }

        .dropdown-item i {
            margin-right: 8px;
            width: 16px;
            text-align: center;
            color: #51A897 !important;
        }
        .user-profile-icon {
            font-size: 18px;
            color: #51A897;
            background-color: transparent !important;
            vertical-align: middle;
        }
    </style>
@stop

@section('body')
    <div class="wrapper patient-flex-layout">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-lightgreen navbar-light"
            style="background-color: white !important; border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('patient.dashboard') }}" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Center navbar links -->
            <ul class="navbar-nav mx-auto" style="transform: translateX(180px);">
                <li class="nav-item" style="margin-right: 15px;">
                    <a href="{{ route('patient.appointment.dashboard') }}" class="action-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Book New Appointment
                    </a>
                </li>
                <li class="nav-item" style="margin-right: 15px;">
                    <a href="/patient/family-member" class="action-btn secondary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Family Members
                    </a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto" >
                <li class="nav-item dropdown">
                    <a class="nav-link user-dropdown" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-user user-profile-icon"></i>
                        <span class="user-email" style="margin-left: 5px;">{{ Auth::guard('patient')->user()->email ?? 'user@example.com' }}</span>
                        <i class="dropdown-icon fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="{{ route('patient.profile') }}" class="dropdown-item">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('patient.logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4"
            style="background-color: rgba(255, 255, 255, 0.1) !important; backdrop-filter: blur(10px) !important; -webkit-backdrop-filter: blur(10px) !important;">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center justify-content-center" href="{{ route('patient.dashboard') }}"
                style="font-size: 20px; font-weight: 600; margin-top: 20px; padding: 0 10px; text-align: center; width: 100%;">
                <i class="fas fa-stethoscope me-1" style="color: black; font-size: 16px;"></i>
                <span style="color: #3EA293;">OurPhone</span><span style="color: #FF3B3B;">MD</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    {{-- <div class="info">
                        <a href="#" class="d-block"
                            style="color: black !important;">{{ Auth::guard('patient')->user()->first_name }}
                            {{ Auth::guard('patient')->user()->last_name }}</a>
                    </div> --}}
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item">
                            <a href="{{ route('patient.dashboard') }}" class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-home"></i>
                                <p style="color: black !important;">Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/patient/appointment-dashboard" class="nav-link {{ request()->is('patient/appointment-dashboard') ? 'active' : '' }}"
                                style="color: black !important;">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p style="color: black !important;">Appointments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/patient/family-member" class="nav-link {{ request()->is('patient/family-member') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-users"></i>
                                <p style="color: black !important;">Family Members</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('patient.insurance') }}" class="nav-link {{ request()->routeIs('patient.insurance') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-id-card"></i>
                                <p style="color: black !important;">Insurance</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('patient.faqs') }}" class="nav-link {{ request()->routeIs('patient.faqs') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-question-circle"></i>
                                <p style="color: black !important;">FAQs</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('patient.contact-us') }}" class="nav-link {{ request()->routeIs('patient.contact-us') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p style="color: black !important;">Contact Us</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('patient.profile') }}" class="nav-link {{ request()->routeIs('patient.profile') ? 'active' : '' }}" style="color: black !important;">
                                <i class="nav-icon fas fa-user"></i>
                                <p style="color: black !important;">Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper"
            style="background-color: white !important; border-left: 2px solid rgb(87, 165, 150);">
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            {{-- <strong>Copyright &copy; 2024 OurPhoneMD.</strong>. --}}
        </footer>
    </div>
    @yield('scripts')
@stop
