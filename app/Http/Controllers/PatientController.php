<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\User;
use App\Models\PasswordResetToken;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function homepage()
    {
        try {
            Log::info('Homepage accessed');
            return view('patient.homepage');
        } catch (\Exception $e) {
            Log::error('Homepage error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function dashboard()
    {
        try {
            Log::info('Dashboard accessed');
            $patient = Auth::guard('patient')->user();

            if (!$patient) {
                return redirect()->route('patient.signin');
            }

            // Get family members
            $familyMembers = FamilyMember::where('patient_id', $patient->id)->get();

            // Get appointment counts
            $upcomingAppointmentsCount = Appointment::where('patient_id', $patient->id)
                ->where('appointment_date', '>=', now()->toDateString())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count();

            $completedVisitsCount = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['completed'])
                ->count();

            $walkinAppointmentsCount = Appointment::where('patient_id', $patient->id)
                ->where('priority', 'urgent')
                ->count();

            // Get appointment data for calendars using the new method
            $pastAppointments = Appointment::with(['doctor', 'familyMember'])
                ->where('patient_id', $patient->id)
                ->where('appointment_date', '<', now()->toDateString())
                ->orderBy('appointment_date', 'desc')
                ->get()
                ->map(function($apt) {
                    $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';
                    $appointmentFor = $apt->appointment_for;

                    if ($appointmentFor) {
                        $apt->patient_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                        $apt->patient_first_name = $appointmentFor['first_name'];
                        $apt->patient_last_name = $appointmentFor['last_name'];
                        $apt->relationship = $appointmentFor['relationship'];
                        $apt->member_name = $appointmentFor['type'] === 'family' ?
                            $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'] : null;
                    }

                    return $apt->toArray();
                });

            $upcomingAppointments = Appointment::with(['doctor', 'familyMember'])
                ->where('patient_id', $patient->id)
                ->where('appointment_date', '>=', now()->toDateString())
                ->whereIn('status', ['pending', 'confirmed'])
                ->orderBy('appointment_date', 'asc')
                ->get()
                ->map(function($apt) {
                    $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';
                    $appointmentFor = $apt->appointment_for;

                    if ($appointmentFor) {
                        $apt->patient_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                        $apt->patient_first_name = $appointmentFor['first_name'];
                        $apt->patient_last_name = $appointmentFor['last_name'];
                        $apt->relationship = $appointmentFor['relationship'];
                        $apt->member_name = $appointmentFor['type'] === 'family' ?
                            $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'] : null;
                    }

                    return $apt->toArray();
                });

            $completedVisits = Appointment::with(['doctor', 'familyMember'])
                ->where('patient_id', $patient->id)
                ->whereIn('status', ['completed'])
                ->orderBy('appointment_date', 'desc')
                ->get()
                ->map(function($apt) {
                    $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';
                    $appointmentFor = $apt->appointment_for;

                    if ($appointmentFor) {
                        $apt->patient_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                        $apt->patient_first_name = $appointmentFor['first_name'];
                        $apt->patient_last_name = $appointmentFor['last_name'];
                        $apt->relationship = $appointmentFor['relationship'];
                        $apt->member_name = $appointmentFor['type'] === 'family' ?
                            $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'] : null;
                    }

                    return $apt->toArray();
                });

            $walkinAppointments = Appointment::with(['doctor', 'familyMember'])
                ->where('patient_id', $patient->id)
                ->where('priority', 'urgent')
                ->orderBy('appointment_date', 'desc')
                ->get()
                ->map(function($apt) {
                    $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';
                    $appointmentFor = $apt->appointment_for;

                    if ($appointmentFor) {
                        $apt->patient_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                        $apt->patient_first_name = $appointmentFor['first_name'];
                        $apt->patient_last_name = $appointmentFor['last_name'];
                        $apt->relationship = $appointmentFor['relationship'];
                        $apt->member_name = $appointmentFor['type'] === 'family' ?
                            $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'] : null;
                    }

                    return $apt->toArray();
                });

            // For now, set notes to 0 (can be implemented later)
            $familyMembersCount = $familyMembers->count();
            $notesCount = 0;
            $notes = [];

            return view('patient.dashboard', compact(
                'upcomingAppointmentsCount',
                'familyMembersCount',
                'completedVisitsCount',
                'walkinAppointmentsCount',
                'notesCount',
                'pastAppointments',
                'upcomingAppointments',
                'completedVisits',
                'walkinAppointments',
                'notes',
                'patient',
                'familyMembers'
            ));
        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            return response()->view('errors.500', [], 500);
        }
    }

    public function signUp(Request $request)
    {
        Log::info('=== PATIENT SIGNUP STARTED ===');
        Log::info('Request data:', $request->all());

        $messages = [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'Special characters and numbers are not allowed.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Special Characters and numbers are not allowed.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'cnic.required' => 'CNIC number is required.',
            'cnic.unique' => 'This CNIC is already registered.',
            'contact_number.required' => 'Contact number is required.',
            'emergency_contact.required' => 'Emergency contact is required.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'zip_code.required' => 'ZIP code is required.',
            'blood_group.required' => 'Please select your blood group.',
            'blood_group.in' => 'Please select a valid blood group.',
        ];

        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'cnic' => 'required|string|max:15|unique:patients',
            'contact_number' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'medical_history' => 'nullable|string|max:1000',
        ], $messages);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Log::info('Creating patient record in database...');

            $dateOfBirth = new \DateTime($request->date_of_birth);
            $today = new \DateTime();
            $age = $today->diff($dateOfBirth)->y;

            $verificationToken = \Illuminate\Support\Str::random(64);

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $age,
                'cnic' => $request->cnic,
                'contact_number' => $request->contact_number,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'medical_history' => $request->medical_history,
                'verification_token' => $verificationToken,
                'email_verified_at' => null,
                'status' => 'active',
            ]);

            Log::info('Patient created successfully! ID: ' . $patient->id);

            try {
                \Illuminate\Support\Facades\Mail::send('emails.patient_verify', ['token' => $verificationToken, 'patient' => $patient], function ($message) use ($patient) {
                    $message->to($patient->email);
                    $message->subject('Verify Your Email Address - OurPhoneMD');
                });
                Log::info('Verification email sent to: ' . $patient->email);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email: ' . $e->getMessage());
            }

            return redirect()->route('patient.signin')->with('success', 'Accounnt created successfully! Please check your email to verify your account.');
        } catch (\Exception $e) {
            Log::error('Patient sign up ERROR: ' . $e->getMessage());
            Log::error('Full error trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to create account. Please try again.'])->withInput();
        }
    }

    public function showSignIn()
    {
        return view('patient.signin');
    }

    public function signIn(Request $request)
    {
        Log::info('Patient SignIn Attempt:', $request->only('email'));

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::guard('patient')->attempt($request->only('email', 'password'), $remember)) {
            $patient = Auth::guard('patient')->user();

            if (!$patient->email_verified_at) {
                Auth::guard('patient')->logout();
                Log::warning('Patient login blocked - email not verified: ' . $patient->email);
                return back()->withErrors(['error' => 'Please verify your email address before logging in.'])->withInput();
            }

            Log::info('Patient login successful: ' . $patient->email);
            Log::info('Redirecting to patient dashboard...');
            return redirect()->route('patient.dashboard');

            return redirect()->route('patient.dashboard')->with('success', 'Logged in successfully!');
        }

        Log::warning('Patient login failed for email: ' . $request->email);
        return back()->withErrors(['error' => 'Invalid credentials.'])->withInput();
    }


    public function logout()
    {
        Auth::guard('patient')->logout();
        return redirect()->route('patient.homepage');
    }

    public function appointments()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        $appointments = Appointment::where('patient_id', $patient->id)->with('doctor')->get();
        $doctors = User::where('role_id', 5)->where('status', 'active')->get();
        return view('patient.appointments', compact('appointments', 'doctors'));
    }

    public function showSignUp()
    {
        try {
            Log::info('ShowSignUp method called - showing signup form directly');
            return view('patient.signup');
        } catch (\Exception $e) {
            Log::error('ShowSignUp error: ' . $e->getMessage());
            return "Error loading signup page: " . $e->getMessage();
        }
    }

    // public function showSignUpForm()
    // {
    //     try {
    //         Log::info('ShowSignUpForm method called');

    //         if (!session('terms_accepted')) {
    //             Log::warning('Attempted to access signup form without accepting terms');
    //             return redirect()->route('signup.terms')->with('error', 'Please accept the terms and policies first.');
    //         }

    //         return view('patient.signup');
    //     } catch (\Exception $e) {
    //         Log::error('ShowSignUpForm error: ' . $e->getMessage());
    //         return "Error loading signup form: " . $e->getMessage();
    //     }
    // }

public function showSignupForm()
{
    try {
        Log::info('ShowSignUpForm method called');

        // Check if user has completed all verification steps
        if (!session('terms_accepted')) {
            Log::warning('Attempted to access signup form without accepting terms');
            return redirect()->route('signup.terms')->with('error', 'Please accept the terms and policies first.');
        }

        if (!session('prerequisites_viewed')) {
            Log::warning('Attempted to access signup form without viewing prerequisites');
            return redirect()->route('signup.prerequisites')->with('error', 'Please review prerequisites first.');
        }

        if (!session('age_verified')) {
            Log::warning('Attempted to access signup form without age verification');
            return redirect()->route('signup.age-verification')->with('error', 'Please complete age verification first.');
        }

        Log::info('All verifications passed, showing signup form');
        return view('patient.signup');
    } catch (\Exception $e) {
        Log::error('ShowSignUpForm error: ' . $e->getMessage());
        return redirect()->route('signup.terms')->with('error', 'Error loading signup form. Please start over.');
    }
}

    public function finalSignUp(Request $request)
    {
        Log::info('=== PATIENT FINAL SIGNUP STARTED ===');
        Log::info('Request data:', $request->all());

        $messages = [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'Special characters and numbers are not allowed.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Special Characters and numbers are not allowed.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'cnic.required' => 'CNIC number is required.',
            'cnic.unique' => 'This CNIC is already registered.',
            'contact_number.required' => 'Contact number is required.',
            'emergency_contact.required' => 'Emergency contact is required.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'zip_code.required' => 'ZIP code is required.',
            'blood_group.required' => 'Please select your blood group.',
            'blood_group.in' => 'Please select a valid blood group.',
        ];

        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|string|email|max:255|unique:patients',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'nullable|in:male,female,other',
            'date_of_birth' => 'required|date|before:today',
            'cnic' => 'required|string|max:15|unique:patients',
            'contact_number' => 'required|string|max:20',
            'emergency_contact' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'medical_history' => 'nullable|string|max:1000',
        ], $messages);

        if ($validator->fails()) {
            Log::error('Validation failed:', $validator->errors()->toArray());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Log::info('Creating patient record in database...');

            $dateOfBirth = new \DateTime($request->date_of_birth);
            $today = new \DateTime();
            $age = $today->diff($dateOfBirth)->y;

            $verificationToken = \Illuminate\Support\Str::random(64);

            $patient = Patient::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'age' => $age,
                'cnic' => $request->cnic,
                'contact_number' => $request->contact_number,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'blood_group' => $request->blood_group,
                'marital_status' => $request->marital_status,
                'medical_history' => $request->medical_history,
                'verification_token' => $verificationToken,
                'email_verified_at' => null,
                'status' => 'active',
            ]);

            Log::info('Patient created successfully! ID: ' . $patient->id);

            // Clear session data
            session()->forget(['terms_accepted']);

            try {
                \Illuminate\Support\Facades\Mail::send('emails.patient_verify', ['token' => $verificationToken, 'patient' => $patient], function ($message) use ($patient) {
                    $message->to($patient->email);
                    $message->subject('Verify Your Email Address - OurPhoneMD');
                });
                Log::info('Verification email sent to: ' . $patient->email);
            } catch (\Exception $e) {
                Log::error('Failed to send verification email: ' . $e->getMessage());
            }

            return redirect()->route('patient.signin')->with('success', 'Account created successfully! Please check your email to verify your account.');
        } catch (\Exception $e) {
            Log::error('Patient sign up ERROR: ' . $e->getMessage());
            Log::error('Full error trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to create account. Please try again.'])->withInput();
        }
    }

    // public function appointmentDashboard()
    // {
    //     $patient = Auth::guard('patient')->user();
    //     if (!$patient) {
    //         return redirect()->route('patient.signin');
    //     }

    //     $doctors = User::where('role_id', 5)->where('status', 'active')->get();

    //     // Get family members for the patient
    //     $familyMembers = FamilyMember::where('patient_id', $patient->id)->get();

    //     $appointments = Appointment::with(['doctor', 'payment'])
    //         ->where('patient_id', $patient->id)
    //         ->orderBy('appointment_date', 'desc')
    //         ->orderBy('appointment_time', 'desc')
    //         ->get();

    //     // Add patient and family member info to appointments for calendar display
    //     $appointments = $appointments->map(function($apt) use ($patient) {
    //         $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';
    //         if ($apt->family_member_id) {
    //             $member = FamilyMember::find($apt->family_member_id);
    //             if ($member) {
    //                 $apt->patient_name = $member->first_name . ' ' . $member->last_name;
    //                 $apt->patient_first_name = $member->first_name;
    //                 $apt->patient_last_name = $member->last_name;
    //                 $apt->member_name = $member->first_name . ' ' . $member->last_name;
    //                 $apt->relationship = $member->relationship;
    //             } else {
    //                 $apt->patient_name = 'Family Member';
    //                 $apt->patient_first_name = 'Family';
    //                 $apt->patient_last_name = 'Member';
    //                 $apt->member_name = 'Family Member';
    //                 $apt->relationship = '';
    //             }
    //         } elseif ($apt->wizard_step2_data) {
    //             $step2Data = json_decode($apt->wizard_step2_data, true);
    //             if ($step2Data && isset($step2Data['patient_selection']) && $step2Data['patient_selection'] !== 'self') {
    //                 if (str_starts_with($step2Data['patient_selection'], 'family_')) {
    //                     $familyMemberId = str_replace('family_', '', $step2Data['patient_selection']);
    //                     $member = FamilyMember::find($familyMemberId);
    //                     if ($member) {
    //                         $apt->patient_name = $member->first_name . ' ' . $member->last_name;
    //                         $apt->patient_first_name = $member->first_name;
    //                         $apt->patient_last_name = $member->last_name;
    //                         $apt->member_name = $member->first_name . ' ' . $member->last_name;
    //                         $apt->relationship = $member->relationship;
    //                     } else {
    //                         $apt->patient_name = 'Family Member';
    //                         $apt->patient_first_name = 'Family';
    //                         $apt->patient_last_name = 'Member';
    //                         $apt->member_name = 'Family Member';
    //                         $apt->relationship = '';
    //                     }
    //                 } else {
    //                     $apt->patient_name = $patient->first_name . ' ' . $patient->last_name;
    //                     $apt->patient_first_name = $patient->first_name;
    //                     $apt->patient_last_name = $patient->last_name;
    //                     $apt->member_name = null;
    //                     $apt->relationship = null;
    //                 }
    //             } else {
    //                 $apt->patient_name = $patient->first_name . ' ' . $patient->last_name;
    //                 $apt->patient_first_name = $patient->first_name;
    //                 $apt->patient_last_name = $patient->last_name;
    //                 $apt->member_name = null;
    //                 $apt->relationship = null;
    //             }
    //         } else {
    //             $apt->patient_name = $patient->first_name . ' ' . $patient->last_name;
    //             $apt->patient_first_name = $patient->first_name;
    //             $apt->patient_last_name = $patient->last_name;
    //             $apt->member_name = null;
    //             $apt->relationship = null;
    //         }
    //         return $apt;
    //     });

    //     return view('patient.appointment-dashboard', compact('doctors', 'appointments'));
    // }
public function appointmentDashboard()
{
    $patient = Auth::guard('patient')->user();
    if (!$patient) {
        return redirect()->route('patient.signin');
    }

    $doctors = User::where('role_id', 5)->where('status', 'active')->get();

    // Get family members for the patient
    $familyMembers = FamilyMember::where('patient_id', $patient->id)->get();

    $appointments = Appointment::with(['doctor', 'familyMember', 'patient', 'payment'])
        ->where('patient_id', $patient->id)
        ->where('appointment_date', '>=', now()->toDateString())
        ->whereIn('status', ['pending', 'confirmed'])
        ->orderBy('appointment_date', 'asc')
        ->orderBy('appointment_time', 'asc')
        ->get()
        ->map(function($apt) use ($patient) {
            $apt->doctor_name = $apt->doctor ? $apt->doctor->name : 'N/A';

            // Get appointment for details using the new accessor
            $appointmentFor = $apt->appointment_for;

            if ($appointmentFor && $appointmentFor['type'] === 'family') {
                // Family member appointment
                $apt->patient_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                $apt->patient_first_name = $appointmentFor['first_name'];
                $apt->patient_last_name = $appointmentFor['last_name'];
                $apt->member_name = $appointmentFor['first_name'] . ' ' . $appointmentFor['last_name'];
                $apt->relationship = $appointmentFor['relationship'];
                $apt->is_family_member = true;
            } else {
                // Self appointment
                $apt->patient_name = $patient->first_name . ' ' . $patient->last_name;
                $apt->patient_first_name = $patient->first_name;
                $apt->patient_last_name = $patient->last_name;
                $apt->member_name = null;
                $apt->relationship = 'Self';
                $apt->is_family_member = false;
            }

            return $apt;
        });

    return view('patient.appointment-dashboard', compact('doctors', 'appointments'));
}

    public function verifyEmail($token)
    {
        try {
            $patient = Patient::where('verification_token', $token)->first();

            if (!$patient) {
                Log::error('Invalid verification token: ' . $token);
                return redirect()->route('patient.signin')->with('error', 'Invalid or expired verification link.');
            }

            $patient->email_verified_at = now();
            $patient->verification_token = null;
            $patient->save();

            Log::info('Patient email verified: ' . $patient->email);

            Auth::guard('patient')->login($patient);

            return redirect()->route('patient.signin')->with('success', 'Email verified successfully! You can now log in.');
        } catch (\Exception $e) {
            Log::error('Email verification error: ' . $e->getMessage());
            return redirect()->route('patient.signin')->with('error', 'Email verification failed. Please try again.');
        }
    }

    public function forgotPassword(Request $request)
    {
        Log::info('Patient Forgot Password Attempt:', $request->only('email'));

        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|string|min:6',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'Password must be at least 6 characters.',
            'confirm_password.required' => 'Confirm password is required.',
            'confirm_password.same' => 'Passwords do not match.',
        ]);

        try {
            $patient = Patient::where('email', $request->email)->first();

            if (!$patient) {
                Log::warning('Patient forgot password - email not found: ' . $request->email);
                return back()->withErrors(['email' => 'No account found with this email address.']);
            }

            $token = \Illuminate\Support\Str::random(64);

            PasswordResetToken::where('email', $request->email)->delete();

            PasswordResetToken::create([
                'email' => $request->email,
                'token' => $token,
                'new_password' => Hash::make($request->new_password),
                'created_at' => now(),
            ]);

            Log::info('Attempting to send password reset email to patient: ' . $patient->email);

            try {
                \Illuminate\Support\Facades\Mail::send('emails.patient_reset_password', [
                    'token' => $token,
                    'patient' => $patient
                ], function ($message) use ($patient) {
                    $message->to($patient->email);
                    $message->subject('Reset Your Password - OurPhoneMD');
                });

                Log::info('Password reset email sent to patient: ' . $patient->email);
                return back()->with('success', 'Password reset email sent! Please check your email.');
            } catch (\Exception $e) {
                Log::error('Failed to send password reset email to patient: ' . $e->getMessage());
                return back()->with('error', 'Failed to send reset email. Please try again.');
            }
        } catch (\Exception $e) {
            Log::error('Patient forgot password error: ' . $e->getMessage());
            return back()->with('error', 'Failed to process password reset. Please try again.');
        }
    }

    public function confirmReset($token)
    {
        try {
            $resetToken = PasswordResetToken::where('token', $token)->first();

            if (!$resetToken || $resetToken->created_at < now()->subMinutes(60)) {
                if ($resetToken) {
                    $resetToken->delete();
                }
                Log::warning('Invalid or expired patient reset token: ' . $token);
                return redirect()->route('patient.signin')->with('error', 'Invalid or expired reset link.');
            }

            $patient = Patient::where('email', $resetToken->email)->first();

            if (!$patient) {
                $resetToken->delete();
                Log::error('Patient not found for reset token: ' . $resetToken->email);
                return redirect()->route('patient.signin')->with('error', 'Account not found.');
            }

            if (!$resetToken->new_password) {
                $resetToken->delete();
                Log::error('No new password in reset token for patient: ' . $patient->email);
                return redirect()->route('patient.signin')->with('error', 'Invalid reset link.');
            }

            $patient->password = $resetToken->new_password;
            $patient->save();

            $resetToken->delete();

            Log::info('Patient password reset successful: ' . $patient->email);

            // Auto login after password reset
            Auth::guard('patient')->login($patient);

            return redirect()->route('patient.homepage')->with('success', 'Your password has been updated successfully. You are now logged in.');
        } catch (\Exception $e) {
            Log::error('Patient password reset confirmation error: ' . $e->getMessage());
            return redirect()->route('patient.signin')->with('success', 'Your password has been updated successfully. You are now logged in.');
        }
    }


    public function bookAppointment(Request $request)
    {
        Log::info('Book Appointment Request:', $request->all());

        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            Log::error('Patient not authenticated');
            return redirect()->route('patient.signin');
        }

        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after:today',
            'appointment_time' => 'required',
            'symptoms' => 'required|string|max:1000',
            'priority' => 'required|in:normal,urgent',
        ]);

        try {
            Log::info('Creating appointment for patient: ' . $patient->id);

            // Check if doctor already has an appointment at same time
            $existingAppointment = Appointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('appointment_time', $request->appointment_time)
                ->whereNotIn('status', ['cancelled'])
                ->first();

            if ($existingAppointment) {
                Log::warning('Doctor already has an appointment at this time');
                return back()->withErrors(['error' => 'This time slot is already booked for the selected doctor. Please choose a different time.']);
            }

            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'symptoms' => $request->symptoms,
                'priority' => $request->priority,
                'status' => 'pending',
                'token' => \Illuminate\Support\Str::random(24),
            ]);

            Log::info('Appointment created successfully: ' . $appointment->id);

            return redirect()->route('patient.appointment.dashboard')
                ->with('success', 'Appointment booked successfully! You will receive a confirmation notification.');
        } catch (\Exception $e) {
            Log::error('Appointment booking error: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            return back()->withErrors(['error' => 'Failed to book appointment. Please try again. Error: ' . $e->getMessage()]);
        }
    }
    public function cancelAppointment($id)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        try {
            $appointment = Appointment::where('id', $id)
                ->where('patient_id', $patient->id)
                ->firstOrFail();

            if ($appointment->status === 'confirmed') {
                return back()->withErrors(['error' => 'Cannot cancel confirmed appointment. Please contact hospital.']);
            }

            $appointment->update(['status' => 'cancelled']);

            return back()->with('success', 'Appointment cancelled successfully.');
        } catch (\Exception $e) {
            Log::error('Appointment cancellation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to cancel appointment.']);
        }
    }

    public function showProfile()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        // Ensure $patient is a Patient model instance
        if (!$patient instanceof Patient) {
            Log::error('Patient is not a Patient model instance: ' . get_class($patient));
            return back()->withErrors(['error' => 'Authentication error. Please try logging in again.']);
        }

        $messages = [
            'first_name.required' => 'First name is required.',
            'first_name.regex' => 'Special characters and numbers are not allowed.',
            'last_name.required' => 'Last name is required.',
            'last_name.regex' => 'Special Characters and numbers are not allowed.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'date_of_birth.required' => 'Date of birth is required.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'cnic.required' => 'CNIC number is required.',
            'cnic.unique' => 'This CNIC is already registered.',
            'contact_number.required' => 'Contact number is required.',
            'emergency_contact.required' => 'Emergency contact is required.',
            'address.required' => 'Address is required.',
            'city.required' => 'City is required.',
            'state.required' => 'State is required.',
            'zip_code.required' => 'ZIP code is required.',
            'blood_group.required' => 'Please select your blood group.',
            'blood_group.in' => 'Please select a valid blood group.',
        ];

        $validator = Validator::make($request->all(), [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s]+$/'
            ],
            'email' => 'required|string|email|max:255|unique:patients,email,' . $patient->id,
            'contact_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date|before:today',
            'cnic' => 'required|string|max:15|unique:patients,cnic,' . $patient->id,
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'gender' => 'nullable|in:male,female,other',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'emergency_contact' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'medical_history' => 'nullable|string|max:1000',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $dateOfBirth = new \DateTime($request->date_of_birth);
            $today = new \DateTime();
            $age = $today->diff($dateOfBirth)->y;

            // Use fill() and save() instead of update() to be more explicit
            $patient->fill([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
                'age' => $age,
                'cnic' => $request->cnic,
                'blood_group' => $request->blood_group,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'emergency_contact' => $request->emergency_contact,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'zip_code' => $request->zip_code,
                'medical_history' => $request->medical_history,
            ]);

            $patient->save();

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            Log::error('Patient profile update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to update profile. Please try again.']);
        }
    }

    public function visits()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.visits');
    }

    public function walkin()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.walkin');
    }

    public function notes()
    {
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->route('patient.signin');
        }

        return view('patient.notes');
    }

        public function appointmentDetails($token)
        {
            $patient = Auth::guard('patient')->user();
            if (!$patient) {
                return redirect()->route('patient.signin');
            }

            $appointment = Appointment::where('token', $token)
                ->where('patient_id', $patient->id)
                ->with(['doctor', 'familyMember', 'patient', 'payment'])
                ->firstOrFail();

            return view('patient.appointment-details', compact('appointment'));
        }


}
