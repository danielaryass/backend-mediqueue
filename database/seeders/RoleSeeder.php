<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suster = Role::create(['name' => 'Suster', 'guard_name' => 'sanctum']);
        $user = Role::create(['name' => 'User', 'guard_name' => 'sanctum']);
        $doctor = Role::create(['name' => 'Doctor', 'guard_name' => 'sanctum']);
        $doctor->givePermissionTo('Akses Doctor');
        $suster->givePermissionTo('Akses Suster');
        $user->givePermissionTo('Akses User');
        $super = Role::create(['name' => 'Super Admin', 'guard_name' => 'sanctum']);
        $super->givePermissionTo('Akses Admin');

    }
}
