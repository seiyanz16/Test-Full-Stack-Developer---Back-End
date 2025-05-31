<?php

namespace App\Services;

use App\Exceptions\AuthenticationException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService implements UserInterface
{
    
    public function index(Request $request)
    {
        return User::all();
    }

    public function store(StoreUserRequest $request)
    {
        $payload = [
            ...$request->validated(),
        ];

        return User::create($payload);
    }

    public function edit(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found.");
        }

        return $user;
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found.");
        }

        $payload = [
            ...$request->validated(),
        ];

        if (isset($payload['password']) && !empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        } else {
            unset($payload['password']);
        }

        $user->update($payload);

        return $user;
    }


    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            throw new ModelNotFoundException("User not found.");
        }

        $user->delete();

        return $user;
    }
}
