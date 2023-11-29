<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\DoctorRequest;


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

    public function addDoctor(DoctorRequest $request)
    {
        $request->validated();

        // Membuat objek Doctor
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
        // Mencari Doctor berdasarkan id
        $doctor = Doctor::findOrFail($id);

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
        // Mencari Doctor berdasarkan id
        $doctor = Doctor::findOrFail($id);

        // Mengembalikan response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Doctor',
            'data' => $doctor,
        ], 200);
    }
}
