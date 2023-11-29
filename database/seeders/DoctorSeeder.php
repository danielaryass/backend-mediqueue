<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Doctor;


class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::role('doctor')->first();
        $doctor = [
            'name' => 'Daniel',
            'image_url' => 'https://i.ibb.co/0jZ3qYJ/doctor.jpg',
            'start_hour' => '08:00:00',
            'end_hour' => '16:00:00',
            'user_id' => $user->id,
        ];
        Doctor::insert($doctor);
    }
}
