@extends('layouts.app')

@section('title', 'Appointment Details - OurPhoneMD')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-calendar-check me-2"></i>Appointment Details
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Patient Information</h5>
                            @if($appointment->patient)
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Name:</strong></td>
                                    <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>{{ $appointment->patient->email }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td>{{ $appointment->patient->contact_number }}</td>
                                </tr>
                                <!-- REMOVED MISSING FIELDS: cnic, blood_group, medical_history -->
                            </table>
                            @else
                            <p class="text-muted">Patient information not available.</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h5>Appointment Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Date:</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Time:</strong></td>
                                    <td>{{ $appointment->appointment_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Priority:</strong></td>
                                    <td>
                                        <span class="badge {{ $appointment->priority == 'urgent' ? 'bg-danger' : 'bg-info' }}">
                                            {{ ucfirst($appointment->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge
                                            @if($appointment->status == 'confirmed') bg-success
                                            @elseif($appointment->status == 'pending') bg-warning
                                            @elseif($appointment->status == 'cancelled') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Symptoms:</strong></td>
                                    <td>{{ $appointment->symptoms ?: 'Not specified' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5>Actions</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('doctor.dashboard') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                </a>
                                @if($appointment->status == 'pending')
                                    <form action="{{ route('doctor.confirm.appointment', $appointment->id) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-2"></i>Confirm Appointment
                                        </button>
                                    </form>
                                    <form action="{{ route('doctor.cancel.appointment', $appointment->id) }}" method="POST" class="d-inline ms-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                            <i class="fas fa-times me-2"></i>Cancel Appointment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
