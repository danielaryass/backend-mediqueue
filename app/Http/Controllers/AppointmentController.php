<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private function checkUserAuthorization()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'unauthorized',
                    ],
                ],
            ], 401);
        }
        return $user;
    }
    public function createAppointment(AppointmentCreateRequest $request)
    {
        $user = $this->checkUserAuthorization();
        $data = $request->validated();
        $doctor = Doctor::find($request->doctor_id);
        $startTime = Carbon::createFromFormat('H:i:s', $doctor->start_time);
        $CheckAppointmentQueue = Appointment::where('appointment_date', $request->appointment_date)->where('doctor_id', $request->doctor_id)->get();
        $appointmentTime = $startTime->addMinutes(30*$CheckAppointmentQueue->count())->format('H:i:s');
        $inisial = implode('', array_map(fn($word) => strtoupper(substr($word, 0, 1)), explode(' ', $doctor->name)));
        $data['user_id'] = auth()->user()->id;
        $data['appointment_code'] = $inisial . '-' . $request->appointment_date .($CheckAppointmentQueue->count()+1);
        $data['status'] = 'Waiting';
        $data['no_queue'] = $CheckAppointmentQueue->count() + 1;
        $data['appointment_time'] = $appointmentTime;
        Appointment::create($data);
        return response()->json([
            'message' => 'Success',
            'data' => $appointment
        ], 201);
    }
}
