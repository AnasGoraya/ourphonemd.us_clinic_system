<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;

class PatientPaymentController extends Controller
{
    /**
     * Process a payment using Stripe token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */



public function pay(Request $request)
{
    $request->validate([
        'cardName' => 'required|string',
        'cardNumber' => 'required|string',
        'cardExpMonth' => 'required|string',
        'cardExpYear' => 'required|string',
        'cardCVC' => 'required|string',
    ]);

    Stripe::setApiKey(config('services.stripe.secret'));

    try {
        // For testing, use Stripe test token instead of raw card data
        // Use test token: tok_visa (successful) or tok_chargeDeclined (declined)
        $testToken = 'tok_visa'; // This will always succeed in test mode

        // Log the token being sent to Stripe for debugging
        Log::info('=== STRIPE PAYMENT PROCESSING ===');
        Log::info('Stripe Payment Token: ' . $testToken);
        Log::info('Card Details Submitted: Name=' . $request->cardName . ', Number=' . substr($request->cardNumber, -4) . ', Exp=' . $request->cardExpMonth . '/' . $request->cardExpYear);
        Log::info('Sending token to Stripe API...');

        $charge = Charge::create([
            'amount' => 10000, // $100 in cents
            'currency' => 'usd',
            'description' => 'Appointment payment',
            'source' => $testToken,
        ]);

        Log::info('Stripe API Response - Charge ID: ' . $charge->id . ', Status: ' . $charge->status);
        Log::info('✅ PAYMENT SUCCESSFUL: Token tok_visa was sent to Stripe and processed successfully!');
        Log::info('✅ APPOINTMENT WILL BE CREATED NOW');

        // Get patient before creating payment record
        $patient = Auth::guard('patient')->user();

        // Store payment record in database
        $payment = \App\Models\Payment::create([
            'patient_id' => $patient->id,
            'stripe_charge_id' => $charge->id,
            'stripe_token' => $testToken,
            'amount' => 100.00, // $100
            'currency' => 'usd',
            'status' => $charge->status,
            'description' => 'Appointment payment',
            'card_details' => [
                'name' => $request->cardName,
                'number_last4' => substr($request->cardNumber, -4),
                'exp_month' => $request->cardExpMonth,
                'exp_year' => $request->cardExpYear,
            ],
            'stripe_response' => $charge->toArray(),
            'processed_at' => now(),
        ]);

        Log::info('Payment record saved to database: ID ' . $payment->id);
        $wizardData = session('appointment_wizard');

        if (!$wizardData) {
            return redirect()->route('patient.appointments.new')->withErrors(['error' => 'Session expired. Please start over.']);
        }

        // Check if doctor already has an appointment at same time
        $existingAppointment = \App\Models\Appointment::where('doctor_id', $wizardData['step3']['doctor_id'])
            ->where('appointment_date', $wizardData['step3']['appointment_date'])
            ->where('appointment_time', $wizardData['step3']['appointment_time'])
            ->whereNotIn('status', ['cancelled'])
            ->first();

        if ($existingAppointment) {
            return redirect()->route('patient.appointments.wizard.step4')->withErrors(['error' => 'This time slot is already booked for the selected doctor. Please choose a different time.']);
        }

        // Create the appointment
        $appointment = \App\Models\Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $wizardData['step3']['doctor_id'],
            'appointment_date' => $wizardData['step3']['appointment_date'],
            'appointment_time' => $wizardData['step3']['appointment_time'],
            'symptoms' => $wizardData['step3']['symptoms'],
            'priority' => $wizardData['step1']['is_adhd_appointment'] ? 'urgent' : 'normal',
            'status' => 'confirmed', // Set to confirmed after payment
            'appointment_mode' => $wizardData['step3']['appointment_mode'] ?? 'in-person'
        ]);

        // Update payment with appointment_id
        $payment->update(['appointment_id' => $appointment->id]);

        Log::info('Appointment created and linked to payment: Appointment ID ' . $appointment->id);

        // Clear the wizard session
        session()->forget('appointment_wizard');

        return redirect()->route('patient.appointment.dashboard')->with('success', 'Appointment booked successfully! Payment processed.');
    } catch (ApiErrorException $e) {
        // Pass Stripe error to the view
        return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => $e->getMessage()]);
    } catch (\Exception $e) {
        // Pass any other error to the view
        return redirect()->route('patient.appointments.wizard.step4')->withErrors(['payment' => $e->getMessage()]);
    }
}

}
