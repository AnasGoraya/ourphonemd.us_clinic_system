<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReceptionistController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 3) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        $pendingAppointments = Appointment::where('status', 'pending')
            ->where('sent_to_doctor', false)
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        $sentAppointments = Appointment::where('status', 'pending')
            ->where('sent_to_doctor', true)
            ->with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'asc')
            ->get();

        return view('dashboard.receptionist', compact('pendingAppointments', 'sentAppointments'));
    }

    public function sendToDoctor($appointmentId)
    {
        $user = Auth::user();
        if (!$user || $user->role_id != 3) {
            return redirect('/')->withErrors(['error' => 'Unauthorized access.']);
        }

        try {
            $appointment = Appointment::findOrFail($appointmentId);

            if ($appointment->status !== 'pending') {
                return back()->withErrors(['error' => 'Only pending appointments can be sent to doctor.']);
            }

            if ($appointment->sent_to_doctor) {
                return back()->withErrors(['error' => 'Appointment has already been sent to doctor.']);
            }

            $appointment->update(['sent_to_doctor' => true]);

            Log::info('Appointment sent to doctor by receptionist', [
                'appointment_id' => $appointment->id,
                'receptionist_id' => $user->id,
                'doctor_id' => $appointment->doctor_id
            ]);

            return back()->with('success', 'Appointment successfully sent to doctor.');
        } catch (\Exception $e) {
            Log::error('Error sending appointment to doctor: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to send appointment to doctor.']);
        }
    }
}
