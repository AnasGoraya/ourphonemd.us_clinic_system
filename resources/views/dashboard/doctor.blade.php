@extends('layouts.doctor')

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
            <p class="text-muted" style="font-size: 1.05rem;">Manage your patient appointments and healthcare services</p>
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
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #3db2a5;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-plus text-customTeal mr-2">
                                        <path d="M8 2v4"></path>
                                        <path d="M16 2v4"></path>
                                        <path d="M21 13V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8"></path>
                                        <path d="M3 10h18"></path>
                                        <path d="M16 19h6"></path>
                                        <path d="M19 16v6"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Upcoming Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Review and manage all scheduled patient appointments</p>
                                <a href="{{ route('doctor.appointments.upcoming') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center;">
                                    View Appointments ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #eab308;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-clock text-customTeal mr-2">
                                        <path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"></path>
                                        <path d="M16 2v4"></path>
                                        <path d="M8 2v4"></path>
                                        <path d="M3 10h5"></path>
                                        <path d="M17.5 17.5 16 16.3V14"></path>
                                        <circle cx="16" cy="16" r="6"></circle>
                                    </svg>
                                    <span class="text-sm font-medium">Unconfirmed Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Review pending appointments that need confirmation</p>
                                <a href="{{ route('doctor.appointments.unconfirmed') }}" class="action-btn secondary" style="display: flex; align-items: center; justify-content: center;">
                                    Review Pending ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #10b981;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle text-customTeal mr-2">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22,4 12,14.01 9,11.01"></polyline>
                                    </svg>
                                    <span class="text-sm font-medium">Finished Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">View completed appointments and patient records</p>
                                <a href="{{ route('doctor.appointments.finished') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center; background: #10b981 !important;">
                                    View Completed ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #8b5cf6;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw text-customTeal mr-2">
                                        <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                                        <path d="M21 3v5h-5"></path>
                                        <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                                        <path d="M8 16H3v5"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Follow-up Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Manage follow-up visits and patient care plans</p>
                                <a href="{{ route('doctor.appointments.follow-up') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center; background: #8b5cf6 !important;">
                                    View Follow-ups ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #f59e0b;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-plus text-customTeal mr-2">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <line x1="19" x2="19" y1="8" y2="14"></line>
                                        <line x1="22" x2="16" y1="11" y2="11"></line>
                                    </svg>
                                    <span class="text-sm font-medium">Walk-in Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Handle same-day patient visits and urgent care</p>
                                <a href="{{ route('doctor.appointments.walk-in') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center; background: #f59e0b !important;">
                                    View Walk-ins ->
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="rounded-xl border bg-card text-card-foreground shadow p-4 h-100 d-flex flex-column justify-content-between" style="border-top: 4px solid #ef4444;">
                                <div class="d-flex align-items-center mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-circle text-customTeal mr-2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m15 9-6 6"></path>
                                        <path d="m9 9 6 6"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Cancelled Appointments</span>
                                </div>
                                <p class="text-xs text-muted-foreground ml-4">Review cancelled appointments and reasons</p>
                                <a href="{{ route('doctor.appointments.cancelled') }}" class="action-btn" style="display: flex; align-items: center; justify-content: center; background: #ef4444 !important;">
                                    View Cancelled ->
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 style="font-size:2rem;font-weight:600;margin-bottom:0;">Today's Appointments</h2>
                    <a href="{{ route('doctor.appointments.upcoming') }}" style="font-weight:500;font-size:1rem;text-decoration:none;color:#222;">
                        View All <span style="font-size:1.2em;vertical-align:middle;">&rarr;</span>
                    </a>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(400px,1fr));gap:32px;">
                    @forelse($todayAppointments as $appointment)
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
                                    <span style="background:#ff7f2a;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">Confirmed</span>
                                @elseif($appointment->status == 'pending')
                                    <span style="background:#eab308;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">Pending</span>
                                @else
                                    <span style="background:#eab308;color:#fff;padding:6px 18px;border-radius:16px;font-size:1em;font-weight:600;">{{ ucfirst($appointment->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:16px;margin-top:8px;">
                            <span style="font-size:1.1em;"><i class="fa fa-map-marker" style="margin-right:4px;"></i> Main Clinic</span>
                            <span style="font-size:1.1em;"><i class="fa fa-user" style="margin-right:4px;"></i>
                                @if($appointment->patient)
                                    {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                        <div style="margin-top:24px;display:flex;gap:12px;">
                            @if(!empty($appointment->token))
                                <a href="{{ url('/doctor/appointments/' . $appointment->token) }}" style="text-decoration:none;">
                                    <button style="background:#fff;border:1.5px solid #e3e6f0;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#222;cursor:pointer;transition:background 0.2s;">View Details</button>
                                </a>
                            @endif
                            @if($appointment->status == 'pending')
                                <form action="{{ route('doctor.confirm.appointment', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" style="background:#3db2a5;border:none;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#fff;cursor:pointer;display:flex;align-items:center;gap:8px;">
                                        <i class="fa fa-check"></i> Confirm
                                    </button>
                                </form>
                            @else
                            <button style="background:#f3f4f6;border:none;border-radius:8px;padding:10px 24px;font-size:1em;font-weight:500;color:#bbb;cursor:not-allowed;">Confirmed</button>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div style="background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:32px;text-align:center;">
                        <div style="font-size:1.2em;color:#3db2a5;font-weight:600;margin-bottom:8px;">No Appointments Today</div>
                        <div style="color:#7a8a9c;margin-bottom:16px;">You don't have any appointments scheduled for today.</div>
                        <a href="{{ route('doctor.appointments.upcoming') }}">
                            <button style="background:#3db2a5;color:#fff;border:none;border-radius:8px;padding:12px 32px;font-size:1.1em;font-weight:500;">View All Appointments</button>
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
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
</style>
@endsection
