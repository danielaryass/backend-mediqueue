<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentCreateRequest;
use App\Models\Appointment;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AppointmentController extends Controller
{

    // public function getAllAppointment()
    // {
    //     $user = auth()->user();
    //     if (!$user || $user = null) {
    //         return response()->json([
    //             'errors' => [
    //                 'message' => [
    //                     'unauthorized',
    //                 ],
    //             ],
    //         ], 401);
    //     }
    //     if (Gate::denies('Akses Admin')) {
    //         return response()->json([
    //             'errors' => [
    //                 'message' => [
    //                     'You dont have permission to this action',
    //                 ],
    //             ],
    //         ], 403);
    //     }
    //     $appointment = Appointment::all();
    //     return response()->json([
    //         'message' => 'Success',
    //         'data' => $appointment
    //     ], 200);
    // }
    public function getAllAppointment()
    {
        $user = auth()->user();

        if (!$user || $user == null) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'unauthorized',
                    ],
                ],
            ], 401);
        }

        if (Gate::denies('Akses Admin')) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'You dont have permission for this action',
                    ],
                ],
            ], 403);
        }

        // Use the paginate() method to get a paginated result
        // where date is now
        $appointments = Appointment::whereDate('appointment_date', Carbon::today())->paginate(10); // Adjust the number per page as needed
        // $appointments = Appointment::paginate(10); // Adjust the number per page as needed

        // Customize the response structure to include pagination information
        return response()->json([
            'message' => 'Success',
            'data' => $appointments,
            'pagination' => [
                'total' => $appointments->total(),
                'per_page' => $appointments->perPage(),
                'current_page' => $appointments->currentPage(),
                'last_page' => $appointments->lastPage(),
            ],
        ], 200);
    }
    public function createAppointment(AppointmentCreateRequest $request)
    {
        $data = $request->validated();
        $doctor = Doctor::find($request->doctor_id);
        $start_hour = Carbon::createFromFormat('H:i:s', $doctor->start_hour);
        $CheckAppointmentQueue = Appointment::where('appointment_date', $request->appointment_date)->where('doctor_id', $request->doctor_id)->get();
        $appointment_time = $start_hour->addMinutes(30 * $CheckAppointmentQueue->count())->format('H:i:s');
        $inisial = implode('', array_map(fn($word) => strtoupper(substr($word, 0, 1)), explode(' ', $doctor->name)));
        $data['user_id'] = auth()->user()->id;
        $data['appointment_code'] = $inisial . '-' . $request->appointment_date . ($CheckAppointmentQueue->count() + 1);
        $data['status'] = 'Waiting';
        $data['no_queue'] = $CheckAppointmentQueue->count() + 1;
        $data['appointment_time'] = $appointment_time;
        $appointment = Appointment::create($data);
        return response()->json([
            'message' => 'Success',
            'data' => $appointment,
        ], 201);
    }

    public function getAppointment(Request $request)
    {
        $user = auth()->user();
        $appointment = Appointment::where('user_id', $user->id)->get();
        return response()->json([
            'message' => 'Success',
            'data' => $appointment,
        ], 200);
    }

    public function getDetailAppointment($id)
    {
        $appointment = Appointment::where('id', $id)->first();
        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Success',
            'data' => $appointment,
        ], 200);
    }

    public function setStatusToMissing(Request $request, $id)
    {
        if (Gate::denies('Akses Admin')) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        }
        if ($appointment->status == 'Waiting') {
            $appointment->status = 'Missing';
            $appointment->save();
            return response()->json([
                'message' => 'Success',
                'data' => $appointment,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Appointment is not Waiting',
            ], 400);
        }
    }

    public function setStatusToCompleted(Request $request, $id)
    {
        if (Gate::denies('Akses Admin')) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json([
                'message' => 'Appointment not found',
            ], 404);
        }
        if ($appointment->status == 'Waiting' || $appointment->status == 'Missing') {
            $appointment->status = 'Completed';
            $appointment->save();
            return response()->json([
                'message' => 'Success',
                'data' => $appointment,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Appointment is not Waiting or Missing',
            ], 400);
        }
    }
}
