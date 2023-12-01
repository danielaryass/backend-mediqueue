<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use App\Models\Doctor;


class DoctorTest extends TestCase
{
    private function login(): string
    {
        $this->seed(UserSeeder::class);
        $this->post('api/users/login', [
            'email' => 'admin@mail.com',
            'password' => '123456789',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Super Admin',
                'email' => 'admin@mail.com',
            ],
        ]);
        $user = User::where('email', 'admin@mail.com')->first();
        return $user->createToken('auth_token')->plainTextToken;
    }

    private function createDoctor(string $token): Doctor
    {
        $user = User::where('email', 'admin@mail.com')->first();
        $this->post('/api/doctors', [
            'Authorization' => 'Bearer ' . $token,
            'name' => 'Daniel',
            'user_id' => $user->id,
            'start_hour' => '08:00',
            'end_hour' => '16:00',
        ])->assertStatus(201)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'user_id' => $user->id,
                'start_hour' => '08:00',
                'end_hour' => '16:00',
            ],
        ]);
        return Doctor::where('name', 'Daniel')->first();
    }

    public function testGetDoctors(): void
    {
        $token = $this->login();
        $this->get('/api/doctors', [
            'Authorization' => 'Bearer ' . $token,
        ])->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'List All Doctor',
        ]);
    }

    public function testCreateDoctor(): void
    {
        $token = $this->login();
        $this->createDoctor($token);
    }

    public function testGetDetailDoctor(): void
    {
        $token = $this->login();
        $doctor = $this->createDoctor($token);
        $this->get('/api/doctors/' . $doctor->id, [
            'Authorization' => 'Bearer ' . $token,
        ])->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Detail Doctor',
        ]);
    }

    public function testUpdateDoctor(): void
    {
        $token = $this->login();
        $doctor = $this->createDoctor($token);
        $this->patch('/api/doctors/' . $doctor->id, [
            'Authorization' => 'Bearer ' . $token,
            'name' => 'Daniel Arya',
            'user_id' => $doctor->user_id,
            'start_hour' => '08:00',
            'end_hour' => '16:00',
        ])->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'Doctor updated successfully.',
            'data' => [
                'name' => 'Daniel Arya',
                'user_id' => $doctor->user_id,
                'start_hour' => '08:00',
                'end_hour' => '16:00',
            ],
        ]);
    }

    public function testUpdateDoctorFailed(): void 
    {
        $token = $this->login();
        $doctor = $this->createDoctor($token);
        $this->patch('/api/doctors/100', [
            'Authorization' => 'Bearer ' . $token,
            'name' => 'Daniel Arya',
            'user_id' => $doctor->user_id,
            'start_hour' => '08:00',
            'end_hour' => '16:00',
        ])->assertStatus(404)->assertJson([
            'success' => false,
            'message' => 'Doctor not found',
            'data' => '',
        ]);
    }

    public function testGetDoctorsWithRoles(): void
    {
        $token = $this->login();
        $this->get('/api/doctors/user', [
            'Authorization' => 'Bearer ' . $token,
        ])->assertStatus(200)->assertJson([
            'success' => true,
            'message' => 'List All User With Role Doctor',
        ]);
    }
    
}