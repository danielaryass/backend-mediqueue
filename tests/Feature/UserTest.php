<?php

namespace Tests\Feature;

use App\Models\User;
//
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testRegisterSuccess(): void
    {
        $this->post('/api/users', [
            'email' => 'daniel.aryass7@gmail.com',
            'name' => 'Daniel',
            'password' => '12345678',
        ])->assertStatus(201)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
    }

    public function testRegisterFail(): void
    {
        $this->post('api/users', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345',
            'name' => 'Daniel',
        ])->assertStatus(400)->assertJson([
            'errors' => [
                'password' => [
                    'The password field must be at least 8 characters.',
                ],
            ],
        ]);

        $this->post('api/users', [
            'email' => '',
            'password' => '',
            'name' => ''])->assertStatus(400)->assertJson([
            'errors' => [
                'email' => [
                    'The email field is required.',
                ],
                'password' => [
                    'The password field is required.',
                ],
                'name' => [
                    'The name field is required.',
                ],
            ],
        ]);
    }

    public function testRegisterEmailExists(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users', [
            'email' => 'daniel.aryass7@gmail.com',
            'name' => 'Daniel',
            'password' => '12345678'])->assertStatus(400)->assertJson([
            'errors' => [
                'email' => [
                    'The email has already been taken.',
                ],
            ],
        ]);
    }

    public function testLoginSuccess(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        $this->assertDatabaseHas('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'auth_token',
        ]);
    }

    public function testLoginFailed(): void
    {
        $this->post('api/users/login', [
            'email' => 'admin@mail.com',
            'password' => '12345678',
        ])->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'email or password is incorrect',
                ],
            ],
        ]);
    }

    public function testLoginWrongPassword(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '123456789',
        ])->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'email or password is incorrect',
                ],
            ],
        ]);
    }
    public function testGetUser(): void
    {
        //    i want use authorization with token
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->get('api/users', [
            'Authorization' => 'Bearer ' . $token,
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ]]);
    }

    public function testGetUserFailed(): void
    {
        $this->get('api/users')->assertStatus(401)->assertJson([
            'errors' => [
                'message' => [
                    'unauthorized',
                ],
            ],
        ]);
    }

    public function testAddUser(): void
    {
        // use user seeders
        $this->seed(\Database\Seeders\UserSeeder::class);
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
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->post('api/adduser', [
            'Authorization' => 'Bearer ' . $token,
            'email' => 'admin22@gmail.com',
            'name' => 'admin',
            'password' => '12345678',
            'role' => 'Super Admin',
        ])->assertStatus(201)->assertJson([
            'data' => [
                'name' => 'admin',
                'email' => 'admin22@gmail.com',
                'role' => 'Super Admin',
            ],
        ]);
    }

    public function testAddUserNotByAdmin(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->post('api/adduser', [
            'Authorization' => 'Bearer ' . $token,
            'email' => 'admin22@gmail.com',
            'name' => 'admin',
            'password' => '12345678',
            'role' => 'Super Admin',
        ])->assertStatus(403)->assertJson([
            'errors' => [
                'message' => [
                    'You dont have permission to this action',
                ],
            ],
        ]);
    }

    public function testUpdateUserName(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->patch('api/users', [
            'Authorization' => 'Bearer ' . $token,
            'name' => 'Daniel Aryas',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel Aryas',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
    }

    public function testUpdateUserPassword(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->patch('api/users', [
            'Authorization' => 'Bearer ' . $token,
            'password' => '1234567890',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
    }

    public function testLogout(): void
    {
        $this->testRegisterSuccess();
        $this->post('api/users/login', [
            'email' => 'daniel.aryass7@gmail.com',
            'password' => '12345678',
        ])->assertStatus(200)->assertJson([
            'data' => [
                'name' => 'Daniel',
                'email' => 'daniel.aryass7@gmail.com',
            ],
        ]);
        $user = User::where('email', 'daniel.aryass7@gmail.com')->first();
        // get token from personal_access_tokens
        $token = $user->createToken('auth_token')->plainTextToken;
        $this->post('api/users/logout', [
            'Authorization' => 'Bearer ' . $token,
        ])->assertStatus(200)->assertJson([
            'message' => 'User logged out.',
            'token' => null,
        ]);
    }

    public function testDeleteUser(): void
    {
        $this->testAddUser();
        $user = User::where('email', 'admin22@gmail.com')->first();
    
        // Pastikan pengguna ada
        $this->assertNotNull($user);
    
        // Kirim permintaan DELETE ke endpoint penghapusan pengguna
        $this->delete('api/users/' . $user->id)
            ->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted.',
            ]);
    
        // Verifikasi bahwa pengguna telah dihapus dari database
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
