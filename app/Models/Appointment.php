<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'appointment_type',
        'appointment_mode',
        'reason',
        'symptoms',
        'medications',
        'allergies',
        'work_notes',
        'alt_phone',
        'images',
        'medical_history',
        'notes',
        'priority',
        'status',
        'sent_to_doctor',
        'wizard_step1_data',
        'wizard_step2_data',
        'wizard_step3_data',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
