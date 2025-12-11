
@extends('layouts.patient')

@section('page_title', 'Appointment Details')

@section('content')

<div class="container py-4">
    <a href="{{ route('patient.appointment.dashboard') }}" class="mb-3 d-inline-block">&larr; Back to Appointments</a>
    <h2 class="mb-4">Appointment Details</h2>
    @if(isset($appointment))
    <div class="row">
        <div class="col-md-8">
            <!-- Patient Information Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-light text-center" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:1.5em;font-weight:600;color:#3db2a5;">
                            {{ strtoupper(substr($appointment->patient->first_name ?? '', 0, 1)) }}{{ strtoupper(substr($appointment->patient->last_name ?? '', 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <span class="font-weight-bold" style="font-size:1.1em;">{{ $appointment->patient->first_name ?? '' }} {{ $appointment->patient->last_name ?? '' }}</span><br>
                            <span class="text-muted">Patient</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <i class="fa fa-envelope text-muted mr-2"></i>{{ $appointment->patient->email ?? '' }}<br>
                            <i class="fa fa-calendar text-muted mr-2"></i>DOB: {{ $appointment->patient->date_of_birth ?? '' }}
                        </div>
                        <div>
                            <i class="fa fa-phone text-muted mr-2"></i>{{ $appointment->patient->contact_number ?? '' }}<br>
                            <i class="fa fa-user text-muted mr-2"></i>{{ $appointment->patient->gender ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Appointment Information Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-calendar text-customTeal mr-2"></i>
                        <h5 class="card-title mb-0">Appointment Information</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('l, F d, Y') }}<br>
                            <strong>Type:</strong> {{ strtoupper($appointment->type ?? 'CONSULTATION') }}
                        </div>
                        <div class="col-md-6">
                            <strong>Time:</strong> {{ date('h:i A', strtotime($appointment->appointment_time)) }}<br>
                            <strong>Method:</strong> {{ $appointment->method ?? 'Video Call' }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- Health Issues Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-heartbeat text-danger mr-2"></i>
                        <h5 class="card-title mb-0">Health Issues</h5>
                    </div>
                    <strong>Reason for Appointment:</strong> {{ $appointment->reason ?? '' }}<br>
                    <strong>Symptoms:</strong> {{ $appointment->symptoms ?? '' }}<br>
                    <strong>Allergies:</strong> {{ $appointment->allergies ?? '' }}
                </div>
            </div>
            <!-- Healthcare Provider Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-user-md text-customTeal mr-2"></i>
                        <h5 class="card-title mb-0">Healthcare Provider</h5>
                    </div>
                    <strong>{{ $appointment->doctor->name ?? 'N/A' }}</strong><br>
                    <span class="text-muted">Healthcare Provider</span><br>
                    <i class="fa fa-envelope text-muted mr-2"></i>{{ $appointment->doctor->email ?? '' }}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <!-- Payment Details Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-credit-card text-success mr-2"></i>
                        <h5 class="card-title mb-0">Payment Details</h5>
                    </div>
                    <strong>Status:</strong> <span class="badge badge-success">{{ $appointment->payment && $appointment->payment->status == 'succeeded' ? 'SUCCEEDED' : 'PENDING' }}</span><br>
                    <strong>Payment Method:</strong> {{ $appointment->payment->method ?? 'Insurance' }}
                </div>
            </div>
            <!-- Actions Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-paperclip text-muted mr-2"></i>
                        <h5 class="card-title mb-0">Actions</h5>
                    </div>
                    <button class="btn btn-outline-secondary w-100" disabled>View attachments</button>
                </div>
            </div>
            <!-- Quick Info Card -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa fa-info-circle text-customTeal mr-2"></i>
                        <h5 class="card-title mb-0">Quick Info</h5>
                    </div>
                    <strong>Created:</strong> {{ \Carbon\Carbon::parse($appointment->created_at)->format('M d, Y') }}<br>
                    <strong>Last Updated:</strong> {{ \Carbon\Carbon::parse($appointment->updated_at)->format('M d, Y') }}<br>
                    <strong>Appointment ID:</strong> {{ $appointment->token }}
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="alert alert-danger">Appointment not found.</div>
    @endif
</div>
@endsection
                        </svg>
