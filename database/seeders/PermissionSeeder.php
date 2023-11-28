<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'Akses Admin', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Akses User', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Akses Suster', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Akses Doctor', 'guard_name' => 'sanctum']);
    }
}
