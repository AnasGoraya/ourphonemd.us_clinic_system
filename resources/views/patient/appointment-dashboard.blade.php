@extends('layouts.patient')

@section('page_title', 'My Appointments')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div id="dashboardContent" class="flex-1 p-4 lg:ml-0">
    <div class="w-full px-0 py-6 md:max-w-7xl md:mx-auto md:px-2 lg:px-8">
        <div class="mb-8">
            <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">My Appointments</h1>
            <p class="text-muted" style="font-size: 1.05rem;">Manage your healthcare appointments</p>
        </div>
        <div class="mb-8">
            <div class="appointment-card rounded-xl border bg-white shadow-sm p-0">
                <div class="p-4 pb-0">
                    <div class="d-flex align-items-center justify-content-between pb-3">
                        <div class="h5 font-weight-bold text-customTeal mb-0">Appointment Management</div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-7 w-7 text-customTeal">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2"></rect>
                            <line x1="16" x2="16" y1="2" y2="6"></line>
                            <line x1="8" x2="8" y1="2" y2="6"></line>
                            <line x1="3" x2="21" y1="10" y2="10"></line>
                        </svg>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus text-customTeal mr-2">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path>
                                        <path d="M3 10h18"></path>
                                        <path d="M16 19h6"></path>
                                        <path d="M19 16v6"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Schedule New Appointment</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Book a new appointment with available healthcare providers</p>
                                <a href="{{ route('patient.appointments.wizard.step1') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center;">
                                    Book Now ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-clock text-customTeal mr-2">
                                        <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"></path>
                                        <path d="M16 2v4"></path>
                                        <path d="M8 2v4"></path>
                                        <path d="M3 10h5"></path>
                                        <path d="M17.5 17.5 16 16.3V14"></path>
                                        <circle cx="16" cy="16" r="6"></circle>
                                    </svg>
                                    <span class="text-sm font-medium">View Calendar</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">View and manage all your scheduled appointments on calendar</p>
                                <button type="button" class="action-btn secondary" style="display: flex; align-items: center; justify-content: center;" onclick="showCalendar()">
                                    View Calendar ->
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-6">
<<<<<<< HEAD
                <div class="flex items-center justify-between mb-4">
                    <h2 style="font-size:2rem;font-weight:600;margin-bottom:0;">Upcoming Appointments</h2>
                    <a href="{{ route('patient.appointment.dashboard') }}" style="font-weight:500;font-size:1rem;text-decoration:none;color:#222;">
                        View All <span style="font-size:1.2em;vertical-align:middle;">&rarr;</span>
                    </a>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(400px,1fr));gap:32px;">
                    @forelse($appointments as $appointment)
                    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:24px 24px 16px 24px;display:flex;flex-direction:column;min-height:180px;position:relative;border-top:8px solid #3db2a5;">
                        <div style="font-size:1.1em;color:#7a8a9c;font-weight:500;letter-spacing:0.02em;margin-bottom:8px;">CONSULTATION</div>
                        <div style="display:flex;align-items:center;justify-content:space-between;">
                            <div style="display:flex;align-items:center;gap:16px;">
                                <div style="display:flex;align-items:center;gap:8px;">
                                    <span style="font-size:1.1em;"><i class="fa fa-calendar" style="margin-right:4px;"></i> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('D, M d, Y') }}</span>
                                    <span style="font-size:1.1em;"><i class="fa fa-clock-o" style="margin-right:4px;"></i> {{ date('h:i A', strtotime($appointment->appointment_time)) }}
                                        @if($appointment->appointment_end_time)
                                            - {{ date('h:i A', strtotime($appointment->appointment_end_time)) }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div>
                                @if($appointment->status == 'confirmed')
                                    <span style="background:#ff7f2a;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">In Progress</span>
                                @elseif($appointment->payment && $appointment->payment->status !== 'succeeded')
                                    <span style="background:#eab308;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">Pending Payment</span>
                                @else
                                    <span style="background:#eab308;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">Pending Payment</span>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:8px;">
                            <span style="font-size:1.1em;"><i class="fa fa-map-marker" style="margin-right:4px;"></i> Main Clinic</span>
                            <span style="font-size:1.1em;"><i class="fa fa-user" style="margin-right:4px;"></i> Anas</span>
                        </div>
                        <div style="margin-top:24px;display:flex;gap:12px;">
                            @if(!empty($appointment->token))
                                <a href="{{ url('/patient/appointments/' . $appointment->token) }}" style="text-decoration:none;">
                                    <button style="background:#fff;border:1.5px solid #e3e6f0;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#222;cursor:pointer;transition:background 0.2s;">View Details</button>
                                </a>
                            @endif
                                {{-- <button style="background:#fff;border:1.5px solid #e3e6f0;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#222;cursor:pointer;transition:background 0.2s;">View Details</button> --}}
                            </a>
                            @if($appointment->payment && $appointment->payment->status !== 'succeeded')
                            <button style="background:#eab308;border:none;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                <i class="fa fa-credit-card"></i> Pay For Appointment
                            </button>
                            @else
                            <button style="background:#f3f4f6;border:none;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#bbb;cursor:not-allowed;">Not Today</button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:32px;text-align:center;">
                        <div style="font-size:1.2em;color:#3db2a5;font-weight:600;margin-bottom:8px;">No Upcoming Appointments</div>
                        <div style="color:#7a8a9c;margin-bottom:16px;">You don't have any scheduled appointments at the moment.</div>
                        <a href="{{ route('patient.appointments.wizard.step1') }}">
                            <button style="background:#3db2a5;color:#fff;border:none;border-radius:8px;padding:12px 32px;font-size:1.1em;font-weight:500;">Book Appointment</button>
                        </a>
                    </div>
                    @endforelse
                </div>
=======
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Upcoming Appointments</h2>
                <a href="{{ route('patient.appointment.dashboard') }}">
                    <button class="inline-flex items-center justify-center whitespace-nowrap font-medium transition-colors focus-visible:outline-none focus-visible:ring-1 focus-visible:ring-ring disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground h-8 rounded-md px-3 text-xs gap-1">
                        View All
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right h-4 w-4">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </button>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($appointments as $appointment)
                    <div class="rounded-xl border bg-white shadow-sm p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-full bg-customTeal/10 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-customTeal">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                        <path d="M3 10h18"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">Appointment #{{ $appointment->id }}</h4>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y') }} at {{ date('h:i A', strtotime($appointment->appointment_time)) }}</p>
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full font-medium
                                @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                        <div class="space-y-2 mb-3">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="9" cy="7" r="4"></circle>
                                    <path d="M22 2l-5 5"></path>
                                    <path d="M21 2l-1 1"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Dr. {{ $appointment->doctor->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-400">
                                    <path d="M9 12h6"></path>
                                    <path d="M9 16h6"></path>
                                    <path d="M9 8h6"></path>
                                    <path d="M3 4h18l-2 18H5L3 4Z"></path>
                                </svg>
                                <span class="text-sm text-gray-600">{{ $appointment->appointment_mode == 'telemedicine' ? 'Virtual Consultation' : 'In-Person Visit' }}</span>
                            </div>
                        </div>
                        @if($appointment->symptoms)
                            <div class="border-t pt-3">
                                <p class="text-sm text-gray-600"><strong>Symptoms:</strong> {{ Str::limit($appointment->symptoms, 100) }}</p>
                            </div>
                        @endif
                        <div class="border-t pt-3">
                            <p class="text-sm text-gray-600"><strong>Payment Status:</strong>
                                @if($appointment->payment && $appointment->payment->status === 'succeeded')
                                    <span class="badge badge-success">Paid - ${{ $appointment->payment->amount }}</span>
                                @elseif($appointment->payment && $appointment->payment->status === 'failed')
                                    <span class="badge badge-danger">Payment Failed</span>
                                @else
                                    <span class="badge badge-warning">Payment Pending</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex gap-2 mt-3">
                            @if($appointment->status == 'pending')
                                <form method="POST" action="{{ route('patient.cancel.appointment', $appointment->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition-colors" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        Cancel
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border bg-white shadow-sm p-6 py-8 text-center mt-4">
                        <div class="d-flex flex-column align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar mb-3 text-gray-300">
                                <path d="M8 2v4"></path>
                                <path d="M16 2v4"></path>
                                <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                                <path d="M3 10h18"></path>
                            </svg>
                            <h3 class="h5 font-weight-bold mb-1 text-customTeal">No Upcoming Appointments</h3>
                            <p class="text-muted mb-4">You don't have any scheduled appointments at the moment.</p>
                            <a href="{{ route('patient.appointments.wizard.step1') }}">
                                <button class="btn btn-customTeal btn-lg rounded-pill d-inline-flex align-items-center px-4 py-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus h-4 w-4 mr-2 text-white">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path>
                                        <path d="M3 10h18"></path>
                                        <path d="M16 19h6"></path>
                                        <path d="M19 16v6"></path>
                                    </svg>
                                    Schedule an Appointment
                                </button>
                            </a>
                        </div>
                    </div>
                @endforelse
>>>>>>> e848bd541e60b1a9b72896dfcdd382d35d4d30c7
            </div>
        </div>
    </div>
</div>

<!-- Calendar Content -->
<div id="calendarContent" style="display: none;">
    <div class="mb-8">
        <h1 class="h3 font-weight-bold mb-1" style="color: #000000 !important; background-color: rgba(0,0,0,0); font-family: ui-sans-serif, system-ui, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji'; font-size: 30px;">My Appointments</h1>
        <p class="text-muted" style="font-size: 1.05rem;">View, schedule and manage your healthcare appointments</p>
    </div>
    <div class="mb-8">
        <div class="d-flex align-items-center justify-content-between">
            <button type="button" class="btn btn-outline-secondary" onclick="showDashboard()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
                Back to Appointments
            </button>
            <div class="flex-1 max-w-md mx-4">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.35-4.35"></path>
                    </svg>
                    <input type="text" id="appointmentSearch" placeholder="Search Appointments..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-customTeal focus:border-transparent" onkeyup="filterAppointments()">
                    <a href="{{ route('patient.appointment.dashboard') }}" class="action-btn">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        + New Appointment
                    </a>
                </div>
            </div>
            <div></div> <!-- Spacer for centering -->
        </div>
    </div>
    <div class="calendar-full-page">
        <div class="calendar-header mb-4">
            <div>
                <div class="calendar-nav">
                    <button onclick="previousMonth()">&larr; Previous</button>
                    <button onclick="today()">Today</button>
                    <button onclick="nextMonth()">Next &rarr;</button>
                </div>
            </div>
            <h2 class="calendar-title" id="calendarTitle">November 2025</h2>
            <div class="calendar-view-toggles">
                <button class="view-btn active" onclick="switchView('month')">Month</button>
            </div>
        </div>

        <div class="calendar-grid" id="calendarGrid">
            <!-- Calendar will be generated here -->
        </div>

        <div class="appointments-list" id="appointmentsList">
            <!-- Appointments for selected date will appear here -->
        </div>
    </div>
</div>

<style>
    .bg-card {
        background-color: #ffffff !important;
    }
    .text-card-foreground {
        color: #374151 !important;
    }
    .text-customTeal {
        color: rgb(87, 165, 150) !important;
        font-weight: 700 !important;
    }
    .bg-customTeal {
        background-color: rgb(87, 165, 150) !important;
    }
    .border-customTeal {
        border-color: rgb(87, 165, 150) !important;
    }
    .hover\:border-customTeal:hover {
        border-color: rgb(87, 165, 150) !important;
    }
    .hover\:bg-accent:hover {
        background-color: rgba(40, 167, 69, 0.1) !important;
    }
    .hover\:text-accent-foreground:hover {
        color: #374151 !important;
    }
    .text-muted-foreground {
        color: #6b7280 !important;
    }
    .text-gray-300 {
        color: #d1d5db !important;
    }
    .text-gray-500 {
        color: #6b7280 !important;
    }
    .text-gray-900 {
        color: #111827 !important;
    }
    .group-hover\:text-customTeal:hover .group:hover {
        color: rgb(87, 165, 150)!important;
        font-weight: 600 !important;
    }
    .shadow {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06) !important;
    }
    .rounded-xl {
        border-radius: 0.75rem !important;
    }
    .border {
        border: 1px solid #e5e7eb !important;
    }
    .cursor-pointer {
        cursor: pointer !important;
    }
    .transition-colors {
        transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, color 0.15s ease-in-out !important;
    }

    /* Additional card styling */
    .appointment-card {
        -webkit-text-size-adjust: 100%;
        tab-size: 4;
        font-feature-settings: normal;
        font-variation-settings: normal;
        -webkit-tap-highlight-color: transparent;
        --background: 0 0% 100%;
        --foreground: 222.2 84% 4.9%;
        --card: 0 0% 100%;
        --card-foreground: 222.2 84% 4.9%;
        --popover: 0 0% 100%;
        --popover-foreground: 222.2 84% 4.9%;
        --primary: 221.2 83.2% 53.3%;
        --primary-foreground: 210 40% 98%;
        --secondary: 210 40% 96.1%;
        --secondary-foreground: 222.2 47.4% 11.2%;
        --muted: 210 40% 96.1%;
        --muted-foreground: 215.4 16.3% 46.9%;
        --accent: 210 40% 96.1%;
        --accent-foreground: 222.2 47.4% 11.2%;
        --destructive: 0 84.2% 60.2%;
        --destructive-foreground: 210 40% 98%;
        --border: 214.3 31.8% 91.4%;
        --input: 214.3 31.8% 91.4%;
        --ring: 221.2 83.2% 53.3%;
        --radius: 0.5rem;
        --chart-1: 12 76% 61%;
        --chart-2: 173 58% 39%;
        --chart-3: 197 37% 24%;
        --chart-4: 43 74% 66%;
        --chart-5: 27 87% 67%;
        --form-control-size: 1.125rem;
        --form-control-size-sm: 0.875rem;
        --form-control-size-lg: 1.9rem;
        line-height: inherit;
        --font-inter: "__Inter_f367f3","__Inter_Fallback_f367f3";
        --font-poppins: "__Poppins_6bee3b","__Poppins_Fallback_6bee3b";
        font-family: ui-sans-serif,system-ui,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;
        -webkit-font-smoothing: antialiased;
        --tw-border-spacing-x: 0;
        --tw-border-spacing-y: 0;
        --tw-translate-x: 0;
        --tw-translate-y: 0;
        --tw-rotate: 0;
        --tw-skew-x: 0;
        --tw-skew-y: 0;
        --tw-scale-x: 1;
        --tw-scale-y: 1;
        --tw-pan-x: ;
        --tw-pan-y: ;
        --tw-pinch-zoom: ;
        --tw-scroll-snap-strictness: proximity;
        --tw-gradient-from-position: ;
        --tw-gradient-via-position: ;
        --tw-gradient-to-position: ;
        --tw-ordinal: ;
        --tw-slashed-zero: ;
        --tw-numeric-figure: ;
        --tw-numeric-spacing: ;
        --tw-numeric-fraction: ;
        --tw-ring-inset: ;
        --tw-ring-offset-width: 0px;
        --tw-ring-offset-color: #fff;
        --tw-ring-color: rgba(59,130,246,.5);
        --tw-ring-offset-shadow: 0 0 #0000;
        --tw-ring-shadow: 0 0 #0000;
        --tw-blur: ;
        --tw-brightness: ;
        --tw-contrast: ;
        --tw-grayscale: ;
        --tw-hue-rotate: ;
        --tw-invert: ;
        --tw-saturate: ;
        --tw-sepia: ;
        --tw-drop-shadow: ;
        --tw-backdrop-blur: ;
        --tw-backdrop-brightness: ;
        --tw-backdrop-contrast: ;
        --tw-backdrop-grayscale: ;
        --tw-backdrop-hue-rotate: ;
        --tw-backdrop-invert: ;
        --tw-backdrop-opacity: ;
        --tw-backdrop-saturate: ;
        --tw-backdrop-sepia: ;
        --tw-contain-size: ;
        --tw-contain-layout: ;
        --tw-contain-paint: ;
        --tw-contain-style: ;
        box-sizing: border-box;
        border: 0 solid #e5e7eb;
        border-color: hsl(var(--border));
        cursor: pointer;
        border-radius: .75rem;
        border-width: 1px;
        background-color: hsl(var(--card));
        color: hsl(var(--card-foreground));
        --tw-shadow: 0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px -1px rgba(0,0,0,.1);
        --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color),0 1px 2px -1px var(--tw-shadow-color);
        box-shadow: var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow);
        transition-property: color,background-color,border-color,text-decoration-color,fill,stroke;
        transition-timing-function: cubic-bezier(.4,0,.2,1);
        transition-duration: .15s;
    }

    /* Calendar Full Page Styles */
    .calendar-full-page {
        background-color: #ffffff;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 20px;
    }

    .calendar-nav {
        display: flex;
        gap: 10px;
    }

    .calendar-nav button {
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .calendar-nav button:hover {
        background-color: rgb(87, 165, 150);
        color: white;
        border-color: rgb(87, 165, 150);
    }

    .calendar-title {
        font-size: 24px;
        font-weight: bold;
        color: #111827;
        margin: 0;
    }

    .calendar-view-toggles {
        display: flex;
        gap: 10px;
    }

    .view-btn {
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s;
    }

    .view-btn.active {
        background-color: rgb(87, 165, 150);
        color: white;
        border-color: rgb(87, 165, 150);
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
        margin-bottom: 20px;
    }

    .weekday-header {
        text-align: center;
        font-weight: bold;
        color: rgb(87, 165, 150);
        padding: 10px;
        font-size: 14px;
        text-transform: uppercase;
    }

    .calendar-day {
        aspect-ratio: 0.8;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        background-color: #fff;
        transition: all 0.2s;
        position: relative;
    }

    .calendar-day:hover:not(.empty):not(.other-month) {
        border-color: rgb(87, 165, 150);
        box-shadow: 0 0 0 2px rgba(87, 165, 150, 0.1);
    }

    .calendar-day.empty,
    .calendar-day.other-month {
        background-color: #f9fafb;
        cursor: not-allowed;
        color: #d1d5db;
    }

    .calendar-day.has-appointment {
        background-color: #dcfce7;
        border-color: #86efac;
        color: #166534;
        font-weight: bold;
    }

    .calendar-day.today {
        border: 2px solid rgb(87, 165, 150);
        background-color: rgba(87, 165, 150, 0.05);
    }

    .calendar-day.has-appointment::after {
        content: '';
        position: absolute;
        bottom: 2px;
        width: 4px;
        height: 4px;
        background-color: #16a34a;
        border-radius: 50%;
    }

    .appointments-list {
        background-color: #f9fafb;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #e5e7eb;
    }

    .appointments-list h3 {
        margin-top: 0;
        color: #111827;
        margin-bottom: 15px;
    }

    .appointment-item {
        background-color: #fff;
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 10px;
        border-left: 4px solid rgb(87, 165, 150);
        display: flex;
        justify-content: space-between;
        align-items: start;
    }

<<<<<<< HEAD
    .appointment-item.self-appointment {
        border-left-color: #8b5cf6;
        background-color: #faf5ff;
    }

    .appointment-item.family-member {
        border-left-color: #06b6d4;
        background-color: #f0f9fa;
    }

=======
>>>>>>> e848bd541e60b1a9b72896dfcdd382d35d4d30c7
    .appointment-details {
        flex: 1;
    }

    .appointment-details strong {
        color: #111827;
        display: block;
        margin-bottom: 4px;
    }

    .appointment-details small {
        color: #6b7280;
        display: block;
    }

<<<<<<< HEAD
    .appointment-person-name {
        color: #1f2937;
        font-size: 1.05em;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .appointment-person-type {
        color: #0ea5e9;
        font-size: 0.9em;
        font-weight: 500;
        margin-left: 8px;
        padding: 2px 8px;
        background-color: #ecf0f1;
        border-radius: 4px;
        display: inline-block;
    }

    .appointment-doctor {
        color: #0369a1;
        font-weight: 600;
        display: block;
        margin-top: 8px;
    }

    .appointment-time {
        color: #6b7280;
        font-size: 0.9em;
        display: inline-block;
        margin-right: 12px;
    }

    .appointment-mode {
        color: #6b7280;
        font-size: 0.9em;
        display: inline-block;
    }

=======
>>>>>>> e848bd541e60b1a9b72896dfcdd382d35d4d30c7
    .appointment-status {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        margin-left: 10px;
    }

    .appointment-status.confirmed {
        background-color: #dcfce7;
        color: #166534;
    }

    .appointment-status.pending {
        background-color: #fef3c7;
        color: #92400e;
    }

    .appointment-status.cancelled {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .no-appointments-message {
        text-align: center;
        padding: 40px 20px;
        color: #6b7280;
    }

    .no-appointments-message svg {
        width: 48px;
        height: 48px;
        margin-bottom: 10px;
        color: #d1d5db;
    }
</style>



<script>
    // Parse appointments from PHP data
    const allAppointments = @json($appointments ?? []);
    const appointmentsByDate = {};

    // Build a map of dates to appointments
    allAppointments.forEach(apt => {
        const date = apt.appointment_date; // Format: YYYY-MM-DD
        if (!appointmentsByDate[date]) {
            appointmentsByDate[date] = [];
        }
        appointmentsByDate[date].push(apt);
    });

    let currentDate = new Date();

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Update title
        const monthName = new Date(year, month).toLocaleString('default', { month: 'long', year: 'numeric' });
        document.getElementById('calendarTitle').textContent = monthName;

        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const daysInPrevMonth = new Date(year, month, 0).getDate();

        const calendarGrid = document.getElementById('calendarGrid');
        calendarGrid.innerHTML = '';

        // Add weekday headers
        const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        weekdays.forEach(day => {
            const dayHeader = document.createElement('div');
            dayHeader.className = 'weekday-header';
            dayHeader.textContent = day;
            calendarGrid.appendChild(dayHeader);
        });

        // Add days from previous month
        for (let i = firstDay - 1; i >= 0; i--) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month empty';
            day.textContent = daysInPrevMonth - i;
            calendarGrid.appendChild(day);
        }

        // Add days of current month
        const today = new Date();
        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day';

            const dateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === i;
            const hasAppointment = appointmentsByDate[dateStr] && appointmentsByDate[dateStr].length > 0;

            if (isToday) {
                day.classList.add('today');
            }

            if (hasAppointment) {
                day.classList.add('has-appointment');
            }

            day.textContent = i;
            day.onclick = () => showAppointmentsForDate(dateStr);
            calendarGrid.appendChild(day);
        }

        // Add days from next month
        const totalCells = calendarGrid.children.length - 7; // Subtract weekday headers
        const remainingCells = 42 - totalCells; // 6 rows * 7 days
        for (let i = 1; i <= remainingCells; i++) {
            const day = document.createElement('div');
            day.className = 'calendar-day other-month empty';
            day.textContent = i;
            calendarGrid.appendChild(day);
        }

        // Show appointments for today if any, otherwise show today
        const todayStr = `${today.getFullYear()}-${String(today.getMonth() + 1).padStart(2, '0')}-${String(today.getDate()).padStart(2, '0')}`;
        showAppointmentsForDate(todayStr);
    }

    function showAppointmentsForDate(dateStr) {
        const appointmentsList = document.getElementById('appointmentsList');
        const appointments = appointmentsByDate[dateStr] || [];

        if (appointments.length === 0) {
            appointmentsList.innerHTML = `
                <div class="no-appointments-message">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M8 2v4"></path>
                        <path d="M16 2v4"></path>
                        <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                        <path d="M3 10h18"></path>
                    </svg>
                    <p>No appointments on this date</p>
                </div>
            `;
            return;
        }

        const dateObj = new Date(dateStr);
        const formattedDate = dateObj.toLocaleString('default', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });

        let html = `<h3>Appointments for ${formattedDate}</h3>`;

        appointments.forEach(apt => {
            const time = apt.appointment_time ? new Date(`2000-01-01 ${apt.appointment_time}`).toLocaleString('default', { hour: '2-digit', minute: '2-digit', hour12: true }) : 'N/A';
            const statusClass = apt.status.toLowerCase();
<<<<<<< HEAD
            let displayName = 'N/A';
            let appointmentFor = '';
            let appointmentTypeClass = '';

            // Determine if this is a family member or self appointment
            if (apt.is_family_member && apt.member_name) {
                // Family member appointment
                displayName = apt.member_name;
                appointmentFor = apt.relationship || 'Family Member';
                appointmentTypeClass = 'family-member';
            } else {
                // Self appointment
                displayName = apt.patient_first_name ? `${apt.patient_first_name} ${apt.patient_last_name}` : 'N/A';
                appointmentFor = 'Self';
                appointmentTypeClass = 'self-appointment';
            }

            html += `
                <div class="appointment-item ${appointmentTypeClass}">
                    <div class="appointment-details">
                        <div style="margin-bottom: 8px;">
                            <span class="appointment-person-name">${displayName}</span>
                            <span class="appointment-person-type">${appointmentFor}</span>
                        </div>
                        <span class="appointment-doctor">Dr. ${apt.doctor?.name || 'N/A'}</span>
                        <span class="appointment-time">${time}</span>
                        <span class="appointment-mode">${apt.appointment_mode === 'telemedicine' ? '👁️ Virtual Consultation' : '🏥 In-Person Visit'}</span>
=======
            let patientName = apt.patient_first_name ? `${apt.patient_first_name} ${apt.patient_last_name}` : 'N/A';
            let relationship = apt.relationship ? ` (${apt.relationship})` : '';
            html += `
                <div class="appointment-item">
                    <div class="appointment-details">
                        <strong>Dr. ${apt.doctor?.name || 'N/A'}</strong><br>
                        <strong>Patient:</strong> ${patientName}${relationship}<br>
                        <small>${time}</small>
                        <small>${apt.appointment_mode === 'telemedicine' ? '👁️ Virtual Consultation' : '🏥 In-Person Visit'}</small>
>>>>>>> e848bd541e60b1a9b72896dfcdd382d35d4d30c7
                    </div>
                    <span class="appointment-status ${statusClass}">${apt.status.charAt(0).toUpperCase() + apt.status.slice(1)}</span>
                </div>
            `;
        });

        appointmentsList.innerHTML = html;
    }

    function nextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    }

    function previousMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    }

    function today() {
        currentDate = new Date();
        renderCalendar();
    }

    function switchView(view) {
        // Currently only month view is implemented
        console.log('Switched to ' + view + ' view');
    }



    function showCalendar() {
        document.getElementById('dashboardContent').style.display = 'none';
        document.getElementById('calendarContent').style.display = 'block';
        renderCalendar();
    }

    function showDashboard() {
        document.getElementById('calendarContent').style.display = 'none';
        document.getElementById('dashboardContent').style.display = 'block';
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Calendar is hidden by default
    });
</script>
@endsection
