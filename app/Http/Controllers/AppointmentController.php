<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AppointmentCreateRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;


class AppointmentController extends Controller
{
    public function createAppointment(AppointmentCreateRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::find($request->doctor_id);
        $start_hour = Carbon::createFromFormat('H:i:s', $doctor->start_hour);
        $CheckAppointmentQueue = Appointment::where('appointment_date', $request->appointment_date)->where('doctor_id', $request->doctor_id)->get();
        $appointment_time = $start_hour->addMinutes(30*$CheckAppointmentQueue->count())->format('H:i:s');
        $inisial = implode('', array_map(fn($word) => strtoupper(substr($word, 0, 1)), explode(' ', $doctor->name)));
        $data['user_id'] = auth()->user()->id;
        $data['appointment_code'] = $inisial . '-' . $request->appointment_date .($CheckAppointmentQueue->count()+1);
        $data['status'] = 'Waiting';
        $data['no_queue'] = $CheckAppointmentQueue->count() + 1;
        $data['appointment_time'] = $appointment_time;
        $appointment = Appointment::create($data);
        return response()->json([
            'message' => 'Success',
            'data' => $appointment
        ], 201);
    }
}
