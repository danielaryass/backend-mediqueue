<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
// User update
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    //
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (User::where('email', $data['email'])->exists()) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Email already exists',
                    ],
                ],
            ], 400);
        }
        $user = User::create($data);
        $user->password = Hash::make($data['password']);
        $user->save();
        $user->assignRole('User');
        $token = $user->createToken('auth_token')->plainTextToken;

        return (new UserResource($user))->additional([
            'token' => $token,
        ])->response()->setStatusCode(201)->withCookie('token', $token, 60 * 24 * 7);
    }

    public function login(UserLoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        if (Auth::attempt($data)) {
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;
            return (new UserResource($user))->additional(['token' => $token])
                ->response()->setStatusCode(200)->withCookie('token', $token, 60 * 24 * 7);
        }
        return response()->json([
            'errors' => [
                'message' => [
                    'email or password is incorrect',
                ],
            ],
        ], 401);
    }

    public function get(Request $request): JsonResponse
    {
        // cek apakah user sudah login

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
        return (new UserResource($user))->response()->setStatusCode(200);
    }

    public function addUser(Request $request): JsonResponse
    {
        //  abort_if(Gate::denies('Super Admin'), Response::HTTP_FORBIDDEN, response()->json(['error' => 'Forbidden']));

        if (Gate::denies('Akses Admin')) {
            return response()->json([
                'errors' => [
                    'message' => [
                        'You dont have permission to this action',
                    ],
                ],
            ], 403);
        }
        $auth = Auth::user();

        $data = $request->all();
        if (User::where('email', $data['email'])->exists()) {
            return response()->json([
                'errors' => [
                    'email' => [
                        'Email already exists',
                    ],
                ],
            ], 400);
        }
        $newUser = User::create($data);
        $newUser->password = Hash::make($data['password']);
        $newUser->save();
        $newUser->assignRole($data['role']);
        return (new UserResource($newUser))->response()->setStatusCode(201);
    }

    public function update(UserUpdateRequest $request): UserResource
    {
        $data = $request->validated();
        $user = Auth::user();

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return new UserResource($user);
    }

    public function logout(Request $request): JsonResponse
    {
        // $request->user()->currentAccessToken()->delete();
        // send token with authorization how to delete on personal access token
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'User logged out.',
            'token' => null,
        ], 200);
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->tokens()->delete();
        $user->delete();
        return response()->json([
            'message' => 'User deleted.',
            'token' => null,
        ], 200);
    }
}
