<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {

        $doctor = Doctor::all();
        return response()->json([
            'success' => true,
            'message' => 'List All Doctor',
            'data' => $doctor,
        ], 200);
    }

    public function getUserWithRoleDoctor()
    {
        $user = Auth::user();
        if (!$user || $user = null) {
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
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }

        // $user = User::role('Doctor')->get();
        // paginate(10);
        $user = User::role('Doctor')->paginate(10);


        return response()->json([
            'success' => true,
            'message' => 'List All User With Role Doctor',
            'data' => $user-> items(),    
            'meta' => [
                'total' => $user->total(),
                'per_page' => $user->perPage(),
                'current_page' => $user->currentPage(),
                'last_page' => $user->lastPage(),
                'from' => $user->firstItem(),
                'to' => $user->lastItem(),
            ],
        ], 200);
    }

    public function addDoctor(DoctorRequest $request)
    {
        $user = Auth::user();
        if (!$user || $user = null) {
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
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }
        $doctor = new Doctor;
        $doctor->name = $request->name;
        $doctor->user_id = $request->user_id;
        $doctor->start_hour = $request->start_hour;
        $doctor->end_hour = $request->end_hour;


        // Mengelola unggahan file
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('assets/file-doctor', 'public');
            $doctor->image_url = $imagePath;
        } else {
            $doctor->image_url = '';
        }
        // dd($doctor->image_url);
        // Menyimpan data Doctor
        $doctor->save();

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Doctor created successfully.',
            'data' => $doctor,
        ], 201);
    }

    public function editDoctor(Request $request, $id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor not found',
                'data' => '',
            ],
                404);
        }
        $user = Auth::user();
        if (!$user || $user = null) {
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
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }

        
       
        // apabila input kosong, maka tetap menggunakan data yang lama
        $doctor->name = $request->name ?? $doctor->name;
        $doctor->user_id = $request->user_id ?? $doctor->user_id;
        $doctor->start_hour = $request->start_hour ?? $doctor->start_hour;
        $doctor->end_hour = $request->end_hour ?? $doctor->end_hour;
        // Mengelola unggahan file
        if ($request->hasFile('image_url')) {
            // Menghapus file lama
            Storage::delete('public/' . $doctor->image_url);

            // Menyimpan file baru
            $imagePath = $request->file('image_url')->store('assets/file-doctor', 'public');
            $doctor->image_url = $imagePath;
        }
        $doctor->save();

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Doctor updated successfully.',
            'data' => $doctor,
        ], 200);
    }

    public function getDetailDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Doctor',
            'data' => $doctor,
        ], 200);
    }
}
