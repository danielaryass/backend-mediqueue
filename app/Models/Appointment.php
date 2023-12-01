<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable =[
        'appointment_code',
        'patient_name',
        'patient_phone_number',
        'patient_address',
        'appointment_date',
        'appointment_time',
        'no_queue',
        'status',
        'type_appointment',
        'user_id',
        'doctor_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
