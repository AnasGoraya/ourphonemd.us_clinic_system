<?php


namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{


public function dashboard()
{
    $user = Auth::user();

    if (!$user || $user->role_id != 5) {
        Log::warning('Unauthorized access to doctor dashboard', [
            'user_id' => $user ? $user->id : null,
            'role_id' => $user ? $user->role_id : null,
            'user_name' => $user ? $user->name : 'Not logged in'
        ]);
        return redirect('/login')->withErrors(['error' => 'Unauthorized access. Please login as doctor.']);
    }

    Log::info('Doctor dashboard accessed successfully', [
        'doctor_id' => $user->id,
        'doctor_name' => $user->name
    ]);

    $today = Carbon::today();

    try {
        // Get all appointments for this doctor
        $appointments = Appointment::where('doctor_id', $user->id)
            ->with('patient')
            ->get();

        // Calculate counts
        $upcomingCount = $appointments->where('appointment_date', '>', $today)
            ->where('status', 'confirmed')
            ->count();

        $finishedCount = $appointments->where('status', 'completed')->count();
        $unconfirmedCount = $appointments->where('status', 'pending')->count();
        $followUpCount = $appointments->where('priority', 'follow-up')->count();
        $walkInCount = $appointments->where('priority', 'urgent')->count(); // Changed from 'type' to 'priority'
        $cancelledCount = $appointments->where('status', 'cancelled')->count();

        $unfinishedCount = $appointments->where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->count();

        // Today's appointments
        $todayAppointments = $appointments->where('appointment_date', $today->format('Y-m-d'));

        Log::info('Doctor dashboard data calculated', [
            'upcoming_count' => $upcomingCount,
            'finished_count' => $finishedCount,
            'unconfirmed_count' => $unconfirmedCount,
            'today_appointments_count' => $todayAppointments->count()
        ]);

        return view('dashboard.doctor', compact(
            'user',
            'upcomingCount',
            'finishedCount',
            'unconfirmedCount',
            'followUpCount',
            'walkInCount',
            'cancelledCount',
            'unfinishedCount',
            'todayAppointments'
        ));

    } catch (\Exception $e) {
        Log::error('Error in doctor dashboard: ' . $e->getMessage());
        return redirect('/login')->withErrors(['error' => 'Error loading dashboard. Please try again.']);
    }
}

//     public function dashboard()
//     {
//         $doctor = Auth::user();
//         $today = Carbon::today();

//         $appointments = Appointment::where('doctor_id', $doctor->id)
//             ->with('patient')
//             ->get();

//         $upcomingCount = $appointments->where('appointment_date', '>', $today)
//             ->where('status', 'confirmed')
//             ->count();

//         $finishedCount = $appointments->where('status', 'completed')->count();

//         $unconfirmedCount = $appointments->where('status', 'pending')->count();

//         $followUpCount = $appointments->where('priority', 'follow-up')->count();

//         $walkInCount = $appointments->where('type', 'walk-in')->count();

//         $cancelledCount = $appointments->where('status', 'cancelled')->count();

//         $unfinishedCount = $appointments->where('appointment_date', '<', $today)
//             ->where('status', 'confirmed')
//             ->count();

//         $todayAppointments = $appointments->where('appointment_date', $today->format('Y-m-d'));

//         return view('dashboard.doctor', compact(
//             'doctor',
//             'upcomingCount',
//             'finishedCount',
//             'unconfirmedCount',
//             'followUpCount',
//             'walkInCount',
//             'cancelledCount',
//             'unfinishedCount',
//             'todayAppointments'
//         ));
//     }



// namespace App\Http\Controllers;

// use App\Models\Appointment;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;

// class DoctorController extends Controller
// {
//     public function dashboard()
//     {
//         $user = Auth::user();

//         // Check if user is authenticated and is a doctor
//         if (!$user || $user->role_id != 5) {
//             Log::warning('Unauthorized access to doctor dashboard', [
//                 'user_id' => $user ? $user->id : null,
//                 'role_id' => $user ? $user->role_id : null,
//                 'ip' => request()->ip()
//             ]);
//             return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
//         }

//         // Fetch appointments for this doctor that have been sent to doctor
//         $appointments = Appointment::where('doctor_id', $user->id)
//             ->where('sent_to_doctor', true)
//             ->with('patient')
//             ->orderBy('appointment_date', 'asc')
//             ->get();

//         Log::info('Doctor dashboard accessed', [
//             'doctor_id' => $user->id,
//             'doctor_name' => $user->name,
//             'appointments_count' => $appointments->count(),
//             'appointments' => $appointments->map(function ($app) {
//                 return [
//                     'id' => $app->id,
//                     'patient_id' => $app->patient_id,
//                     'date' => $app->appointment_date,
//                     'time' => $app->appointment_time,
//                     'status' => $app->status,
//                     'sent_to_doctor' => $app->sent_to_doctor
//                 ];
//             })->toArray()
//         ]);

//         return view('dashboard.doctor', compact('appointments'));
//     }

    public function showAppointmentDetail($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->where('sent_to_doctor', true)
                ->with('patient')
                ->firstOrFail();

            Log::info('Doctor viewing appointment detail', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            return view('doctor.appointment-detail', compact('appointment'));
        } catch (\Exception $e) {
            Log::error('Appointment detail error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return redirect('/doctor/dashboard')->withErrors(['error' => 'Appointment not found.']);
        }
    }

    public function confirmAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->where('sent_to_doctor', true)
                ->firstOrFail();

            if ($appointment->status !== 'pending') {
                Log::warning('Attempt to confirm non-pending appointment', [
                    'doctor_id' => $user->id,
                    'appointment_id' => $id,
                    'status' => $appointment->status
                ]);
                return back()->withErrors(['error' => 'Only pending appointments can be confirmed.']);
            }

            $appointment->update(['status' => 'confirmed']);

            Log::info('Appointment confirmed', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            return back()->with('success', 'Appointment confirmed successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment confirmation error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to confirm appointment.']);
        }
    }

    public function cancelAppointment($id)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('doctor_id', $user->id)
                ->where('sent_to_doctor', true)
                ->firstOrFail();

            if ($appointment->status !== 'pending') {
                Log::warning('Attempt to cancel non-pending appointment', [
                    'doctor_id' => $user->id,
                    'appointment_id' => $id,
                    'status' => $appointment->status
                ]);
                return back()->withErrors(['error' => 'Only pending appointments can be cancelled.']);
            }

            $appointment->update(['status' => 'cancelled']);

            Log::info('Appointment cancelled', [
                'doctor_id' => $user->id,
                'appointment_id' => $id
            ]);

            return back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment cancellation error', [
                'doctor_id' => $user->id,
                'appointment_id' => $id,
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Failed to cancel appointment.']);
        }
    }

    public function upcomingAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $today = Carbon::today();
        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '>', $today)
            ->where('status', 'confirmed')
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.upcoming', compact('appointments'));
    }

    public function finishedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'completed')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.finished', compact('appointments'));
    }

    public function unconfirmedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'pending')
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.unconfirmed', compact('appointments'));
    }

    public function followUpAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('priority', 'follow-up')
            ->with('patient')
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('doctor.appointments.follow-up', compact('appointments'));
    }
public function walkInAppointments()
{
    $user = Auth::user();
    if (!$user || $user->role_id != 5) {
        return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
    }

    // OPTION 1: Use priority field (urgent = walk-in)
    $appointments = Appointment::where('doctor_id', $user->id)
        ->where('priority', 'urgent')
        ->with('patient')
        ->orderBy('appointment_date', 'desc')
        ->get();

    // OPTION 2: If you want to create walk-in appointments differently
    // $appointments = Appointment::where('doctor_id', $user->id)
    //     ->where('created_at', '>=', now()->subDay()) // Today's appointments
    //     ->where('status', 'pending') // Not confirmed yet
    //     ->with('patient')
    //     ->orderBy('created_at', 'desc')
    //     ->get();

    return view('doctor.appointments.walk-in', compact('appointments'));
}

    public function cancelledAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'cancelled')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.cancelled', compact('appointments'));
    }

    public function unfinishedAppointments()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 5) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $today = Carbon::today();
        $appointments = Appointment::where('doctor_id', $user->id)
            ->where('appointment_date', '<', $today)
            ->where('status', 'confirmed')
            ->with('patient')
            ->orderBy('appointment_date', 'desc')
            ->get();

        return view('doctor.appointments.unfinished', compact('appointments'));
    }
}
