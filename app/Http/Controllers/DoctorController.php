<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class DoctorController extends Controller
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
        if (Gate::denies('Akses Admin')) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }
        return $user;
    }
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
        $user = User::role('Doctor')->get();
        return response()->json([
            'success' => true,
            'message' => 'List All User With Role Doctor',
            'data' => $user,
        ], 200);
    }

    public function addDoctor(DoctorRequest $request)
    {
        $user = $this->checkUserAuthorization();
        if (!$user) {
            return $user;
        }

        $request->validated();

        // Membuat objek Doctor
        if (User::where('id', $request->user_id)->doesntExist()) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
                'data' => '',
            ], 404);
        }
        $doctor = new Doctor;
        $doctor->name = $request->name;
        $doctor->user_id = $request->user_id;
        $doctor->start_hour = $request->start_hour;
        $doctor->end_hour = $request->end_hour;

        // Membuat direktori jika tidak ada
        $path = public_path('app/public/assets/photo-doctor');
        if (!File::isDirectory($path)) {
            $response = Storage::makeDirectory('public/assets/photo-doctor');
        }

        // Mengelola unggahan file
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('assets/file-doctor', 'public');
            $doctor->image_url = $imagePath;
        } else {
            $doctor->image_url = '';
        }

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
        $user = $this->checkUserAuthorization();
        if (!$user) {
            return $user;
        }
        // $doctor = Doctor::findOrFail($id);
        $doctor = Doctor::where('id', $id)->first();
        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor not found',
                'data' => '',
            ], 404);
        }

        // Mengelola unggahan file
        if ($request->hasFile('image_url')) {
            // Menghapus file lama
            Storage::delete('public/' . $doctor->image_url);

            // Menyimpan file baru
            $imagePath = $request->file('image_url')->store('assets/file-doctor', 'public');
            $doctor->image_url = $imagePath;
        }

        // apabila input kosong, maka tetap menggunakan data yang lama
        $doctor->name = $request->name ?? $doctor->name;
        $doctor->user_id = $request->user_id ?? $doctor->user_id;
        $doctor->start_hour = $request->start_hour ?? $doctor->start_hour;
        $doctor->end_hour = $request->end_hour ?? $doctor->end_hour;
        // save
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
