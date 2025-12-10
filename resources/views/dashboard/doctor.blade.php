@extends('layouts.doctor')
@section('title', 'Doctor Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-1">Welcome Dr. {{ Auth::user()->name }}</h3>
                            <p class="text-muted mb-0">Manage your appointments and patient care efficiently</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="bg-primary text-white rounded p-3">
                                <h5 class="mb-0">Today</h5>
                                <h3 class="mb-0">{{ now()->format('M d, Y') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Appointment Cards -->
    <div class="row">
        <!-- Upcoming Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Upcoming Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $upcomingCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.upcoming') }}" class="btn btn-sm btn-outline-primary">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Finished Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Finished Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $finishedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.finished') }}" class="btn btn-sm btn-outline-success">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unconfirmed Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Unconfirmed Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unconfirmedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.unconfirmed') }}" class="btn btn-sm btn-outline-warning">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Follow-up Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Follow-up Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $followUpCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-redo fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.follow-up') }}" class="btn btn-sm btn-outline-info">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Walk-in Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-secondary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                Walk-in Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $walkInCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-walking fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.walk-in') }}" class="btn btn-sm btn-outline-secondary">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Cancelled Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $cancelledCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.cancelled') }}" class="btn btn-sm btn-outline-danger">View details</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Unfinished Appointments -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                                Unfinished Appointments
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unfinishedCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('doctor.appointments.unfinished') }}" class="btn btn-sm btn-outline-dark">View details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Appointments & Doctor Info -->
    <div class="row">
        <!-- Today's Appointments -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day me-2"></i>Today's Appointments
                    </h5>
                </div>
                <div class="card-body">
                    @if($todayAppointments->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Time</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todayAppointments as $appointment)
                                        <tr>
                                            <td>
                                                @if($appointment->patient)
                                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $appointment->appointment_time }}</td>
                                            <td>
                                                <span class="badge {{ $appointment->priority == 'urgent' ? 'bg-danger' : 'bg-info' }}">
                                                    {{ ucfirst($appointment->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning">{{ ucfirst($appointment->status) }}</span>
                                            </td>
                                            <td>
                                                @if($appointment->status == 'pending')
                                                    <form action="{{ route('doctor.confirm.appointment', $appointment->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No appointments scheduled for today</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Doctor Information -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-md me-2"></i>Doctor Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user-md fa-2x text-white"></i>
                        </div>
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>Dr. {{ Auth::user()->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ Auth::user()->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Organization:</strong></td>
                            <td>OurPhoneMD Clinic</td>
                        </tr>
                        @isset($doctor)
                            <tr>
                                <td><strong>Specialization:</strong></td>
                                <td>{{ $doctor->specialization ?? 'General Practitioner' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Qualification:</strong></td>
                                <td>{{ $doctor->qualification ?? 'MBBS' }}</td>
                            </tr>
                        @endisset
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
