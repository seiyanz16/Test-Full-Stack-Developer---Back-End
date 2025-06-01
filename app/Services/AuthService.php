<?php

namespace App\Services;

use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Interfaces\AuthInterface;

class AuthService implements AuthInterface
{

    public function register(AuthRequest $request)
    {
        \Log::info('register method called');

        $payload = $request->validated();

        $user = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => bcrypt($payload['password'])
        ]);

        $token = $user->createToken('laravelapp')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(AuthRequest $request)
    {
        $payload = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $payload['email'])->first();

        if (!$user || !Hash::check($payload['password'], $user->password)) {
            throw new ModelNotFoundException("Invalid credentials.");
        };

        $token = $user->createToken('laravelapp')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }
}
