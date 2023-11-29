<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = [
            [
                'name'           => 'Super Admin',
                'email'          => 'admin@mail.com',
                'password'       => Hash::make('123456789'),
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        User::insert($user);
        // user find by email
        $user = User::where('email', 'admin@mail.com')->first();
        // get role super admin
        $user->assignRole('Super Admin');

        $doctor = [
            'name' => 'Daniel',
            'email' => 'daniel.aryass7@gmail.com',
            'password' => Hash::make('12345678'),
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s'),
        ];
        User::insert($doctor);
        $doctor = User::where('email', 'daniel.aryass7@gmail.com')->first();
        $doctor->assignRole('Doctor');
        
    }
}
